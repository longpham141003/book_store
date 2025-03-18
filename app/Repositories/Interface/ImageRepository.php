<?php

namespace App\Repositories\Interface;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ImageRepository.
 *
 * @package namespace App\Repositories;
 */
interface ImageRepository extends RepositoryInterface
{
    public function uploadImage($file);
}
