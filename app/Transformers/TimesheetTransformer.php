<?php

namespace App\Transformers;


use App\Models\AllocatedDate;
use App\Models\Client;
use App\Models\Order;
use App\Models\Project;
use App\Models\Timesheet;
use League\Fractal\TransformerAbstract;

class TimesheetTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(Timesheet $timesheet)
    {
        return [
            'identifier' => (int) $timesheet->id,
            'date' => (string) $timesheet->date,
            'day' => (int) $timesheet->day,
            'startTime' => (string) $timesheet->start_time,
            'endTime' => (string) $timesheet->end_time,
            'break' => (string) $timesheet->break_time,
            'isWeekend' => (string) $timesheet->isWeekend,
            'isNight' => (string) $timesheet->isNight,
            'generalHours' => (string) $timesheet->hours,
            'overtime' => (string) $timesheet->overtime,
            'comment' => (string) $timesheet->comment,
            'timesheetName' => (string) $timesheet->timesheet_image_name,
            'timesheetUrl' => (string) $timesheet->timesheet_image_url,
            'timesheetFileType' => (string) $timesheet->timesheet_image_type,
            'timesheetFileSize' => (string) $timesheet->timesheet_image_size,
            'isApproved' => (string) $timesheet->is_approved,
            'createdOn' => (string) $timesheet->created_at,
            'updatedOn' => (string) $timesheet->updated_at,
            'deletedOn' => (string) $timesheet->deleted_at,
            'allocation' => AllocatedDate::findOrFail($timesheet->allocated_date_id),
            'order' => Order::findOrFail($timesheet->order_id),
            'project' => Project::findOrFail($timesheet->project_id),
            'client' => Client::findOrFail($timesheet->client_id),
            'employee' => Employee::findOrFail($timesheet->employee_id),


            'links' =>[
//                [
//                    'rel' => 'access.vehicle',
//                    'href' => route('vehicles.show', $timesheet->vehicle_id),
//                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'date' => 'date',
            'day' => 'day',
            'startTime' => 'start_time',
            'endTime' => 'end_time',
            'break' => 'break_time',
            'isWeekend' => 'isWeekend',
            'isNight' => 'isNight',
            'generalHours' => 'hours',
            'overtime' => 'overtime',
            'comment' => 'comment',
            'timesheetName' => 'timesheet_image_name',
            'timesheetUrl' => 'timesheet_image_url',
            'timesheetFileType' => 'timesheet_image_type',
            'timesheetFileSize' => 'timesheet_image_size',
            'isApproved' => 'is_approved',
            'createdOn' => 'created_at',
            'updatedOn' => 'updated_at',
            'deletedOn' => 'deleted_at',
            'allocationIdentifier' => 'allocated_date_id',
            'orderIdentifier' => 'order_id',
            'projectIdentifier' => 'project_id',
            'clientIdentifier' => 'client_id',
            'employeeIdentifier' => 'employee_id',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id' => 'identifier',
            'date' => 'date',
            'day' => 'day',
            'start_time' => 'startTime',
            'end_time' => 'endTime',
            'break_time' => 'break',
            'isWeekend' => 'isWeekend',
            'isNight' => 'isNight',
            'hours' => 'generalHours',
            'overtime' => 'overtime',
            'comment' => 'comment',
            'timesheet_image_name' => 'timesheetName',
            'timesheet_image_url' => 'timesheetUrl',
            'timesheet_image_type' => 'timesheetFileType',
            'timesheet_image_size' => 'timesheetFileSize',
            'is_approved' => 'isApproved',
            'created_at' => 'createdOn',
            'updated_at' => 'updatedOn',
            'deleted_at' => 'deletedOn',
            'allocated_date_id' => 'allocationIdentifier',
            'order_id' => 'orderIdentifier',
            'project_id' => 'projectIdentifier',
            'client_id' => 'clientIdentifier',
            'employee_id' => 'employeeIdentifier',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
