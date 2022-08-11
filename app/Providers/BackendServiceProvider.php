<?php

namespace App\Providers;

use App\Interfaces\AddressInterface;
use App\Interfaces\ArticleInterface;
use App\Interfaces\AttributeInterface;
use App\Interfaces\BaseInterface;
use App\Interfaces\BrandInterface;
use App\Interfaces\CartInterface;
use App\Interfaces\CategoryInterface;
use App\Interfaces\ColorInterface;
use App\Interfaces\ConsultationInterface;
use App\Interfaces\CooperationRequestInterface;
use App\Interfaces\CouponInterface;
use App\Interfaces\CustomerInterface;
use App\Interfaces\OrderInterface;
use App\Interfaces\OrganizationInterface;
use App\Interfaces\OtpInterface;
use App\Interfaces\ProductInterface;
use App\Interfaces\ProductSizeInterface;
use App\Interfaces\ProductTypeInterface;
use App\Interfaces\ProvinceInterface;
use App\Interfaces\ServiceInterface;
use App\Interfaces\ServiceRequestInterface;
use App\Interfaces\SkillInterface;
use App\Interfaces\UserInterface;
use App\Models\Address;
use App\Models\Article;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Color;
use App\Models\Consultation;
use App\Models\CooperationRequest;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Organization;
use App\Models\Otp;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductType;
use App\Models\Province;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\Skill;
use App\Models\User;
use App\Repositories\AddressRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\AttributeRepository;
use App\Repositories\BaseRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CartRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ColorRepository;
use App\Repositories\ConsultationRepository;
use App\Repositories\CooperationRequestRepository;
use App\Repositories\CouponRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\OrderRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\OtpRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductSizeRepository;
use App\Repositories\ProductTypeRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\ServiceRequestRepository;
use App\Repositories\SkillRepository;
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
            SkillInterface::class,
            function() {
                return new SkillRepository(new Skill);
            }
        );
        $this->app->bind(
            CooperationRequestInterface::class,
            function() {
                return new CooperationRequestRepository(new CooperationRequest);
            }
        );
        $this->app->bind(
            ServiceRequestInterface::class,
            function() {
                return new ServiceRequestRepository(new ServiceRequest);
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
        $this->app->bind(
            ProductInterface::class,
            function() {
                return new ProductRepository(new Product);
            }
        );
        $this->app->bind(
            OrderInterface::class,
            function() {
                return new OrderRepository(new Order);
            }
        );
        $this->app->bind(
            BrandInterface::class,
            function() {
                return new BrandRepository(new Brand);
            }
        );
        $this->app->bind(
            CouponInterface::class,
            function() {
                return new CouponRepository(new Coupon);
            }
        );
        $this->app->bind(
            CartInterface::class,
            function() {
                return new CartRepository(new Cart);
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
