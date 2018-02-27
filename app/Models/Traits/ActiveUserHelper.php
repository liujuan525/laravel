<?php
/**
 * Created by juanLaravel.
 * File: ActiveUserHelper.php
 * User: Hui
 * Date: 2018/2/27
 * Time: 9:44
 */

namespace App\Models\Traits;


use App\Models\Reply;
use App\Models\Topic;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait ActiveUserHelper
{
    // 存放用户临时数据
    protected $users = [];

    // 配置信息
    protected $topic_weight = 4;
    protected $reply_weight = 1;
    protected $pass_days = 7;
    protected $user_number = 6;

    // 缓存相关配置
    protected $cache_key = 'active_users';
    protected $cache_expire_in_minutes = 65;

    public function getActiveUsers()
    {
        // 尝试从缓存中取出 cache_key 对应的数据。如果能取到，便直接返回数据。
        // 否则运行匿名函数中的代码来取出活跃用户数据，返回的同时做了缓存。
        return Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function(){
            $this -> calculateActiveUsers();
        });
    }

    public function calculateAndCacheActiveUsers()
    {
        // 取得活跃用户列表
        $active_users = $this->calculateActiveUsers();

        // 加入缓存
        $this -> cacheActiveUsers($active_users);
    }

    private function calculateActiveUsers()
    {
        $this -> calculateTopicScore();
        $this -> calculateReplyScore();

        // 数组按照得分排序
        $users = array_sort($this -> users, function($user){
            return $user['score'];
        });

        // 排序倒序
        $users = array_reverse($users, True);

        // 获取前几位
        $users = array_slice($users, 0, $this -> user_number, True);

        // 新建一个空集合
        $active_users = collect();

        foreach ($users as $user_id => $user) {
            $user = $this -> find($user_id);

            // 如果数据库里有该用户的话
            if(count($user)) {
                // 将此用户实体放入集合的末尾
                $active_users -> push($user);
            }
        }
        return $active_users;
    }

    private function calculateTopicScore()
    {
        // 从话题数据表里取出限定时间范围（$pass_days）内，有发表过话题的用户
        // 并且同时取出用户此段时间内发布话题的数量
        $topic_user = Topic::query() -> select(DB::raw('user_id, count(*) as topic_count'))
                                     -> where('created_at', '>=', Carbon::now()->subDays($this ->pass_days))
                                     -> groupBy('user_id')
                                     -> get();
        // 根据话题数量计算积分
        foreach ($topic_user as $value) {
            $this -> users[$value->user_id]['score'] = $value -> topic_count * $this -> topic_weight;
        }
    }

    private function calculateReplyScore()
    {
        // 从回复数据表里取出限定时间范围（$pass_days）内，有发表过回复的用户
        // 并且同时取出用户此段时间内发布回复的数量
        $reply_user = Reply::query() -> select(DB::raw('user_id, count(*) as reply_count'))
                                     -> where('created_at', '>=', Carbon::now()->subDays($this -> pass_days))
                                     -> groupBy('user_id')
                                     -> get();
        foreach ($reply_user as $value) {
            $reply_score = $value -> reply_count * $this -> reply_weight;
            if (isset($this -> users[$value->user_id])) {
                $this -> users[$value -> user_id]['score'] += $reply_score;
            } else {
                $this -> users[$value -> user_id]['score'] = $reply_score;
            }
        }
    }

    private function cacheActiveUsers($active_users)
    {
        // 将数组放入缓存
        Cache::put($this->cache_key, $active_users, $this->cache_expire_in_minutes);
    }
}