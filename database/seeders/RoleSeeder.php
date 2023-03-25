<?php
namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role();
        $admin->name = 'Администратор';
        $admin->slug = 'admin';
        $admin->save();
        $moderator = new Role();
        $moderator->name = 'Модератор';
        $moderator->slug = 'moderator';
        $moderator->save();
        $organizer = new Role();
        $organizer->name = 'Организатор';
        $organizer->slug = 'organizer';
        $organizer->save();
        $player = new Role();
        $player->name = 'Игрок';
        $player->slug = 'player';
        $player->save();
    }
}
