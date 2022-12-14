<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBookRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use App\Models\Book;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $books = Book::all();
        $arr = [];
        foreach ($books as $book) {
            $arr[] = [
                'author' => $book->author()->first()->author_name,
                'book' => $book,
            ];
        }
        return new AuthorResource($arr);
    }
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
    public function destroy(Request $request)
    {
        $book = Book::find($request->id);
        if(is_null($book))
        {
            return $this->fail('', 'This book doesnt exist', '404');
        }
        $book->delete();
        return $this->success('', '', '204');
    }
    public function delete_many(Request $request)
    {
        $ids = explode(',', $request->id);
        foreach ($ids as $id)
        {
            if($this->book_is_exist($id)){
                Book::find($id)->delete();
            }
        }
        return $this->success('', '', '204');
    }
    public function book_is_exist($id)
    {
        $book = Book::find($id);
        if(is_null($book)){
            return false;
        }
        return true;
    }
}
