<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAuthorRequest;
use App\Models\Author;
use App\Traits\HttpResponses;

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
}
