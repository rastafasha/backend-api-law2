<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $clients = [
            
            [
                "username" => "invitado",
                "email" => "invitado@invitado.com",
                
                "password" => bcrypt("password"),
                'roles' => [
                    [
                        "id"=> 4,
                        "name"=> "GUEST",
                        "guard_name"=> "api",
                        "created_at"=> "2025-02-16T06:49:18.000000Z",
                        "updated_at"=> "2025-02-16T06:49:18.000000Z",
                    ],
                    'pivot' => [
                        [
                            "model_id"=> 3,
                            "role_id"=> 5,    
                            "model_type"=> "App\\Models\\User"
                        ]
                    ],
                ],
                "email_verified_at" => now(),
                "created_at" => now(),
            ],
            [
                "username" => "invitado",
                "email" => "invitado2@invitado.com",
                "password" => bcrypt("password"),
                'roles' => [
                    [
                        "id"=> 4,
                        "name"=> "GUEST",
                        "guard_name"=> "api",
                        "created_at"=> "2025-02-16T06:49:18.000000Z",
                        "updated_at"=> "2025-02-16T06:49:18.000000Z",
                    ],
                    'pivot' => [
                        [
                            "model_id"=> 4,
                            "role_id"=> 4,    
                            "model_type"=> "App\\Models\\User"
                        ]
                    ],
                ],
                "email_verified_at" => now(),
                "created_at" => now(),
            ],
        ];

        foreach ($clients as $client) {
            // Extract roles before creating user
            $roles = $client['roles'] ?? null;
            unset($client['roles']);
            
            // Create user
            //si no tiene asignado un rol, se le asigna el rol de invitado
            if (!$roles) {
                $createdUser->assignRole(User::GUEST);
                    } 
            $createdUser = Client::create($client);
            
            // Attach roles if they exist
            if ($roles) {
                $roleIds = array_column($roles, 'id');
                $createdUser->roles()->sync($roleIds);
            }
        }
    }
}
