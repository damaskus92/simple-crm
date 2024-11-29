<?php

use App\Jobs\ProcessCompanyManager;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Queue;

use function Pest\Laravel\{actingAs, deleteJson, getJson, postJson};

beforeEach(function () {
    // Create company
    $company = Company::create([
        'name' => 'Test Company',
        'email' => 'test@company.com',
        'phone' => '1234567890',
    ]);

    // Create multiple roles
    $role = Role::factory()
        ->count(3)
        ->sequence(
            ['name' => 'Super Admin'],
            ['name' => 'Manager'],
            ['name' => 'Employee']
        )
        ->create();

    // Create user with the Super Admin role
    $admin = User::factory()->create(['role_id' => $role[0]->id]);

    $this->user = $admin;
    $this->company = $company;
});

describe('index', function () {
    it("can fetch list of all companies", function () {
        actingAs($this->user, 'api');

        getJson('/api/companies')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    ['id', 'name', 'email', 'phone']
                ],
            ]);
    });

    it("can't allow fetch list of all companies without auth", function () {
        getJson('/api/companies')
            ->assertUnauthorized();
    });
});

describe('store', function () {
    it("can create new company with valid data", function () {
        actingAs($this->user, 'api');

        Queue::fake();

        $payload = [
            'name' => 'New Company',
            'email' => 'company@example.com',
            'phone' => '123456789',
            'manager' => [
                'name' => 'Manager Name',
                'email' => 'manager@example.com',
            ],
        ];

        postJson('/api/companies', $payload)
            ->assertCreated()
            ->assertJson([
                'message' => 'The company has been created.',
                'data' => ['name' => 'New Company'],
            ]);

        Queue::assertPushed(ProcessCompanyManager::class, function ($job) use ($payload) {
            return $job->employeeData['name'] === $payload['manager']['name'];
        });
    });

    it("can't allow create new company with invalid data", function () {
        actingAs($this->user, 'api');

        $payload = [];

        postJson('/api/companies', $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'phone', 'manager']);
    });

    it("can't allow create new company without auth", function () {
        $payload = [
            'name' => 'New Company',
            'email' => 'company@example.com',
            'phone' => '123456789',
            'manager' => [
                'name' => 'Manager Name',
                'email' => 'manager@example.com',
            ],
        ];

        postJson('/api/companies', $payload)
            ->assertUnauthorized();
    });
});

describe('destroy', function () {
    it("can delete a company", function () {
        actingAs($this->user, 'api');

        deleteJson("/api/companies/{$this->company->id}")
            ->assertOk()
            ->assertJson([
                'message' => 'The company has been deleted.',
            ]);

        expect(Company::withTrashed()->find($this->company->id))
            ->not
            ->toBeNull();
        expect(Company::find($this->company->id))
            ->toBeNull();
    });

    it("can't allow delete a company without auth", function () {
        deleteJson("/api/companies/{$this->company->id}")
            ->assertUnauthorized();
    });
});
