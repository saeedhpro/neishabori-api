<?php

namespace App\Providers;

use App\Interfaces\BaseInterface;
use App\Interfaces\ProvinceInterface;
use App\Interfaces\UserInterface;
use App\Models\Province;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            BaseInterface::class,
            BaseRepository::class
        );
        $this->app->bind(
            ProvinceInterface::class,
            function() {
                return new ProvinceRepository(new Province);
            }
        );
        $this->app->bind(
            UserInterface::class,
            function() {
                return new UserRepository(new User);
            }
        );
        $this->app->bind(
            CategoryInter::class,
            function() {
                return new UserRepository(new User);
            }
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
