<?php

namespace Database\Seeders;

use App\Models\Presupuesto;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\Appointment\AppointmentPay;
use App\Models\Appointment\AppointmentAttention;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PresupuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create specific appointment
        $faker = Faker::create();
        $presupuesto = Presupuesto::firstOrCreate(
            ['id' => 1],
            [
                
                'status' => 1,
                'confimation' => 1,
                'client_id' => 9,
                'user_id' => 3,
                'speciality_id' => 1,
                'description'=> 'Presupuesto para la atención del paciente 9',
                'diagnostico'=> 'Presupuesto para la atención del paciente 9',
                "medical" => json_encode([
                    [
                        'id' => 1,
                        "name_medical" => "Consulta",
                        "precio" => 200.00,
                    ],
                    [
                        'id' => 2,
                        "name_medical" => "Consulta",
                        "precio" => 145.50,
                    ],
                ]),
                'amount' => 345.50,
                'created_at' => '2025-02-16 20:41:51',
                'updated_at' => '2025-02-16 20:41:51',
                'deleted_at' => null
            ]
        );

        // Create related records for the specific presupuesto
        $faker = Faker::create();
        

        // Create additional random presupuestos for testing
        Presupuesto::factory()->count(2)->create()->each(function($p) use ($faker) {
            $faker = Faker::create();
            
        });
        // php artisan db:seed --class=presupuestoSeeder
    }
}
