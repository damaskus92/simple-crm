<?php

use App\Models\Company;
use App\Models\Employee;
use App\Models\Role;

use function Pest\Laravel\{getJson, postJson, putJson, deleteJson, actingAs, assertDatabaseHas};

beforeEach(function () {
    // Create company
    $company = Company::create([
        'name' => 'Test Company',
        'email' => 'test@company.com',
        'phone' => '1234567890',
    ]);

    // Create multiple roles
    $role = Role::factory()
        ->count(2)
        ->sequence(
            ['name' => 'Manager'],
            ['name' => 'Employee']
        )
        ->create();

    // Create employee and assign manager role
    $manager = Employee::factory()->create(['company_id' => $company->id]);
    $manager->account->update(['role_id' => $role[0]->id]);

    // Create employee
    $employee = Employee::factory()->create([
        'company_id' => $company->id,
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'phone' => '1234567890',
        'address' => '123 Main St',
    ]);

    // Define data to use in testing
    $this->user = $manager->account;
    $this->company = $company;
    $this->employee = $employee;
    $this->employeeRole = $role[1];
});

// Testing for index method
describe('index', function () {
    it("can fetch list of all employees", function () {
        actingAs($this->user, 'api');

        Employee::factory()
            ->create([
                'company_id' => $this->company->id,
            ]);

        getJson('/api/employees')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'email', 'phone', 'address'],
                ],
            ]);
    });

    it("can't fetch list of all employees without auth", function () {
        getJson('/api/employees')
            ->assertUnauthorized();
    });
});

// Testing for store method
describe('store', function () {
    it("can create employee with valid data", function () {
        actingAs($this->user, 'api');

        $payload = [
            'name' => 'Kato Trevino',
            'email' => 'katotrevino340@example.test',
            'phone' => '62352673461',
            'address' => '996-5174 Dictum Rd',
        ];

        postJson('/api/employees', $payload)
            ->assertCreated()
            ->assertJson([
                'data' => [
                    'name' => 'Kato Trevino',
                    'email' => 'katotrevino340@example.test',
                    'phone' => '62352673461',
                    'role' => [
                        'name' => $this->employeeRole->name,
                    ],
                ],
            ]);

        assertDatabaseHas('employees', [
            'name' => 'Kato Trevino',
            'email' => 'katotrevino340@example.test',
            'phone' => '62352673461',
        ]);
    });

    it("can't create employee with invalid data", function () {
        actingAs($this->user, 'api');

        postJson('/api/employees', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'phone']);
    });

    it("can't create employee with duplicate data", function () {
        actingAs($this->user, 'api');

        $payload = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890',
        ];

        postJson('/api/employees', $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'phone']);
    });

    it("can't create employee without auth", function () {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890',
        ];

        postJson('/api/employees', $payload)
            ->assertUnauthorized();
    });
});

// Testing for show method
describe('show', function () {
    it("can fetch a specific employee", function () {
        actingAs($this->user, 'api');

        getJson("/api/employees/{$this->employee->id}")
            ->assertOk()
            ->assertJson([
                'message' => 'Successfully fetch record.',
                'data' => [
                    'name' => $this->employee->name,
                    'email' => $this->employee->email,
                    'role' => [
                        'name' => $this->employeeRole->name,
                    ],
                ],
            ]);
    });

    it("can't fetch specific employee that are not in database", function () {
        actingAs($this->user, 'api');

        getJson('/api/employees/5')
            ->assertNotFound();
    });

    it("can't fetch specific employee without auth", function () {
        getJson("/api/employees/{$this->employee->id}")
            ->assertUnauthorized();
    });
});

// Testing for update method
describe('update', function () {
    it("can update employee with valid data", function () {
        actingAs($this->user, 'api');

        $updateData = [
            'name' => 'Kato Trevino',
            'email' => 'katotrevino340@example.test',
        ];

        putJson("/api/employees/{$this->employee->id}", $updateData)
            ->assertOk()
            ->assertJson([
                'message' => 'Record successfully updated.',
                'data' => [
                    'name' => 'Kato Trevino',
                    'email' => 'katotrevino340@example.test',
                ],
            ]);

        assertDatabaseHas('employees', [
            'name' => 'Kato Trevino',
            'email' => 'katotrevino340@example.test',
        ]);
    });

    it("can't update employee with duplicate data", function () {
        actingAs($this->user, 'api');

        $updateData = [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
        ];

        putJson("/api/employees/{$this->employee->id}", $updateData)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'phone']);
    });

    it("can't update employee without auth", function () {
        putJson("/api/employees/{$this->employee->id}")
            ->assertUnauthorized();
    });
});

// Testing for destroy method
describe('destroy', function () {
    it('can delete employee', function () {
        actingAs($this->user, 'api');

        deleteJson("/api/employees/{$this->employee->id}")
            ->assertOk()
            ->assertJson(['message' => 'Record successfully deleted.']);

        expect(Employee::find($this->employee->id))
            ->toBeNull();
        expect(Employee::withTrashed()->find($this->employee->id))
            ->not
            ->toBeNull();
    });

    it("can't delete employee without auth", function () {
        deleteJson("/api/employees/{$this->employee->id}")
            ->assertUnauthorized();
    });
});
