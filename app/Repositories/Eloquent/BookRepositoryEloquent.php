<?php

namespace App\Repositories\Eloquent;

use App\Models\Book;
use App\Repositories\Interface\BookRepository;
use App\Validators\BookValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class BookRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BookRepositoryEloquent extends BaseRepository implements BookRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Book::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
