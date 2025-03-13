<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequests\StoreBookRequest;
use App\Http\Requests\BookRequests\UpdateBookRequest;
use App\Repositories\Interface\BookRepository;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected BookRepository $bookRepo;

    public function __construct(\App\Repositories\Interface\BookRepository $bookRepo)
    {
        $this->bookRepo = $bookRepo;
    }

    public function index()
    {
        $books = $this->bookRepo->all();
        return response()->json($books);
    }

    public function store(StoreBookRequest $request)
    {
        $book = $this->bookRepo->create($request->validated());
        return response()->json($book, 201);
    }


    public function update(UpdateBookRequest $request, $id)
    {
        $book = $this->bookRepo->update($request->validated(), $id);
        return response()->json($book);
    }

    public function destroy($id)
    {
        $this->bookRepo->delete($id);
        return response()->json(null, 204);
    }
}
