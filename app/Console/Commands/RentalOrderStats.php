<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\Interface\RentalOrderRepository;
use Carbon\Carbon;

class RentalOrderStats extends Command
{
    protected $signature = 'rental:stats {date?}';
    protected $description = 'Thống kê số lượng đơn thuê theo ngày';

    protected RentalOrderRepository $rentalOrderRepo;

    public function __construct(RentalOrderRepository $rentalOrderRepo)
    {
        parent::__construct();
        $this->rentalOrderRepo = $rentalOrderRepo;
    }

    public function handle()
    {
        $date = $this->argument('date') ?? Carbon::today()->toDateString();

        $count = $this->rentalOrderRepo->countByDate($date);

        $this->info("Ngày: $date - Tổng số đơn thuê: $count");

        return 0;
    }
}
