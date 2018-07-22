<?php

namespace App\Transformers;


use App\Models\Order;
use App\Models\Task;
use League\Fractal\TransformerAbstract;

class TaskTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(Task $task)
    {
        return [
            'identifier' => (int) $task->id,
            'name' => (string) $task->name,
            'chargeRate' => (int) $task->charge_rate,
            'payRate' => (int) $task->pay_rate,
            'totalEmployees' => (int) $task->number_of_employee,
            'taskStartDate' => (string) $task->start_date,
            'taskEndDate' => (string) $task->end_date,
            'taskStartTime' => (string) $task->start_time,
            'taskEndTime' => (string) $task->end_time,
            'createdOn' => (string) $task->created_at,
            'updatedOn' => (string) $task->updated_at,
            'deletedOn' => (string) $task->deleted_at,
            'order' => Order::findOrFail($task->order_id),

            'links' =>[
//                [
//                    'rel' => 'access.vehicle',
//                    'href' => route('vehicles.show', $task->vehicle_id),
//                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'chargeRate' => 'charge_rate',
            'payRate' => 'pay_rate',
            'totalEmployees' => 'number_of_employee',
            'taskStartDate' => 'start_date',
            'taskEndDate' => 'end_date',
            'taskStartTime' => 'start_time',
            'taskEndTime' => 'end_time',
            'createdOn' => 'created_at',
            'updatedOn' => 'updated_at',
            'deletedOn' => 'deleted_at',
            'orderIdentifier' => 'order_id',
            'positionIdentifier' => 'position_id',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id' => 'identifier',
            'name' => 'name',
            'charge_rate' => 'chargeRate',
            'pay_rate' => 'payRate',
            'number_of_employee' => 'totalEmployees',
            'start_date' => 'taskStartDate',
            'end_date' => 'taskEndDate',
            'start_time' => 'taskStartTime',
            'end_time' => 'taskEndTime',
            'created_at' => 'createdOn',
            'updated_at' => 'updatedOn',
            'deleted_at' => 'deletedOn',
            'order_id' => 'orderIdentifier',
            'position_id' => 'positionIdentifier',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
