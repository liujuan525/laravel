<?php
/**
 * Created by juanLaravel.
 * File: CategoryTransformer.php
 * User: Hui
 * Date: 2018/3/27
 * Time: 17:31
 */

namespace App\Transformers;


use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'description' => $category->description,
        ];
    }
}