<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAuthorRequest;
use App\Models\Author;
use App\Models\Book;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

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
        return $this->success($author);
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
