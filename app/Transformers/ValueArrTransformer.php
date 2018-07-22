<?php

namespace App\Transformers;



use App\Models\Field;
use App\Models\ValueArr;
use League\Fractal\TransformerAbstract;

class ValueArrTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(ValueArr $valueArr)
    {
        return [
            'identifier' => (int) $valueArr->id,
            'label' => (string) $valueArr->name,
            'value' => (int) $valueArr->type,
            'selected' => (string) $valueArr->mime,
            'isCorrect' => (string) $valueArr->size,
            'field' => Field::findOrFail($valueArr->field_id),


            'links' =>[
//                [
//                    'rel' => 'access.vehicle',
//                    'href' => route('vehicles.show', $valueArr->vehicle_id),
//                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'label' => 'name',
            'value' => 'type',
            'selected' => 'mime',
            'isCorrect' => 'size',
            'fieldIdentifier' => 'field_id',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id' => 'identifier',
            'name' => 'label',
            'type' => 'value',
            'mime' => 'selected',
            'size' => 'isCorrect',
            'field_id' => 'fieldIdentifier',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
