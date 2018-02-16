<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $dates=['created_at','updated_at','deleted_at'];

    protected $fillable = ['title', 'content', 'created_at'];

    /**
     * 文章关联用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this -> belongsTo('App\Models\User');
    }

    /**
     * 文章关联分类
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this -> belongsTo('App\Category');
    }


}
