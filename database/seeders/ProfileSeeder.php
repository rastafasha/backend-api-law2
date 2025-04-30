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
                'avatar' => null,
                'ciudad' => 'Buenos Aires',
                'description' => 'Experto en derecho civil y comercial.',
                'direccion' => 'Avenida Siempre Viva 742',
                'estado' => 'CABA',
                'gender' => 1,
                'lang' => null,
                'n_doc' => '12345678',
                'nombre' => 'Carlos',
                'status' => 1,
                'surname' => 'Martinez',
                'pais' => 'AR',
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
                'client_id' => null,
            ],

            [
                'avatar' => null,
                'ciudad' => 'Caracas',
                'description' => 'Abogada especializada en derecho laboral.',
                'direccion' => 'Calle Falsa 456',
                'estado' => 'Caracas',
                'gender' => 2,
                'lang' => null,
                'n_doc' => '12993678',
                'nombre' => 'Ana',
                'status' => 1,
                'surname' => 'Gomez',
                'pais' => 'VE',
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
                'client_id' => null,
            ],
            [
                'avatar' => null,
                'ciudad' => 'Bogotá',
                'description' => 'Abogado con experiencia en derecho penal.',
                'direccion' => 'Avenida Libertador 1234',
                'estado' => 'Bogotá',
                'gender' => 1,
                'lang' => null,
                'n_doc' => '123342678',
                'nombre' => 'Luis',
                'status' => 1,
                'surname' => 'Fernandez',
                'pais' => 'CO',
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
                'client_id' => 1,
                'user_id' => null,
            ],

            [
                'avatar' => null,
                'ciudad' => 'Bogotá',
                'description' => 'Persona común.',
                'direccion' => 'Avenida Libertador 12s',
                'estado' => 'Bogotá',
                'gender' => 1,
                'lang' => null,
                'n_doc' => '12330678',
                'status' => 1,
                'nombre' => 'Manuel',
                'surname' => 'Fernandez',
                'pais' => 'CO',
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
                'rating' =>2,
                'speciality_id' => null,
                'client_id' => 2,
                'user_id' => null,
            ],
        ];

        DB::table('profiles')->insert($profiles);
    }
}
