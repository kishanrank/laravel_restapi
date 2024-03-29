<?php

namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'identifier' => (int)$category->id,
            'title' => (string)$category->name,
            'details' => (string)$category->description,
            'creationDate' => (string)$category->created_at,
            'lastChange' => (string)$category->updated_at,
            'deletedDate' => isset($category->deleted_at) ? (string) $category->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes =  [
            'id' => 'identifier',
            'name' => 'title',
            'description' => 'detail',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deletedDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes =  [
            'identifier' => 'id',
            'title' => 'name',
            'detail' => 'description',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at',
            'deletedDate' => 'deleted_at',
        ];
        echo "<pre>";
        
        print_r($attributes);
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
