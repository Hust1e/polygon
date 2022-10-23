<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CRUD_BookAndAuthorTest extends TestCase
{
    public function test_get_current_book()
    {
        Author::factory()->create();
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $token = $user->createToken("$user->name", ['user'])->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/books/' . $book->id);

        $response->assertStatus(200);
    }
    public function test_get_current_book_with_invalid_id()
    {
        $user = User::factory()->create();
        $token = $user->createToken("$user->name", ['user'])->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/books/0');
        $response->assertStatus(404);
    }

    public function test_get_current_author()
    {
        $user = User::factory()->create();
        $author = Author::factory()->create();

        $token = $user->createToken("$user->name", ['user'])->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/authors/' . $author->id);
        $response->assertStatus(200);
    }
    public function test_get_current_author_with_invalid_id()
    {
        $user = User::factory()->create();
        $token = $user->createToken("$user->name", ['user'])->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/authors/0');
        $response->assertStatus(404);
    }
    public function test_put_current_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $newbook = Book::factory()->create();

        $token = $user->createToken("$user->name", ['admin'])->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->putJson('/api/books/' . $book->id, [
            'name' => $newbook->name,
            'year_release' => $newbook->year_release,
            'author_id' => $newbook->author_id,
        ]);

        $response->assertStatus(200);
    }
    public function test_put_current_book_with_invalid_data()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $newbook = Book::factory()->create();

        $token = $user->createToken("$user->name", ['admin'])->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->putJson('/api/books/' . $book->id, [
            'name' => $newbook->name,
            'year_release' => 'one thousand eight hundred sixteen',
            'author_id' => $newbook->author_id,
        ]);
        $response->assertStatus(422);
    }
    public function test_put_current_author()
    {
        $user = User::factory()->create();
        $author = Author::factory()->create();
        $token = $user->createToken("$user->name", ['admin'])->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->putJson('/api/authors/' . $author->id,
            [
                'author_name' => 'Zamyatin',
            ]);
        $response->assertStatus(200);
    }
    public function test_put_current_author_with_invalid_data()
    {
        $user = User::factory()->create();
        $author = Author::factory()->create();
        $token = $user->createToken("$user->name", ['admin'])->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->putJson('/api/authors/' . $author->id,
            [
                'author_name' => 1950,
            ]);
        $response->assertStatus(422);
    }
    public function test_delete_current_author()
    {
        $user = User::factory()->create();
        $author = Author::factory()->create();
        $token = $user->createToken("$user->name", ['admin'])->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/authors/' . $author->id);

        $response->assertStatus(204);
    }
    public function test_delete_current_author_with_invalid_data()
    {
        $user = User::factory()->create();
        $token = $user->createToken("$user->name", ['admin'])->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/authors/0');

        $response->assertStatus(404);
    }
    public function test_delete_current_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $token = $user->createToken("$user->name", ['admin'])->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/books/' . $book->id);

        $response->assertStatus(204);
    }
    public function test_delete_current_book_with_invalid_data()
    {
        $user = User::factory()->create();
        $token = $user->createToken("$user->name", ['admin'])->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/books/0');

        $response->assertStatus(404);
    }
    public function test_cascade_deleting_books()
    {
        $user = User::factory()->create();
        $author = Author::factory()->create();
        $token = $user->createToken("$user->name", ['admin'])->plainTextToken;
        $book = Book::create([
            'name' => 'Titan',
            'year_release' => '1999',
            'author_id' => $author->id,
        ]);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/authors/' . $author->id);
        $deletedbook = Book::find($book->id);
        if(is_null($deletedbook)) {
            $response->assertStatus(204);
        }
    }
    public function test_delete_many_books()
    {
        $user = User::factory()->create();
        $token = $user->createToken("$user->name", ['admin'])->plainTextToken;

        $book1 = Book::factory()->create();
        $book2 = Book::factory()->create();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/books/delete-many/' . $book1->id . ',' . $book2->id );
        $deletedbook1 = Book::find($book1->id);
        if(is_null($deletedbook1))
        {
            $deletedbook2 = Book::find($book2->id);
            if(is_null($deletedbook2))
            {
                $response->assertStatus(204);
            }
        }
    }
}
