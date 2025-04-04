<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = [
            [
                "username" => "superadministrador",
                "email" => "superadmin@superadmin.com",
                
                "password" => bcrypt("superadmin"),
                'roles' => [
                    [
                        "id"=> 1,
                        "name"=> "SUPERADMIN",
                        "guard_name"=> "api",
                        "created_at"=> "2025-02-16T06:49:18.000000Z",
                        "updated_at"=> "2025-02-16T06:49:18.000000Z",
                    ],
                    'pivot' => [
                        [
                            "model_id"=> 1,
                            "role_id"=> 1,  
                            "model_type"=> "App\\Models\\User"
                        ]
                    ],
                ],
                "email_verified_at" => now(),
                "created_at" => now(),
            ],
            [
                "username" => "administrador",
                "email" => "admin@admin.com",
                "password" => bcrypt("password"),
                'roles' => [
                    [
                        "id"=> 1,
                        "name"=> "ADMIN",
                        "guard_name"=> "api",
                        "created_at"=> "2025-02-16T06:49:18.000000Z",
                        "updated_at"=> "2025-02-16T06:49:18.000000Z",
                    ],
                    'pivot' => [
                        [
                            "model_id"=> 2,
                            "role_id"=> 2,  
                            "model_type"=> "App\\Models\\User"
                        ]
                    ],
                ],
                "email_verified_at" => now(),
                "created_at" => now(),
            ],
            [
                "username" => "miembro",
                "email" => "miembro@miembro.com",
                'roles' => [
                    [
                        "id"=> 3,
                        "name"=> "MEMBER",
                        "guard_name"=> "api",
                        "created_at"=> "2025-02-16T06:49:18.000000Z",
                        "updated_at"=> "2025-02-16T06:49:18.000000Z",
                    ],
                    'pivot' => [
                        [
                            "model_id"=> 2,
                            "role_id"=> 3,
                            "model_type"=> "App\\Models\\User"
                        ]
                    ],
                ],
                "password" => bcrypt("password"),
                "email_verified_at" => now(),
                "created_at" => now(),
            ],
            [
                "username" => "miembro",
                "email" => "miembro2@miembro.com",
                'roles' => [
                    [
                        "id"=> 3,
                        "name"=> "MEMBER",
                        "guard_name"=> "api",
                        "created_at"=> "2025-02-16T06:49:18.000000Z",
                        "updated_at"=> "2025-02-16T06:49:18.000000Z",
                    ],
                    'pivot' => [
                        [
                            "model_id"=> 2,
                            "role_id"=> 3,
                            "model_type"=> "App\\Models\\User"
                        ]
                    ],
                ],
                "password" => bcrypt("password"),
                "email_verified_at" => now(),
                "created_at" => now(),
            ],
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

        foreach ($users as $user) {
            // Extract roles before creating user
            $roles = $user['roles'] ?? null;
            unset($user['roles']);
            
            // Create user
            //si no tiene asignado un rol, se le asigna el rol de invitado
            if (!$roles) {
                $createdUser->assignRole(User::GUEST);
                    } 
            $createdUser = User::create($user);
            
            // Attach roles if they exist
            if ($roles) {
                $roleIds = array_column($roles, 'id');
                $createdUser->roles()->sync($roleIds);
            }
        }
    }
}
