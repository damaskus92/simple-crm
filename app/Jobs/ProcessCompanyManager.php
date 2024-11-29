<?php

namespace App\Jobs;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessCompanyManager implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Company $company,
        public array $employeeData,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get the manager role
        $role = Role::where('name', 'Manager')->first();

        // Create the user
        $user = User::create([
            'name' => $this->employeeData['name'],
            'email' => $this->employeeData['email'],
            'password' => bcrypt('initialpassword'),
            'role_id' => $role->id
        ]);

        // Create the employee
        Employee::withoutEvents(function () use ($user) {
            Employee::create([
                'company_id' => $this->company->id,
                'name' => $this->employeeData['name'],
                'email' => $this->employeeData['email'],
                'account_id' => $user->id
            ]);
        });
    }
}
