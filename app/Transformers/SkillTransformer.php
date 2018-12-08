<?php

namespace App\Transformers;


use App\Models\Skill;
use League\Fractal\TransformerAbstract;

class SkillTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(Skill $skill)
    {
        return [
            'identifier' => (int) $skill->id,
            'name' => (string) $skill->name,
            'createdOn' => (string) $skill->created_at,
            'updatedOn' => (string) $skill->updated_at,
            'deletedOn' => (string) $skill->deleted_at,
            'id' => (string) $skill->id,
            'text' => (string) $skill->name,

            'links' =>[
//                [
//                    'rel' => 'access.vehicle',
//                    'href' => route('vehicles.show', $skill->vehicle_id),
//                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
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
            'created_at' => 'createdOn',
            'updated_at' => 'updatedOn',
            'deleted_at' => 'deletedOn',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
