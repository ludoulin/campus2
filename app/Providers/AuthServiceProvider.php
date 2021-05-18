<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Product;
use App\Models\Activity;
use App\Models\Comment;
use App\Models\LinePayTradeRecord;
use App\Models\News;
use App\Models\Reply;
use App\Models\user;
use App\Models\order;
use App\Policies\CommentPolicy;
use App\Policies\UserPolicy;
use App\Policies\ProductPolicy;
use App\Policies\ReplyPolicy;
use App\Policies\OrderPolicy;
use App\Policies\RecordPolicy;
use App\Policies\ActivityPolicy;
use App\Policies\NewsPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Product::class => ProductPolicy::class,
        Comment::class => CommentPolicy::class,
        User::class => UserPolicy::class,
        Reply::class => ReplyPolicy::class,
        Order::class => OrderPolicy::class,
        Activity::class => ActivityPolicy::class,
        News::class => NewsPolicy::class,
        LinePayTradeRecord::class => RecordPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::guessPolicyNamesUsing(function ($modelClass) {
            // 動態返回模型對應的策略名稱，如：// 'App\Model\User' => 'App\Policies\UserPolicy',
            return 'App\Policies\\'.class_basename($modelClass).'Policy';
        });

    }
}
