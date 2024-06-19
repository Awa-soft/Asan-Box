<?php

namespace App\Providers;

use App\Models\CRM\Bourse;
use App\Models\CRM\Contact;
use App\Models\CRM\Partner;
use App\Models\Inventory\Brand;
use App\Models\Inventory\Category;
use App\Models\Inventory\Item;
use App\Models\Inventory\Unit;
use App\Models\Logistic\Branch;
use App\Models\Logistic\Warehouse;
use App\Models\POS\PurchaseInvoice;
use App\Models\Setting\Currency;
use App\Models\User;
use App\Policies\CRM\BoursePolicy;
use App\Policies\CRM\ContactPolicy;
use App\Policies\CRM\PartnerPolicy;
use App\Policies\Inventory\BrandPolicy;
use App\Policies\Inventory\CategoryPolicy;
use App\Policies\Inventory\ItemPolicy;
use App\Policies\Inventory\UnitPolicy;
use App\Policies\Logistic\BranchPolicy;
use App\Policies\Logistic\WarehousePolicy;
use App\Policies\Setting\CurrencyPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ProvidersAuthServiceProvider;

class AuthServiceProvider extends ProvidersAuthServiceProvider
{
    /**
     * Register services.
     */

     protected $policies = [
        User::class=>UserPolicy::class,
        Bourse::class=>BoursePolicy::class,
        Contact::class=>ContactPolicy::class,
        Partner::class=> PartnerPolicy::class,
        Unit::class => UnitPolicy::class,
        Item::class => ItemPolicy::class,
        Currency::class=> CurrencyPolicy::class,
        Warehouse::class=>WarehousePolicy::class,
        Branch::class => BranchPolicy::class,
        Brand::class => BrandPolicy::class,
        Category::class => CategoryPolicy::class,
        
     ];
}
