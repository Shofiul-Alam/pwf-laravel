<?php

namespace App\Transformers;


use App\Models\ViewModels\EmployeeTimeline;
use App\Models\Employee;
use App\Models\EmployeeAllocation;
use League\Fractal\TransformerAbstract;

class EmployeeTimelineTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(EmployeeTimeline $employeeTimeline)
    {
        return [
            'employeeIdentifier' => (int) $employeeTimeline->employeeIdentifier,
            'employeeName' => (string) $employeeTimeline->employeeName,
            'allocatedDates' => $employeeTimeline->allocatedDates,
            'allocationOfPeriod' => $employeeTimeline->allocationOfPeriod,

            'links' =>[
//                [
//                    'rel' => 'access.vehicle',
//                    'href' => route('vehicles.show', $employeeTimeline->vehicle_id),
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
