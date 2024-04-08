<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $categories_label=['Front-end','Back-end','Snacks'];

        foreach($categories_label as $category_label){
            $category=new Category();
            $category->label=$category_label;
            $category->color=$faker->hexColor();
            $category->save();
        }
    }
}
