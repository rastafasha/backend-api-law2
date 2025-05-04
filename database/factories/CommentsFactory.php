<?php

namespace Database\Factories;

use App\Models\Comments;
use App\Models\Solicitud;
use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentsFactory extends Factory
{
    protected $model = Comments::class;

    public function definition()
    {
        $rating = [0,1, 2, 3, 4, 5];
        
        return [
            'comment' => $this->faker->word,
            'rating' => $this->faker->randomElement($rating),
            'solicitud_id' => Solicitud::inRandomOrder()->first()->id,
            'user_id' => User::whereHas('roles', function($q) {
                $q->where('name', 'MEMBER');
            })->inRandomOrder()->first()->id,
            'client_id' => Client::whereHas('roles', function($q) {
                $q->where('name', 'GUEST');
            })->inRandomOrder()->first()->id,
            // 'client_id' => null,
        ];
    }
}
