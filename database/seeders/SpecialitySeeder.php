<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Only truncate specialities table
        DB::table('specialities')->truncate();
        
        $specialities = [
            ['title' => 'Derecho Civil', 'description' => 'Especialidad en Derecho Civil', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Penal', 'description' => 'Especialidad en Derecho Penal', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Laboral', 'description' => 'Especialidad en Derecho Laboral', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Mercantil', 'description' => 'Especialidad en Derecho Mercantil', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Administrativo', 'description' => 'Especialidad en Derecho Administrativo', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Constitucional', 'description' => 'Especialidad en Derecho Constitucional', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Tributario', 'description' => 'Especialidad en Derecho Tributario', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Internacional', 'description' => 'Especialidad en Derecho Internacional', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho de Familia', 'description' => 'Especialidad en Derecho de Familia', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Procesal', 'description' => 'Especialidad en Derecho Procesal', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Ambiental', 'description' => 'Especialidad en Derecho Ambiental', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho de Propiedad Intelectual', 'description' => 'Especialidad en Derecho de Propiedad Intelectual', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Bancario', 'description' => 'Especialidad en Derecho Bancario', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho de Seguros', 'description' => 'Especialidad en Derecho de Seguros', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Notarial', 'description' => 'Especialidad en Derecho Notarial', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Registral', 'description' => 'Especialidad en Derecho Registral', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Marítimo', 'description' => 'Especialidad en Derecho Marítimo', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Aeronáutico', 'description' => 'Especialidad en Derecho Aeronáutico', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Deportivo', 'description' => 'Especialidad en Derecho Deportivo', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Médico', 'description' => 'Especialidad en Derecho Médico', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Tecnológico', 'description' => 'Especialidad en Derecho Tecnológico', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Consumidor', 'description' => 'Especialidad en Derecho del Consumidor', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Minero', 'description' => 'Especialidad en Derecho Minero', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Agrario', 'description' => 'Especialidad en Derecho Agrario', 'is_active' => true, 'isFeatured' => false],
            ['title' => 'Derecho Migratorio', 'description' => 'Especialidad en Derecho Migratorio', 'is_active' => true, 'isFeatured' => false],
        ];

        DB::table('specialities')->insert($specialities);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
