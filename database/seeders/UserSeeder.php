<?php

namespace Database\Seeders;

use App\Enum\UserSexEnum;
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
        $admin = Role::where('slug','admin')->first();
        $accessAccount = Permission::where('slug','access-account')->first();;
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
        $user1->status = 'Когда ты поднимаешься, друзья узнают тебя, когда ты падаешь ты узнаёшь друзей!';
        $user1->sex = UserSexEnum::WOMAN;
        $user1->birthday = '2000-06-21';
        $user1->description = 'Я Леонид Месси выиграл множество турниров, включая Чмепионат мира, Лигу Чемпионов и много много другого';
        $user1->save();
        $user1->roles()->attach($admin);
        $user1->permissions()->attach($accessAccount);
        $user2 = new User();
        $user2->username = 'Ney-21';
        $user2->name = 'Неймар';
        $user2->email = 'ney@inbox.com';
        $user2->password = bcrypt('secret');
        $user2->phone = '+79501234568';
        $user2->status = 'Когда ты поднимаешься, друзья узнают тебя, когда ты падаешь ты узнаёшь друзей!';
        $user2->sex = UserSexEnum::MAN;
        $user2->birthday = '2000-06-22';
        $user2->description = 'Я Неймар выиграл множество турниров, включая Чмепионат мира, Лигу Чемпионов и много много другого';
        $user2->save();
    }
}
