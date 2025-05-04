<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\DocumentsUser;
use App\Models\User;
use App\Models\Client;
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
        // Create 5 documents
        $documents = Document::factory()->count(5)->create();

        // Attach documents to random users and clients in documents_users pivot table
        $users = User::all();
        $clients = Client::all();

        foreach ($documents as $document) {
            // Attach to random users
            $randomUsers = $users->count() >= 3 ? $users->random(rand(1, 3)) : $users;
            foreach ($randomUsers as $user) {
                DocumentsUser::create([
                    'document_id' => $document->id,
                    'user_id' => $user->id,
                ]);
            }

            // Attach to random clients
            $randomClients = $clients->count() >= 3 ? $clients->random(rand(1, 3)) : $clients;
            foreach ($randomClients as $client) {
                DocumentsUser::create([
                    'document_id' => $document->id,
                    'client_id' => $client->id,
                ]);
            }
        }

        $this->command->info('5 documents created and linked to users and clients');
    }
}
