<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Solicitud;
use App\Models\SolicitudUser;

class SolicitudesSeeder extends Seeder
{
    public function run()
    {
        // Get all guest users
        $guests = User::whereHas('roles', function($q) {
            $q->where('name', 'GUEST');
        })->get();

        // Get all member users
        $members = User::whereHas('roles', function($q) {
            $q->where('name', 'MEMBER');
        })->get();

        if ($guests->isEmpty() || $members->isEmpty()) {
            $this->command->info('No guest or member users found!');
            return;
        }

        // Create 4 solicitudes per guest
        $guests->each(function($guest) use ($members) {
            for ($i = 0; $i < 4; $i++) {
                // Create solicitud
                $solicitud = Solicitud::create([
                    'pedido' => json_encode([
                        
                        'precio' => rand(100, 1000),
                        'item_tarifa' => 'Detalles del pedido #'.($i+1)
                    ]),
                    'status' => 1
                ]);

                // Get random member to assign
                $member = $members->random();

                // Create complete solicitud_user records
                SolicitudUser::create([
                    'solicitud_id' => $solicitud->id,
                    'cliente_id' => $guest->id,
                    'user_id' => $member->id
                ]);

                // // Alternative relationship if needed
                // SolicitudUser::create([
                //     'solicitud_id' => $solicitud->id, 
                //     'cliente_id' => $guest->id,
                //     'user_id' => $member->id
                // ]);
            }
        });

        $this->command->info('Created '.($guests->count() * 4).' solicitudes!');
    }
}
