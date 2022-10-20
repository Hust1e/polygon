<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CRUD_BookAndAuthorTest extends TestCase
{
    public function test_get_current_book()
    {
        Author::factory()->create();
        $book = Book::factory()->create();
        $response = $this->get('/api/books/' . $book->id);

        $response->assertStatus(200);
    }
    public function test_get_current_book_with_invalid_id()
    {
        $response = $this->get('/api/books/0');
        $response->assertStatus(404);
    }

    public function test_get_current_author()
    {
        $author = Author::factory()->create();
        $response = $this->get('/api/authors/' . $author->id);

        $response->assertStatus(200);
    }
    public function test_get_current_author_with_invalid_id()
    {
        $response = $this->get('/api/authors/0');

        $response->assertStatus(404);
    }
    public function test_put_current_book()
    {
        $book = Book::factory()->create();
        $newbook = Book::factory()->create();
        $response = $this->putJson('/api/books/' . $book->id, [
            'name' => $newbook->name,
            'year_release' => $newbook->year_release,
            'author_id' => $newbook->author_id,
        ]);
        $response->assertStatus(200);
    }
    public function test_put_current_book_with_invalid_data()
    {
        $book = Book::factory()->create();
        $newbook = Book::factory()->create();
        $response = $this->putJson('/api/books/' . $book->id, [
            'name' => $newbook->name,
            'year_release' => 'one thousand eight hundred sixteen',
            'author_id' => $newbook->author_id,
        ]);
        $response->assertStatus(422);
    }
    public function test_put_current_author()
    {
        $author = Author::factory()->create();
        $response = $this->putJson('/api/authors/' . $author->id,
            [
                'author_name' => 'Zamyatin',
            ]);
        $response->assertStatus(200);
    }
    public function test_put_current_author_with_invalid_data()
    {
        $author = Author::factory()->create();
        $response = $this->putJson('/api/authors/' . $author->id,
            [
                'author_name' => 1950,
            ]);
        $response->assertStatus(422);
    }
}
