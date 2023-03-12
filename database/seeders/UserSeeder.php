<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $admin = Role::where('slug','admin')->first();
//        $user1 = new User();
//        $user1->name = 'Jhon Deo';
//        $user1->email = 'jhon@deo.com';
//        $user1->password = bcrypt('secret');
//        $user1->save();
//        $user1->roles()->attach($admin);
        $user1 = new User();
        $user1->username = 'leomessi';
        $user1->name = 'Леонид';
        $user1->email = 'leo@inbox.com';
        $user1->password = bcrypt('secret');
        $user1->phone = '+79501234567';
        $user1->sex = User::SEX_WOMAN;
        $user1->birthday = '2000-06-21';
        $user1->save();
    }
}
