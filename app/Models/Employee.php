<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\EmployeeTransformer;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $transformer = EmployeeTransformer::class;

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'mobile',
        'dob',
        'address',
        'nationality',
        'emergency_contact_name',
        'emergency_contact_phone',
        'bank_name',
        'bank_account_no',
        'bank_bsb',
        'tfn_no',
        'abn_no',
        'super_provider',
        'super_no',
        'is_commited_crime',
        'crime_details',
        'isAboriginal',
        'isIslander',
        'avater_name',
        'avater_url',
        'avater_file_type',
        'avater_file_size',
        'avater_updated_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id',
        'isApproved',
    ];

    public function setDobAttribute($value) {
        $this->attributes['dob'] = Carbon::parse($value)->format($this->formattedDates['in_format']);
    }
    public function getDobAttribute() {
        if($this->attributes['dob'] != null) {
            return Carbon::parse($this->attributes['dob'])->format($this->formattedDates['out_format']);
        } else {
            return null;
        }

    }


    public function user() {
        return $this->belongsTo(User::class);
    }
    public function positions() {
        return $this->belongsToMany(Position::class, 'employee_position');
    }

    public function timesheets() {
        return $this->hasMany(Timesheet::class);
    }

    public function employeeInductionDatas() {
        return $this->hasMany(EmployeeInductionData::class);
    }

    public function qualifications() {
        return $this->hasMany(Qualification::class);
    }

    public function employeeInductions() {
        return $this->hasMany(EmployeeInduction::class);
    }

    public function allocatedDates() {
        return $this->hasMany(AllocatedDate::class);
    }

    public function forms() {
        return $this->belongsToMany(Form::class);
    }




}
