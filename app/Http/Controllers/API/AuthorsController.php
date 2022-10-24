<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAuthorRequest;
use App\Models\Author;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function MongoDB\BSON\toJSON;

class AuthorsController extends Controller
{
    use HttpResponses;

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

        $books = DB::table('authors')->
        join('books', 'books.author_id', '=', "authors.id")->
        where('authors.id', '=', "$author->id")->get();

        dd($books);
        $data = [
            'author' => $author,
            'count' => $count,
            'books' => $books,
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
