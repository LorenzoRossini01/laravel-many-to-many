<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {


        // $projects=config('projects');
        // foreach($projects as $currProject){

        //     $category_id=$faker->randomElement($categories);
            
        //     $project=new Project;
        //     $project->category_id=$category_id;
        //     $project->title=$currProject['title'];
        //     $project->description=$currProject['description'];
        //     $project->link=$currProject['link'];
        //     $project->imageUrl=$currProject['imageUrl'];
        //     $project->slug=Str::slug($project->title);
        //     $project->save();
        // }
        

        $categories=Category::all()->pluck('id');
        $user=User::all()->pluck('id');
        // $categories[]=null;
        
        for($i=0;$i<50;$i++){
            $category_id=$faker->randomElement($categories);
            $user_id=$faker->randomElement($user);
            
            $project=new Project();
            $project->title=$faker->catchPhrase();
            $project->category_id=$category_id;
            $project->user_id=$user_id;
            $project->description=$faker->paragraph(2);
            $project->link=$faker->url();
            $project->imageUrl=$faker->imageUrl(640, 480, 'animals', true);
            $project->slug=Str::slug($project->title);
            $project->save();
        }
    }
}
