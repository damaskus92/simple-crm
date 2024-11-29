<?php

namespace App\Observers;

use App\Models\Employee;
use App\Models\Role;
use App\Models\User;

class EmployeeObserver
{
    /**
     * Handle the Employee "created" event.
     */
    public function created(Employee $employee): void
    {
        // Get the manager role
        $role = Role::where('name', 'Employee')->first();

        // Create the user
        $user = new User();
        $user->name = $employee->name;
        $user->email = $employee->email;
        $user->password = bcrypt('password');
        $user->role_id = $role->id;
        $user->save();

        // Assign user account to employee
        $employee->account()->associate($user);
        $employee->save();
    }

    /**
     * Handle the Employee "updated" event.
     */
    public function updated(Employee $employee): void
    {
        $employee->account()->update([
            'name' => $employee->name,
            'email' => $employee->email,
        ]);
    }

    /**
     * Handle the Employee "deleted" event.
     */
    public function deleted(Employee $employee): void
    {
        $employee->account()->delete();
    }

    /**
     * Handle the Employee "restored" event.
     */
    public function restored(Employee $employee): void
    {
        $employee->account()->restore();
    }

    /**
     * Handle the Employee "force deleted" event.
     */
    public function forceDeleted(Employee $employee): void
    {
        $employee->account()->forceDelete();
    }
}
