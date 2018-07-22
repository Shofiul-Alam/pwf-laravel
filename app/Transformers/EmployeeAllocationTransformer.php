<?php

namespace App\Transformers;


use App\Models\EmployeeAllocation;
use App\Models\Task;
use League\Fractal\TransformerAbstract;

class EmployeeAllocationTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(EmployeeAllocation $employeeAllocation)
    {
        return [
            'identifier' => (int) $employeeAllocation->id,
            'allocatedParitally' => (string) $employeeAllocation->request_send_partially,
            'allocatedFully' => (string) $employeeAllocation->request_send_all,
            'sms' => (string) $employeeAllocation->sms,
            'isCanceledFully' => (string) $employeeAllocation->cancalAll,
            'isAcceptedAll' => (string) $employeeAllocation->acceptAll,
            'isAcceptedPartially' => (string) $employeeAllocation->acceptPartially,
            'createdOn' => (string) $employeeAllocation->created_at,
            'updatedOn' => (string) $employeeAllocation->updated_at,
            'deletedOn' => (string) $employeeAllocation->deleted_at,
            'task' => Task::findOrFail($employeeAllocation->task_id),

            'links' =>[
//                [
//                    'rel' => 'access.vehicle',
//                    'href' => route('vehicles.show', $employeeAllocation->vehicle_id),
//                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'allocatedParitally' => 'request_send_partially',
            'allocatedFully' => 'request_send_all',
            'sms' => 'sms',
            'isCanceledFully' => 'cancalAll',
            'isAcceptedAll' => 'acceptAll',
            'isAcceptedPartially' => 'acceptPartially',
            'createdOn' => 'created_at',
            'updatedOn' => 'updated_at',
            'deletedOn' => 'deleted_at',
            'taskIdentifier' => 'task_id',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id' => 'identifier',
            'request_send_partially' => 'allocatedParitally',
            'request_send_all' => 'allocatedFully',
            'sms' => 'sms',
            'cancalAll' => 'isCanceledFully',
            'acceptAll' => 'isAcceptedAll',
            'acceptPartially' => 'isAcceptedPartially',
            'created_at' => 'createdOn',
            'updated_at' => 'updatedOn',
            'deleted_at' => 'deletedOn',
            'task_id' => 'taskIdentifier',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
