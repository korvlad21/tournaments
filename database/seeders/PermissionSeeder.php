<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accessAccount = new Permission();
        $accessAccount->name = 'Подтверждение аккаунта';
        $accessAccount->slug = 'access-account';
        $accessAccount->save();
    }
}
