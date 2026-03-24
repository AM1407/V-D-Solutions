<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Maak een Admin aan (als je die nog niet had)
        User::factory()->create([
            'name' => 'Admin VD Solutions',
            'email' => 'admin@vdsolutions.be',
            'password' => bcrypt('password'),
        ]); // Verander dit later!

        User::factory()->create([
            'name' => 'Alessio Micciche',
            'email' => 'micciche.alessio@outlook.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Maak de Categorieën aan
        $badkamers = Category::create(['name' => 'Badkamers', 'slug' => 'badkamers']);
        $keukens = Category::create(['name' => 'Keukens', 'slug' => 'keukens']);
        $renovatie = Category::create(['name' => 'Totaalrenovatie', 'slug' => 'totaalrenovatie']);

        // 3. Maak de Diensten aan
        $services = collect(['Loodgieterij', 'Tegelzetten', 'Elektriciteit', 'Gyprocwerken', 'Vloerverwarming'])
            ->map(fn($name) => Service::create(['title' => $name, 'slug' => Str::slug($name), 'content' => "Professionele $name voor uw woning."]));

        // 4. Maak 10 Test Projecten aan
        for ($i = 1; $i <= 10; $i++) {
            $title = "Project " . ($i % 2 == 0 ? "Luxe Badkamer " : "Moderne Keuken ") . $i;

            $project = Project::create([
                'category_id' => ($i % 2 == 0 ? $badkamers->id : $keukens->id),
                'title' => $title,
                'slug' => Str::slug($title),
                'location' => 'Antwerpen',
                'description' => 'Dit is een prachtig voorbeeld van ons vakmanschap bij VD Solutions.',
            ]);

            // Koppel willekeurige diensten aan het project (Many-to-Many)
            $project->services()->attach($services->random(rand(1, 3))->pluck('id'));
        }
    }
}
