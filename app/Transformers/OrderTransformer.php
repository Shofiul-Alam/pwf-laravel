<?php

namespace App\Transformers;


use App\Models\Order;
use App\Models\Project;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(Order $order)
    {
        return [
            'identifier' => (int) $order->id,
            'title' => (string) $order->title,
            'orderStart' => (string) $order->start_date,
            'orderEnd' => (string) $order->end_date,
            'description' => (string) $order->description,
            'comments' => (string) $order->comments,
            'status' => (int) $order->status,
            'createdOn' => (string) $order->created_at,
            'updatedOn' => (string) $order->updated_at,
            'deletedOn' => (string) $order->deleted_at,
            'project' => Project::findOrFail($order->project_id),

            'links' =>[
//                [
//                    'rel' => 'access.vehicle',
//                    'href' => route('vehicles.show', $order->vehicle_id),
//                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'title' => 'title',
            'orderStart' => 'start_date',
            'orderEnd' => 'end_date',
            'description' => 'description',
            'comments' => 'comments',
            'status' => 'status',
            'createdOn' => 'created_at',
            'updatedOn' => 'updated_at',
            'deletedOn' => 'deleted_at',
            'projectIdentifier' => 'project_id',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id' => 'identifier',
            'title' => 'title',
            'start_date' => 'orderStart',
            'end_date' => 'orderEnd',
            'description' => 'description',
            'comments' => 'comments',
            'status' => 'status',
            'created_at' => 'createdOn',
            'updated_at' => 'updatedOn',
            'deleted_at' => 'deletedOn',
            'project_id' => 'projectIdentifier',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
