<?php

namespace App\Repositories\Interface;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface RentalOrderRepository.
 *
 * @package namespace App\Repositories;
 */
interface RentalOrderRepository extends RepositoryInterface
{
    public function countByDate(string $date): int;
    public function getOverdueOrders(string $today);
    public function getOrdersByDate(string $date);
}
