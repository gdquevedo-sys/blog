<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Eliminar carpeta articles y categories
        Storage::deleteDirectory('articles');
        Storage::deleteDirectory('categories');

        //Crear carpeta donde se almacenaran las imagenes
        Storage::makeDirectory('articles');
        Storage::makeDirectory('categories');
       
        //LLamar al seeder
        $this->call(UserSeeder::class);

        //Llamar a los factories
        Category::factory(8)->create();
        Article::factory(20)->create();
        Comment::factory(20)->create();
    }
}
