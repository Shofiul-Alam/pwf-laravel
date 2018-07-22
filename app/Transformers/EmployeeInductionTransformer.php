<?php

namespace App\Transformers;


use App\Models\EmployeeInduction;
use App\Models\Form;
use League\Fractal\TransformerAbstract;

class EmployeeInductionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(EmployeeInduction $employeeInduction)
    {
        return [
            'identifier' => (int) $employeeInduction->id,
            'description' => (string) $employeeInduction->induction_details,
            'uploadFileName' => (string) $employeeInduction->induction_file_name,
            'uploadFileType' => (string) $employeeInduction->induction_file_type,
            'uploadFileUrl' => (string) $employeeInduction->induction_file_url,
            'uploadFileSize' => (string) $employeeInduction->induction_file_size,
            'createdOn' => (string) $employeeInduction->created_at,
            'updatedOn' => (string) $employeeInduction->updated_at,
            'deletedOn' => (string) $employeeInduction->deleted_at,
            'formIdentifier' => $employeeInduction->form_id,
            'employeeIdentifier' => $employeeInduction->employee_id,

            'links' =>[
//                [
//                    'rel' => 'access.vehicle',
//                    'href' => route('vehicles.show', $employeeInduction->vehicle_id),
//                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'description' => 'induction_details',
            'uploadFileName' => 'induction_file_name',
            'uploadFileType' => 'induction_file_type',
            'uploadFileUrl' => 'induction_file_url',
            'uploadFileSize' => 'induction_file_size',
            'createdOn' => 'created_at',
            'updatedOn' => 'updated_at',
            'deletedOn' => 'deleted_at',
            'formIdentifier' => 'form_id',
            'employeeIdentifier' => 'employee_id',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id' => 'identifier',
            'induction_details' => 'description',
            'induction_file_name' => 'uploadFileName',
            'induction_file_type' => 'uploadFileType',
            'induction_file_url' => 'uploadFileUrl',
            'induction_file_size' => 'uploadFileSize',
            'created_at' => 'createdOn',
            'updated_at' => 'updatedOn',
            'deleted_at' => 'deletedOn',
            'form_id' => 'formIdentifier',
            'employee_id'=> 'employeeIdentifier',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
