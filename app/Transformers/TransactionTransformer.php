<?php

namespace App\Transformers;

use App\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
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
    public function transform(Transaction $transaction)
    {
        return [
            'identifier' => (int)$transaction->id,
            'quantity' => (string)$transaction->quantity,
            'buyer' => (string)$transaction->buyer_id,
            'product' => $transaction->product_id,
            'creationDate' => (string)$transaction->created_at,
            'lastChange' => (string)$transaction->updated_at,
            'deletedDate' => isset($transaction->deleted_at) ? (string) $transaction->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes =  [
            'identifier' => 'id',
            'quantity' => 'quantity',
            'buyer' => 'buyer_id',
            'product' => 'product_id',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at',
            'deletedDate' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes =  [
            'id' => 'identifier',
            'quantity' => 'quantity',
            'buyer_id' => 'buyer',
            'product_id' => 'product',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deletedDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
