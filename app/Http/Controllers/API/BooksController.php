<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    use HttpResponses;

    public function create(CreateBookRequest $request)
    {
        $request->validated($request->all());
        $author = Author::find($request->author_id);
        if(is_null($author))
        {
            return $this->fail('', 'This author is not exist', 404);
        }
        $book = Book::create([
            'name' => $request->name,
            'year_release' => $request->year_release,
            'author_id' => $request->author_id
        ]);
        return  $this->success($book, '', 201);
    }
    public function show(Request $request)
    {
        $book = Book::find($request->id);
        if(is_null($book)) {
            return $this->fail('', 'Not exist', 404);
        }
        return $this->success($book);
    }
    public function update(CreateBookRequest $request)
    {
        $book = Book::find($request->id);
        if(is_null($book)) {
            return $this->fail('', 'Not exist', 404);
        }
        $book->update($request->all());
        return $this->success($book);
    }
}
