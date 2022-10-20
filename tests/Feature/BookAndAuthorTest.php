<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookAndAuthorTest extends TestCase
{
    use RefreshDatabase;
    public function test_create_author()
    {
        $response = $this->postJson('/api/authors', ['author_name' => 'MartinIden']);
        $response->assertStatus(201);
    }
    public function test_try_to_add_exist_author()
    {
        $response = $this->postJson('/api/authors', ['author_name' => 'Dostoevsky']);
        $response = $this->postJson('/api/authors', ['author_name' => 'Dostoevsky']);
        $response->assertStatus(404);
    }
    public function test_create_book()
    {
        $author = Author::factory()->create();
        $response = $this->postJson('/api/books', [
            'name' => '1984',
            'year_release' => '1986',
            'author_id' => $author->id,
        ]);
        $response->assertStatus(201);
    }
    public function test_create_book_with_invalid_data()
    {
        $author = Author::factory()->create();
        $response = $this->postJson('/api/books', [
            'name' => '1984',
            'year_release' => 'one thousand eight hundred sixteen',
            'author_id' => $author->id,
        ]);
        $response->assertStatus(422);
    }

}
