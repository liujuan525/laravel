<?php
/**
 * Created by juanLaravel.
 * File: TopicTransformer.php
 * User: Hui
 * Date: 2018/3/29
 * Time: 12:28
 */

namespace App\Transformers;


use App\Models\Topic;
use League\Fractal\TransformerAbstract;

class TopicTransformer extends TransformerAbstract
{
    public function transformer(Topic $topic)
    {
        return [
            'id' => $topic->id,
            'title' => $topic->title,
            'body' => $topic->body,
            'user_id' => (int) $topic->user_id,
            'category_id' => (int) $topic->category_id,
            'reply_count' => (int) $topic->reply_count,
            'view_count' => (int) $topic->view_count,
            'last_reply_user_id' => (int) $topic->last_reply_user_id,
            'excerpt' => $topic->excerpt,
            'slug' => $topic->slug,
            'created_at' => $topic->created_at->toDateTimeString(),
            'updated_at' => $topic->updated_at->toDateTimeString(),
        ];
    }
}