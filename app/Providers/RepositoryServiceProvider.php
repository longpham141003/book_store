<?php

namespace App\Providers;

use App\Repositories\Eloquent\BookRepositoryEloquent;
use App\Repositories\Eloquent\CategoryRepositoryEloquent;
use App\Repositories\Eloquent\ImageRepositoryEloquent;
use App\Repositories\Eloquent\RentalOrderDetailRepositoryEloquent;
use App\Repositories\Eloquent\RentalOrderRepositoryEloquent;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use App\Repositories\Interface\BookRepository;
use App\Repositories\Interface\CategoryRepository;
use App\Repositories\Interface\ImageRepository;
use App\Repositories\Interface\RentalOrderDetailRepository;
use App\Repositories\Interface\RentalOrderRepository;
use App\Repositories\Interface\UserRepository;
use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
        $this->app->bind(CategoryRepository::class, CategoryRepositoryEloquent::class);
        $this->app->bind(BookRepository::class, BookRepositoryEloquent::class);
        $this->app->bind(RentalOrderRepository::class, RentalOrderRepositoryEloquent::class);
        $this->app->bind(RentalOrderDetailRepository::class, RentalOrderDetailRepositoryEloquent::class);
        $this->app->bind(ImageRepository::class, ImageRepositoryEloquent::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
