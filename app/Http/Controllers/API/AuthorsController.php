<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorsController extends Controller
{
    use HttpResponses;

    public function index()
    {
        
        $authors = Author::all();
        $arr = [];
        foreach ($authors as $author)
        {
            $count = $author->books()->count();
            $arr[] = [
                'author' => $author->author_name,
                'count' => $count
            ];
        }
        return new AuthorResource($arr);

    }

    public function create(CreateAuthorRequest $request)
    {
        $request->validated($request->all());
        $user = Author::where('author_name', $request->author_name)->first();
        if(!is_null($user)) {
            return  $this->fail('', 'This author exist', '404');
        }
        $author = Author::create([
            'author_name' => $request->author_name,
        ]);
        return $this->success($author, '', 201);
    }
    public function show(Request $request)
    {
        $author = Author::find($request->id);
        if(is_null($author)) {
            return $this->fail('', 'Not exist', 404);
        }

        $countBooks = DB::table('authors')->
        join('books', 'books.author_id', '=', "authors.id")->
        where('authors.id', '=', "$author->id")->count();
        $data = [
            'author' => $author,
            'count of books' => $countBooks,
        ];
        return $this->success($data);
    }
    public function update(CreateAuthorRequest $request)
    {
        $author = Author::find($request->id);
        if(is_null($author)) {
            return $this->fail('', 'Not exist', 404);
        }
        $author->update($request->all());
        return $this->success($author);
    }
    public function destroy(Request $request)
    {
        $author = Author::find($request->id);
        if(is_null($author))
        {
            return $this->fail('', 'This book doesnt exist', '404');
        }
        $author->delete();
        return $this->success('', '', '204');
    }
}
