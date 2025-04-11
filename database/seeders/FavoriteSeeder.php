<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Assuming we have 3 clients
        $clientIds = User::whereIn('id', [1, 2, 3])->pluck('id');

        foreach ($clientIds as $clientId) {
            // Assuming we have 3 users for each client
            for ($i = 1; $i <= 3; $i++) {
                Favorite::create([
                    'cliente_id' => $clientId,
                    'user_id' => $i + 3 // Assuming user IDs start from 4
                ]);
            }
        }
    }
}
