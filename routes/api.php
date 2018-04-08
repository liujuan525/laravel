<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace'=> 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array', 'bindings'],
], function($api) {

    $api -> group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function ($api){
        // 短信验证
        $api->post('verificationCodes', 'VerificationCodesController@store')
            ->name('api.verificationCodes.store');
        // 用户注册
        $api->post('users', 'UsersController@store')
            ->name('api.users.store');
        // 图片验证码
        $api->post('captchas', 'CaptchasController@store')
            ->name('api.captcha.store');
        // 用户登录
        $api->post('authorizations', 'AuthorizationsController@store')
            ->name('api.authorizations.store');
        // 刷新token
        $api->put('authorizations/current', 'AuthorizationsController@update')
            ->name('api.authorizations.update');
        // 删除token
        $api->delete('authorizations/current', 'AuthorizationsController@destroy')
            ->name('api.authorizations.destroy');
    });

    $api -> group([
        'middleware' => 'api.throttle',
        'limit'      => config('api.rate_limits.access.limit'),
        'expires'      => config('api.rate_limits.access.expires'),
    ], function($api){
        // 游客可以访问的接口
        $api->get('categories', 'CategoriesController@index')
            ->name('api.categories.index');
        // 获取话题列表
        $api->get('topics', 'TopicsController@index')
            ->name('api.topics.index');
        $api->get('topics/{topic}', 'TopicsController@show')
            ->name('api.topics.show');
        // 查看某个用户发布的帖子
        $api->get('users/{user}/topics', 'TopicsController@userIndex')
            ->name('api.users.topics.index');

        // 需要 Token 验证的接口
        $api->group([
            'middleware'    => 'api.auth',
        ], function($api){
            // 当前用户的登录信息
            $api->get('user', 'UserController@me')
                ->name('api.user.show');
            // 编辑登录用户信息
            $api->patch('user', 'UsersController@update')
                ->name('api.user.update');
            // 图片接口
            $api->post('images', 'ImagesController@store')
                ->name('api.images.store');
            // 发布话题
            $api->post('topics', 'TopicsController@store')
                ->name('api.topics.store');
            // 修改话题
            $api->patch('topics/{topic}', 'TopicsController@update')
                ->name('api.topics.update');
            // 删除话题
            $api->delete('topics/{topic}', 'TopicsController@destory')
                ->name('api.topics.destory');
            // 回复话题
            $api->post('topics/{topic}/replies', 'RepliesController@store')
                ->name('api.topics.replies.store');

        });
    });

});

$api->version('v2', function($api) {
    $api->get('version', function() {
        return response('this is version v2');
    });
});
