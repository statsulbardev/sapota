<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\RowRepositoryInterface;
use App\Repositories\Interfaces\ColumnRepositoryInterface;
use App\Repositories\Interfaces\FrontDataRepositoryInterface;
use App\Repositories\FrontDataRepository;
use App\Repositories\RowRepository;
use App\Repositories\ColumnRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Binding IoC RowRepositoryInterface - RowRepository.
         */
        $this->app->bind(
            RowRepositoryInterface::class,
            RowRepository::class
        );

        /**
         * Binding IoC ColumnRepositoryInterface - ColumnRepository.
         */
        $this->app->bind(
            ColumnRepositoryInterface::class,
            ColumnRepository::class
        );

        /**
         * Binding IoC FrontDataRepositoryInterface - FrontDataRepository.
         */
        $this->app->bind(
            FrontDataRepositoryInterface::class,
            FrontDataRepository::class
        );
    }
}
