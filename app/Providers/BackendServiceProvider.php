<?php

namespace App\Providers;

use App\Interfaces\ArticleInterface;
use App\Interfaces\BaseInterface;
use App\Interfaces\CategoryInterface;
use App\Interfaces\OrganizationInterface;
use App\Interfaces\OtpInterface;
use App\Interfaces\ProvinceInterface;
use App\Interfaces\UserInterface;
use App\Models\Article;
use App\Models\Category;
use App\Models\Organization;
use App\Models\Otp;
use App\Models\Province;
use App\Models\User;
use App\Repositories\ArticleRepository;
use App\Repositories\BaseRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\OtpRepository;
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
            OtpInterface::class,
            function() {
                return new OtpRepository(new Otp);
            }
        );
        $this->app->bind(
            OrganizationInterface::class,
            function() {
                return new OrganizationRepository(new Organization);
            }
        );
        $this->app->bind(
            CategoryInterface::class,
            function() {
                return new CategoryRepository(new Category);
            }
        );
        $this->app->bind(
            ArticleInterface::class,
            function() {
                return new ArticleRepository(new Article);
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
