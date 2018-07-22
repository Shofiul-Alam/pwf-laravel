<?php

namespace App\Transformers;


use App\Models\TmpImage;
use League\Fractal\TransformerAbstract;

class TmpImageTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(TmpImage $tmpImage)
    {
        return [
            'identifier' => (int) $tmpImage->id,
            'name' => (string) $tmpImage->name,
            'type' => (int) $tmpImage->type,
            'mime' => (string) $tmpImage->mime,
            'size' => (string) $tmpImage->size,
            'url' => (string) $tmpImage->url,
            'createdOn' => (string) $tmpImage->created_at,
            'updatedOn' => (string) $tmpImage->updated_at,
            'deletedOn' => (string) $tmpImage->deleted_at,


            'links' =>[
//                [
//                    'rel' => 'access.vehicle',
//                    'href' => route('vehicles.show', $tmpImage->vehicle_id),
//                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'type' => 'type',
            'mime' => 'mime',
            'size' => 'size',
            'url' => 'url',
            'createdOn' => 'created_at',
            'updatedOn' => 'updated_at',
            'deletedOn' => 'deleted_at',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id' => 'identifier',
            'name' => 'name',
            'type' => 'type',
            'mime' => 'mime',
            'size' => 'size',
            'url' => 'url',
            'created_at' => 'createdOn',
            'updated_at' => 'updatedOn',
            'deleted_at' => 'deletedOn',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
