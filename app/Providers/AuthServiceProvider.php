<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Address;
use App\Models\Business;
use App\Models\Category;
use App\Models\Contact;
use App\Models\CookingStyle;
use App\Models\Diet;
use App\Models\OpeningHours;
use App\Models\Phone;
use App\Models\Review;
use App\Models\Role;
use App\Models\User;
use App\Policies\AddressPolicy;
use App\Policies\BusinessPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ContactPolicy;
use App\Policies\CookingStylePolicy;
use App\Policies\DietPolicy;
use App\Policies\OpeningHoursPolicy;
use App\Policies\PhonePolicy;
use App\Policies\ReviewPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Business::class => BusinessPolicy::class,
        Address::class => AddressPolicy::class,
        Category::class => CategoryPolicy::class,
        Contact::class => ContactPolicy::class,
        CookingStyle::class => CookingStylePolicy::class,
        Diet::class => DietPolicy::class,
        OpeningHours::class => OpeningHoursPolicy::class,
        Phone::class => PhonePolicy::class,
        Review::class => ReviewPolicy::class,
        Role::class => RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::tokensCan([
            'admin' => 'Admin',
            'user' => 'User',
        ]);

        Passport::setDefaultScope([
            'user',
            'admin',
        ]);
    }
}
