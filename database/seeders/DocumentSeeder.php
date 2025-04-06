<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 5 documents for member users
        Document::factory()->count(5)->create();
        
        $this->command->info('5 documents created for member users');
    }
}
