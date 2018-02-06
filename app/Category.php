<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='category';
    protected $fillable=['title','type'];

    /**
     * 分类关联文章
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function article()
    {
        return $this -> hasMany('App\Article');
    }

}
