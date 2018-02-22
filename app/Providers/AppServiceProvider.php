<?php

namespace App\Providers;

use App\Observers\TopicObserver;
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
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
