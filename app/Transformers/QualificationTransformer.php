<?php

namespace App\Transformers;


use App\Models\Employee;
use App\Models\Qualification;
use App\Models\Skill;
use League\Fractal\TransformerAbstract;

class QualificationTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(Qualification $qualification)
    {
        return [
            'identifier' => (int) $qualification->id,
            'issuedBy' => (string) $qualification->issue_date,
            'expireOn' => (string) $qualification->expire_date,
            'description' => (string) $qualification->qualification_details,
            'documentName' => (string) $qualification->qualification_image,
            'documentUrl' => (string) $qualification->qualification_image_url,
            'documentType' => (string) $qualification->qualification_image_type,
            'documentSize' => (string) $qualification->qualification_image_size,
            'createdOn' => (string) $qualification->created_at,
            'updatedOn' => (string) $qualification->updated_at,
            'deletedOn' => (string) $qualification->deleted_at,
            'employeeIdentifier' => Employee::findOrFail($qualification->employee_id) ?
                                    Employee::findOrFail($qualification->employee_id)->id : [],
            'skill' => Skill::findOrFail($qualification->skill_id),

            'links' =>[
//                [
//                    'rel' => 'access.vehicle',
//                    'href' => route('vehicles.show', $qualification->vehicle_id),
//                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'issuedBy' => 'issue_date',
            'expireOn' => 'expire_date',
            'description' => 'qualification_details',
            'documentName' => 'qualification_image',
            'documentUrl' => 'qualification_image_url',
            'documentType' => 'qualification_image_type',
            'documentSize' => 'qualification_image_size',
            'createdOn' => 'created_at',
            'updatedOn' => 'updated_at',
            'deletedOn' => 'deleted_at',
            'employeeIdentifier' => 'employee_id',
            'skillIdentifier' => 'skill_id',


        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id' => 'identifier',
            'issue_date' => 'issuedBy',
            'expire_date' => 'expireOn',
            'qualification_details' => 'description',
            'qualification_image' => 'documentName',
            'qualification_image_url' => 'documentUrl',
            'qualification_image_type' => 'documentType',
            'qualification_image_size' => 'documentSize',
            'created_at' => 'createdOn',
            'updated_at' => 'updatedOn',
            'deleted_at' => 'deletedOn',
            'employee_id' => 'employeeIdentifier',
            'skill_id' => 'skillIdentifier',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
