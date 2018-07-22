<?php

namespace App\Transformers;


use App\Models\AllocatedDate;
use App\Models\Employee;
use App\Models\EmployeeAllocation;
use League\Fractal\TransformerAbstract;

class AllocatedDateTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(AllocatedDate $allocatedDate)
    {
        return [
            'identifier' => (int) $allocatedDate->id,
            'allocatedOn' => (string) $allocatedDate->date,
            'allocatedDay' => (string) $allocatedDate->day,
            'employeeResponse' => (string) $allocatedDate->respond,
            'isCanceled' => (string) $allocatedDate->cancel_allocation,
            'isAccepted' => (string) $allocatedDate->accept_allocation,
            'createdOn' => (string) $allocatedDate->created_at,
            'updatedOn' => (string) $allocatedDate->updated_at,
            'deletedOn' => (string) $allocatedDate->deleted_at,
            'employeeAllocation' => EmployeeAllocation::findOrFail($allocatedDate->employee_allocation_id),
            'employee' => Employee::findOrFail($allocatedDate->employee_id),

            'links' =>[
//                [
//                    'rel' => 'access.vehicle',
//                    'href' => route('vehicles.show', $allocatedDate->vehicle_id),
//                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'allocatedOn' => 'date',
            'allocatedDay' => 'day',
            'employeeResponse' => 'respond',
            'isCanceld' => 'cancel_allocation',
            'isAccepted' => 'accept_allocation',
            'createdOn' => 'created_at',
            'updatedOn' => 'updated_at',
            'deletedOn' => 'deleted_at',
            'employeeIdentifier' => 'employee_id',
            'employeeAllocationIdentifier' => 'employee_allocation_id',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id' => 'identifier',
            'date' => 'allocatedOn',
            'day' => 'allocatedDay',
            'respond' => 'employeeResponse',
            'cancel_allocation' => 'isCanceld',
            'accept_allocation' => 'isAccepted',
            'created_at' => 'createdOn',
            'updated_at' => 'updatedOn',
            'deleted_at' => 'deletedOn',
            'employee_allocation_id' => 'employeeAllocationIdentifier',
            'employee_id' => 'employeeIdentifier',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
