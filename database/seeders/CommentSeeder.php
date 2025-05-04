<?php

namespace Database\Seeders;

use App\Models\Comments;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 5 documents for member users
        Comments::factory()->count(5)->create();
        
        $this->command->info('5 comments created from client to member users');
    }
}
