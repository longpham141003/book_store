<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequests\StoreUserRequest;
use App\Http\Requests\BookRequests\UpdateUserRequest;
use App\Repositories\Interface\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserRepository $userRepo;
    public function __construct(\App\Repositories\Interface\UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index() : JsonResponse
    {
        $categories = $this->userRepo->all();
        return response()->json($categories);
    }

    public function store(StoreUserRequest $request)
    {
        $category = $this->userRepo->create($request->validated());
        return response()->json($category, 201);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $category = $this->userRepo->update($request->validated(), $id);
        return response()->json($category);
    }

    public function destroy($id)
    {
        $this->userRepo->delete($id);
        return response()->json(null, 204);
    }
}
