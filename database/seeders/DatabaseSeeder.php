<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleAndPermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(SpecialitySeeder::class);
        $this->call(PaisSeeder::class);
        $this->call(ProfileSeeder::class);
        // $this->call(TiposDePagoSeeder::class);
        $this->call(DocumentSeeder::class);
        $this->call(SolicitudesSeeder::class);
        $this->call(FavoriteSeeder::class);

    }
}
