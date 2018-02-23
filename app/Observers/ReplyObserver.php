<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        // 对用户的回复内容做过滤 防止XSS 攻击
        $reply->content = clean($reply -> content, 'user_topic_body');
    }
    
    public function created(Reply $reply)
    {
        $topic = $reply -> topic;
        // 话题回复数量加1
        $topic->increment('reply_count', 1);
        // 通知作者话题被回复了
        $topic->user->notify(new TopicReplied($reply));
    }

    public function updating(Reply $reply)
    {
        //
    }
}