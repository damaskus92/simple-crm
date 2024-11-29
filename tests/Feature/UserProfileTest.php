<?php

use App\Models\Company;
use App\Models\Employee;
use App\Models\User;

use function Pest\Laravel\{actingAs, getJson, postJson, putJson};

beforeEach(function () {
    // Create company
    $company = Company::create([
        'name' => 'Test Company',
        'email' => 'test@company.com',
        'phone' => '1234567890',
    ]);

    // Create employee profile
    $profile = Employee::withoutEvents(function () use ($company) {
        $profile = Employee::factory()->create([
            'company_id' => $company->id,
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
        ]);

        return $profile;
    });

    $this->profile = $profile;
});

describe('show', function () {
    it("can user to show profile", function (User $user) {
        $this->profile->update(['name' => $user->name, 'email' => $user->email,]);
        $user->profile()->save($this->profile);

        actingAs($user, 'api');

        getJson('/api/myprofile')
            ->assertOk()
            ->assertJson([
                'data' => [
                    'name' => $this->profile->name,
                    'email' => $this->profile->email,
                    'account' => [
                        'name' => $user->name,
                        'email' => $user->email
                    ]
                ],
            ]);
    })->with('users');

    it("can't user to show profile without token", function () {
        getJson('/api/myprofile')->assertUnauthorized();
    });
});

describe('update', function () {
    it("can user to update profile", function (User $user) {
        $this->profile->update(['name' => $user->name, 'email' => $user->email,]);
        $user->profile()->save($this->profile);

        actingAs($user, 'api');

        $updateData = [
            'name' => 'Kato Trevino',
            'email' => 'katotrevino340@example.test',
        ];

        putJson('/api/myprofile', $updateData)
            ->assertOk()
            ->assertJson([
                'data' => [
                    'name' => $updateData['name'],
                    'email' => $updateData['email'],
                    'account' => [
                        'name' => $updateData['name'],
                        'email' => $updateData['email'],
                    ]
                ],
            ]);
    })->with('users');

    it("can't user to show profile without token", function () {
        putJson('/api/myprofile')->assertUnauthorized();
    });
});
