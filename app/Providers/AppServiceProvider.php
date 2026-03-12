<?php

namespace App\Providers;

// 1. IMPORT SEMUA INTERFACE
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\PromoCodeRepositoryInterface;

// 2. IMPORT SEMUA REPOSITORY (IMPLEMENTASI)
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PromoCodeRepository;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // POLA: singleton(Interface::class, Implementasi::class)

        // Binding Category
        $this->app->singleton(CategoryRepositoryInterface::class, CategoryRepository::class);

        // Binding Product
        $this->app->singleton(ProductRepositoryInterface::class, ProductRepository::class);

        // Binding Order (Tadi lo salah di sini, lo malah bind Class ke Class)
        $this->app->singleton(OrderRepositoryInterface::class, OrderRepository::class);

        // Binding PromoCode (Tadi lo salah di sini juga)
        $this->app->singleton(PromoCodeRepositoryInterface::class, PromoCodeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
