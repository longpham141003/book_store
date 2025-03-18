<?php

namespace App\Repositories\Eloquent;

use App\Models\Image;
use App\Repositories\Interface\ImageRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageRepositoryEloquent extends BaseRepository implements ImageRepository
{
    protected $imageManager;

    public function __construct()
    {
        parent::__construct(app());
        $this->imageManager = new ImageManager(new Driver());
    }

    public function model()
    {
        return Image::class;
    }

    public function uploadImage($file)
    {
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = "uploads/{$filename}";
        $thumbnailPath = "uploads/thumbnails/{$filename}";

        // Resize và lưu ảnh chính
        $image = $this->imageManager->read($file)->cover(1920, 1920);
        Storage::put($path, (string) $image->encode());

        // Resize và lưu thumbnail
        $thumbnail = $this->imageManager->read($file)->cover(320, 320);
        Storage::put($thumbnailPath, (string) $thumbnail->encode());

        // Lưu vào DB
        return $this->create([
            'path' => $path,
            'thumbnail_path' => $thumbnailPath,
        ]);
    }
}
