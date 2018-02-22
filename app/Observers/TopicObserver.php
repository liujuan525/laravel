<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic)
    {
        // 防止 XSS 攻击
        $topic->body = clean($topic->body, 'user_topic_body');
        
        // SEO 提取关键字
        $topic->excerpt = make_excerpt($topic->body);
    }
    
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }
}