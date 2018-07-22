<?php

namespace App\Transformers;




use App\Models\Employee;
use App\Models\EmployeeForm;
use App\Models\Form;
use League\Fractal\TransformerAbstract;

class EmployeeFormTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(EmployeeForm $inductionPermission)
    {
        return [
            'identifier' => (int) $inductionPermission->id,
            'form' => Form::findOrFail($inductionPermission->form_id),
            'employee' => Employee::findOrFail($inductionPermission->employee_id),
            'createdOn' => (string) $inductionPermission->created_at,
            'updatedOn' => (string) $inductionPermission->updated_at,
            'deletedOn' => (string) $inductionPermission->deleted_at,

            'links' =>[
//                [
//                    'rel' => 'access.vehicle',
//                    'href' => route('vehicles.show', $inductionPermission->vehicle_id),
//                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'formIdentifier' => 'form_id',
            'employeeIdentifier' => 'employee_id',
            'createdOn' => 'created_at',
            'updatedOn' => 'updated_at',
            'deletedOn' => 'deleted_at',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id' => 'identifier',
            'form_id' => 'formIdentifier',
            'employee_id' => 'employeeIdentifier',
            'created_at' => 'createdOn',
            'updated_at' => 'updatedOn',
            'deleted_at' => 'deletedOn',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
