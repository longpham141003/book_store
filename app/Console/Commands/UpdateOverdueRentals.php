<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\Interface\RentalOrderRepository;
use Carbon\Carbon;

class UpdateOverdueRentals extends Command
{
    protected $signature = 'rental:update-overdue';
    protected $description = 'Cập nhật trạng thái đơn thuê quá hạn trả';

    protected RentalOrderRepository $rentalOrderRepo;

    public function __construct(RentalOrderRepository $rentalOrderRepo)
    {
        parent::__construct();
        $this->rentalOrderRepo = $rentalOrderRepo;
    }

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $overdueOrders = $this->rentalOrderRepo->getOverdueOrders($today);

        if ($overdueOrders->isEmpty()) {
            $this->info("Không có đơn thuê nào quá hạn.");
            return 0;
        }

        foreach ($overdueOrders as $order) {
            $order->update(['status' => 'overdue']);
        }

        $this->info("⚠️ Đã cập nhật " . count($overdueOrders) . " đơn thuê quá hạn.");
        return 0;
    }
}
