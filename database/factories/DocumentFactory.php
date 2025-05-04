<?php

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition()
    {
        $types = ['pdf', 'docx', 'xlsx', 'jpg', 'png'];
        $type = $this->faker->randomElement($types);
        $sizes = ['100KB', '250KB', '500KB', '1MB', '2MB'];
        $resolutions = ['800x600', '1024x768', '1920x1080', '2560x1440'];

        return [
            'name_category' => $this->faker->word,
            'name_file' => $this->faker->word . '.' . $type,
            'size' => $this->faker->randomElement($sizes),
            'resolution' => $type === 'pdf' ? 'N/A' : $this->faker->randomElement($resolutions),
            'file' => 'documents/' . $this->faker->uuid . '.' . $type,
            'type' => $type,
        ];
    }
}
