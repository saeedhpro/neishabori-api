<?php

namespace App\Providers;

use App\Interfaces\AddressInterface;
use App\Interfaces\ArticleInterface;
use App\Interfaces\BaseInterface;
use App\Interfaces\CategoryInterface;
use App\Interfaces\ConsultationInterface;
use App\Interfaces\CustomerInterface;
use App\Interfaces\OrganizationInterface;
use App\Interfaces\OtpInterface;
use App\Interfaces\ProvinceInterface;
use App\Interfaces\ServiceInterface;
use App\Interfaces\ServiceRequestInterface;
use App\Interfaces\UserInterface;
use App\Models\Address;
use App\Models\Article;
use App\Models\Category;
use App\Models\Consultation;
use App\Models\Customer;
use App\Models\Organization;
use App\Models\Otp;
use App\Models\Province;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Repositories\AddressRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\BaseRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ConsultationRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\OtpRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\ServiceRequestRepository;
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
        $this->app->bind(
            AddressInterface::class,
            function() {
                return new AddressRepository(new Address);
            }
        );
        $this->app->bind(
            ConsultationInterface::class,
            function() {
                return new ConsultationRepository(new Consultation);
            }
        );
        $this->app->bind(
            CustomerInterface::class,
            function() {
                return new CustomerRepository(new Customer);
            }
        );
        $this->app->bind(
            ServiceInterface::class,
            function() {
                return new ServiceRepository(new Service);
            }
        );
        $this->app->bind(
            ServiceRequestInterface::class,
            function() {
                return new ServiceRequestRepository(new ServiceRequest);
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
