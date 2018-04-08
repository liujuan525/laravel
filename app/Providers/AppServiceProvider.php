<?php

namespace App\Providers;

use App\Observers\TopicObserver;
use Dingo\Api\Facade\API;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 使用中文友好提示 (时间)
        \Carbon\Carbon::setLocale('zh');
        // 注册模型观察器
        \App\Models\Topic::observe(\App\Observers\TopicObserver::class);
        \App\Models\Reply::observe(\App\Observers\ReplyObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (config('app.debug')) {
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }

        API::error(function (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            abort(404);
        });

    }
}
