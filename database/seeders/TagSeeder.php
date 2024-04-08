<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $labels_name = ["GIT", "HTML", "CSS","Bootstrap", "JavaScript", "Axios","VueJs","Vite", "PHP", "SQL", "Laravel", "Blade"];

        foreach($labels_name as $label){
            $tag=new Tag;
            $tag->label=$label;
            $tag->color=$faker->hexColor();
            $tag->save();
        }
    }
}
