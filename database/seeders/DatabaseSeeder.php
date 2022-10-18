<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Author;
use App\Models\Book;
use App\Models\Product;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use function Symfony\Component\String\b;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        User::factory(25)->create();
//        Task::factory(100)->create();
        Author::factory(5)->create();
        Book::factory(10)->create();
    }
}
