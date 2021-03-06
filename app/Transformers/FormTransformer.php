<?php

namespace App\Transformers;



use App\Models\Form;

use App\Traits\ApiResponser;
use League\Fractal\TransformerAbstract;

class FormTransformer extends TransformerAbstract
{

    use ApiResponser;

    protected $availableIncludes = [
        'fields',
    ];



    public function includeFileds(Form $form)
    {
        return $form->fields()->with('valueArr')->get();

    }


    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(Form $form)
    {
        return [
            'identifier' => (int) $form->id,
            'name' => (string) $form->name,
            'isInduction' => (string) $form->isInduction,
            'inductionName' => (string) $form->induction_name,
            'createdOn' => (string) $form->created_at,
            'updatedOn' => (string) $form->updated_at,
            'deletedOn' => (string) $form->deleted_at,
            'fields' => $this->includeFileds($form),
            'links' =>[
//                [
//                    'rel' => 'access.vehicle',
//                    'href' => route('vehicles.show', $form->vehicle_id),
//                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'isInduction' => 'isInduction',
            'inductionName' => 'induction_name',
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
            'isInduction' => 'isInduction',
            'induction_name' => 'inductionName',
            'created_at' => 'createdOn',
            'updated_at' => 'updatedOn',
            'deleted_at' => 'deletedOn',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
