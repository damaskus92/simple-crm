<?php

use App\Models\Role;
use App\Models\User;

dataset('users', [
    // 'Super Admin' => function () {
    //     $role = Role::factory()->create(['name' => 'Super Admin']);

    //     $user = User::factory()->create([
    //         'name' => 'Super Admin Name',
    //         'email' => 'admin@example.test',
    //         'role_id' => $role->id
    //     ]);

    //     return $user;
    // },
    'Manager' => function () {
        $role = Role::factory()->create(['name' => 'Manager']);

        $user = User::factory()->create([
            'name' => 'Manager Name',
            'email' => 'manager@example.test',
            'role_id' => $role->id
        ]);

        return $user;
    },
    'Employee' => function () {
        $role = Role::factory()->create(['name' => 'Employee']);

        $user = User::factory()->create([
            'name' => 'Employee Name',
            'email' => 'employee@example.test',
            'role_id' => $role->id
        ]);

        return $user;
    }
]);
