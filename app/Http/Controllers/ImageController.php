<?php

namespace App\Http\Controllers;

use App\Repositories\Interface\ImageRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    protected ImageRepository $imageRepo;

    public function __construct(ImageRepository $imageRepo)
    {
        $this->imageRepo = $imageRepo;
    }

    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $image = $this->imageRepo->uploadImage($request->file('image'));

        return response()->json([
            'message' => 'Upload thành công!',
            'image' => $image
        ]);
    }
}
