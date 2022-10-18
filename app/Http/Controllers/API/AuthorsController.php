<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use App\Models\Book;
use App\Traits\HttpResponses;

class AuthorsController extends Controller
{
    use HttpResponses;

    public function create(CreateAuthorRequest $request)
    {
        $request->validated($request->all());
        $author = Author::create([
            'author_name' => $request->author_name,
        ]);
        return $this->success($author, '', 201);
    }
}
