<?php

namespace App\Transformers;



use App\Models\Config;
use League\Fractal\TransformerAbstract;

class ConfigTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(Config $config)
    {
        return [
            'identifier' => (int) $config->id,
            'category' => (string) $config->category,
            'property' => (string) $config->property,
            'value' => (string) $config->value,
            'createdOn' => (string) $config->created_at,
            'updatedOn' => (string) $config->updated_at,
            'deletedOn' => (string) $config->deleted_at
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'category' => 'category',
            'property' => 'property',
            'value' => 'value',
            'createdOn' => 'created_at',
            'updatedOn' => 'updated_at',
            'deletedOn' => 'deleted_at'

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id' => 'identifier',
            'category' => 'category',
            'property' => 'property',
            'value' => 'value',
            'created_at' => 'createdOn',
            'updated_at' => 'updatedOn',
            'deleted_at' => 'deletedOn',
        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
