<?php

namespace App\Http\Controllers;

use App\Models\Article as ArticleModel;
use App\Models\User as UserModel;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        // 获取用户id为2的文章的分类
//        return ArticleModel::findOrfail(2)->category;
        // 获取至少包含三篇文章的用户
//        return UserModel::has('article', '>=', '3')->get();
        // 获取没有文章的用户
//        return UserModel::doesntHave('article')->get();
        // 获取每个用户的文章的数目
//        return UserModel::withCount('article')->get();
        // 渴求式加载  用户的文章
//        return UserModel::with('article') -> get();
        return ArticleModel::paginate(10);

    }
}
