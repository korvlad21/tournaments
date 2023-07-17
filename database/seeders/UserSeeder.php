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
        $user3 = new User();
        $user3->username = 'kvaradona';
        $user3->name = 'Хвича}';
        $user3->email = 'kvara@inbox.com';
        $user3->password = bcrypt('secret');
        $user3->phone = '+79501234511';
        $user3->status = 'Когда ты поднимаешься, друзья узнают тебя, когда ты падаешь ты узнаёшь друзей!';
        $user3->sex = UserSexEnum::MAN;
        $user3->birthday = '2000-06-24';
        $user3->description = 'Я Хвича выиграл множество турниров, включая Чмепионат мира, Лигу Чемпионов и много много другого';
        $user3->save();
        for ($i = 0; $i < 100; $i++) {
            $user = new User();
            $user->username = 'user_' . $i;
            $user->name = 'User ' . $i;
            $user->email = 'user' . $i . '@example.com';
            $user->password = bcrypt('secret');
            $user->phone = '+7' . rand(900, 999) . rand(1000000, 9999999);
            $user->status = 'Когда ты поднимаешься, друзья узнают тебя, когда ты падаешь ты узнаёшь друзей!';
            $user->sex = rand(0, 1) ? UserSexEnum::WOMAN : UserSexEnum::MAN;
            $user->birthday = date('Y-m-d', strtotime('-'. rand(18, 60) .' years'));
            $user->description = 'Я пользователь ' . $i;
            $user->save();
        }
    }
}
