<?php

namespace App\Repositories\Eloquent;

use App\Models\RentalOrder;
use App\Repositories\Interface\RentalOrderRepository;
use App\Validators\RentalOrderValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class RentalOrderRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RentalOrderRepositoryEloquent extends BaseRepository implements RentalOrderRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RentalOrder::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function countByDate(string $date): int
    {
        return $this->model->whereDate('order_date', $date)->count();
    }
    public function getOverdueOrders(string $today)
    {
        return $this->model->where('due_date', '<', $today)
            ->where('status', '!=', 'overdue')
            ->get();
    }
    public function getOrdersByDate(string $date)
    {
        return $this->model->whereDate('order_date', $date)->with(['user', 'rentalOrderDetails.book'])->get();
    }
}
