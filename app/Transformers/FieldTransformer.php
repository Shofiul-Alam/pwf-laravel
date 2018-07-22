<?php

namespace App\Transformers;


use App\Models\Field;
use App\Models\Form;
use App\Models\ValueArr;
use League\Fractal\TransformerAbstract;

class FieldTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(Field $field)
    {
        return [
            'identifier' => (int) $field->id,
            'lable' => (string) $field->label,
            'type' => (string) $field->type,
            'class_name' => (string) $field->class_name,
            'default_vlaue' => (string) $field->default_value,
            'required' => (string) $field->required,
            'description' => (string) $field->description,
            'placeholder' => (string) $field->placeholder,
            'name' => (string) $field->name,
            'access' => (string) $field->access,
            'inline' => (string) $field->inline,
            'value' => (string) $field->value,
            'min' => (string) $field->min,
            'max' => (string) $field->max,
            'optionValue' => ValueArr::where('field_id', $field->id),
//            'form' => Form::findOrFail($field->form_id),

            'links' =>[
//                [
//                    'rel' => 'access.vehicle',
//                    'href' => route('vehicles.show', $field->vehicle_id),
//                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'lable' => 'label',
            'type' => 'type',
            'class_name' => 'class_name',
            'default_vlaue' => 'default_value',
            'required' => 'required',
            'description' => 'description',
            'placeholder' => 'placeholder',
            'name' => 'name',
            'access' => 'access',
            'inline' => 'inline',
            'value' => 'value',
            'min' => 'min',
            'max' => 'max',
            'formIdentifier' => 'form_id',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id' => 'identifier',
            'label' => 'lable',
            'type' => 'type',
            'class_name' => 'class_name',
            'default_value' => 'default_vlaue',
            'required' => 'required',
            'description' => 'description',
            'placeholder' => 'placeholder',
            'name' => 'name',
            'access' => 'access',
            'inline' => 'inline',
            'value' => 'value',
            'min' => 'min',
            'max' => 'max',
            'form_id' => 'formIdentifier',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
