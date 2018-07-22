<?php

namespace App\Transformers;


use App\Models\Employee;
use App\Models\EmployeeInductionData;
use App\Models\Field;
use App\Models\Form;
use App\Models\ValueArr;
use League\Fractal\TransformerAbstract;

class EmployeeInductionDataTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(EmployeeInductionData $employeeInductionData)
    {
        return [
            'identifier' => (int) $employeeInductionData->id,
            'value' => (string) $employeeInductionData->value,
            'optionValue' => ValueArr::findOrFail($employeeInductionData->value_arr_id),
            'field' => Field::findOrFail($employeeInductionData->field_id),
            'form' => Form::findOrFail($employeeInductionData->form_id),
            'employee' => Employee::findOrFail($employeeInductionData->employee_id),

            'links' =>[
//                [
//                    'rel' => 'access.vehicle',
//                    'href' => route('vehicles.show', $employeeInductionData->vehicle_id),
//                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'value' => 'value',
            'optionValueIdentifier' => 'value_arr_id',
            'fieldIdentifier' => 'field_id',
            'formIdentifier' => 'form_id',
            'employeeIdentifier' => 'employee_id',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id' => 'identifier',
            'value' => 'value',
            'value_arr_id' => 'optionValueIdentifier',
            'field_id' => 'fieldIdentifier',
            'form_id' => 'formIdentifier',
            'employee_id' => 'employeeIdentifier',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
