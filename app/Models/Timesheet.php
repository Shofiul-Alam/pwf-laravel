<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\TimesheetTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timesheet extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $transformer = TimesheetTransformer::class;

    protected $fillable = [
        'id',
        'date',
        'day',
        'start_time',
        'end_time',
        'break_time',
        'isWeekend',
        'isNight',
        'hours',
        'overtime',
        'comment',
        'timesheet_image_name',
        'timesheet_image_url',
        'timesheet_image_type',
        'timesheet_image_size',
        'is_approved',
        'created_at',
        'updated_at',
        'deleted_at',
        'allocated_date_id',
        'order_id',
        'project_id',
        'client_id',
        'employee_id',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function allocatedDate() {
        return $this->belongsTo(AllocatedDate::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }
}
