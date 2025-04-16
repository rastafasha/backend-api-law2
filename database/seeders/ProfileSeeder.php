<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profiles = [
            [
                'gender' => 1, // Male
                'status' => 1,
                'avatar' => null,
                'n_doc' => '12345678',
                'nombre' => 'Carlos',
                'surname' => 'Martinez',
                'direccion' => 'Avenida Siempre Viva 742',
                'description' => 'Experto en derecho civil y comercial.',
                'pais' => 'AR',
                'estado' => 'CABA',
                'ciudad' => 'Buenos Aires',
                'telhome' => '011-1234-5678',
                'telmovil' => '011-9876-5432',
                'redessociales' => json_encode([ 
                    [
                        'icono' => 'fa fa-facebook',
                        'title' => 'facebook',
                        'url' => 'https://facebook.com/carlosmartinez',
                    ],
                    [
                        'icono' => 'fa fa-linkedin',
                        'title' => 'linkedin',
                        'url' => 'https://linkedin.com/in/carlosmartinez',
                    ]
                ]),
                'precios' => json_encode([[
                    'item_tarifa' => 'Consulta Inicial',
                    'precio' => 150
                ]]),
                'rating' => 3,
                'speciality_id' => 2,
                'user_id' => 3,
            ],

            [
                'gender' => 2, // Female
                'status' => 1,
                'avatar' => null,
                'n_doc' => '12993678',
                'nombre' => 'Ana',
                'surname' => 'Gomez',
                'direccion' => 'Calle Falsa 456',
                'description' => 'Abogada especializada en derecho laboral.',
                'pais' => 'VE',
                'estado' => 'Caracas',
                'ciudad' => 'Caracas',
                'telhome' => '0212-1234-5678',
                'telmovil' => '0412-9876-5432',
                'redessociales' => json_encode([ 
                    [
                        'icono' => 'fa fa-twitter',
                        'title' => 'twitter',
                        'url' => 'https://twitter.com/anagomez',
                    ],
                    [
                        'icono' => 'fa fa-instagram',
                        'title' => 'instagram',
                        'url' => 'https://instagram.com/anagomez',
                    ]
                ]),
                'precios' => json_encode([[
                    'item_tarifa'=> 'Consulta Inicial',
                    'precio' => 30
                ]]),
                'rating' => 2,
                'speciality_id' => 2,
                'user_id' => 4,
            ],
            [
                'gender' => 1, // Male
                'status' => 1,
                'avatar' => null,
                'n_doc' => '123342678',
                'nombre' => 'Luis',
                'surname' => 'Fernandez',
                'direccion' => 'Avenida Libertador 1234',
                'description' => 'Abogado con experiencia en derecho penal.',
                'pais' => 'CO',
                'estado' => 'N/A', // Changed to a valid value
                'ciudad' => 'Cucuta',
                'telhome' => '0571-1234-5678',
                'telmovil' => '0571-9876-5432',
                'redessociales' => json_encode([ 
                    [
                        'icono' => 'fa fa-facebook',
                        'title' => 'facebook',
                        'url' => 'https://facebook.com/luisfernandez',
                    ],
                    [
                        'icono' => 'fa fa-linkedin',
                        'title' => 'linkedin',
                        'url' => 'https://linkedin.com/in/luisfernandez',
                    ]
                ]),
                'precios' => null,
                'rating' => 1,
                'speciality_id' => null,
                'client_id' => 5,
            ],

            [
                'gender' => 1, // Male
                'status' => 1,
                'avatar' => null,
                'n_doc' => '12330678',
                'nombre' => 'Manuel',
                'surname' => 'Fernandez',
                'direccion' => 'Avenida Libertador 12s',
                'description' => 'Persona común.',
                'pais' => 'CO',
                'estado' => 'Bogotá',
                'ciudad' => 'Bogotá',
                'telhome' => '0571-1234-5678',
                'telmovil' => '0571-9876-5432',
                'redessociales' => json_encode([ 
                    [
                        'icono' => 'fa fa-facebook',
                        'title' => 'facebook',
                        'url' => 'https://facebook.com/luisfernandez',
                    ],
                    [
                        'icono' => 'fa fa-linkedin',
                        'title' => 'linkedin',
                        'url' => 'https://linkedin.com/in/luisfernandez',
                    ]
                ]),
                'precios' => null,
                'rating' => 2,
                'speciality_id' => null,
                'client_id' => 6,
            ],
        ];

        DB::table('profiles')->insert($profiles);
    }
}
