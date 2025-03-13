<?php

namespace App\Repositories\Eloquent;

use App\Models\RentalOrderDetail;
use App\Repositories\Interface\RentalOrderDetailRepository;
use App\Validators\RentalOrderDetailValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class RentalOrderDetailRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RentalOrderDetailRepositoryEloquent extends BaseRepository implements RentalOrderDetailRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RentalOrderDetail::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
