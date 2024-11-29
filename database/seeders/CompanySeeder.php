<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $managerRole = Role::firstOrCreate(['name' => 'Manager']);
        $employeeRole = Role::firstOrCreate(['name' => 'Employee']);

        Company::factory()
            ->has(
                Employee::factory()
                    ->count(rand(3, 10))
                    ->afterCreating(function (Employee $employee, Company $company) use ($managerRole, $employeeRole) {
                        static $isFirst = true;

                        $employee->company()->associate($company);

                        $user = User::create([
                            'name' => $employee->name,
                            'email' => $employee->email,
                            'password' => bcrypt('password'),
                            'role_id' => $isFirst ? $managerRole->id : $employeeRole->id,
                        ]);

                        $employee->account()->associate($user);
                        $employee->save();

                        if ($isFirst) {
                            $isFirst = false;
                        }
                    })
            )
            ->create();
    }
}
