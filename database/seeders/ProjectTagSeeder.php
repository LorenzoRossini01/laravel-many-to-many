<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class ProjectTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $projects=Project::all();
        $tags=Tag::all()->pluck('id')->toArray();

        foreach($projects as $project){
            $project->tags()->sync($faker->randomElements($tags, rand(1,5)));
        }
    }
}
