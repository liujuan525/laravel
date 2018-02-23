<?php

namespace App\Observers;

use App\Models\Reply;

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
        $reply->topic->increment('reply_count', 1);
    }

    public function updating(Reply $reply)
    {
        //
    }
}