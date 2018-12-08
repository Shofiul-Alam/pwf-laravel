<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\QualificationTransformer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Qualification extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $transformer = QualificationTransformer::class;

    protected $fillable = [
        'id',
        'issue_date',
        'expire_date',
        'qualification_details',
        'qualification_image',
        'qualification_image_url',
        'qualification_image_type',
        'qualification_image_size',
        'created_at',
        'updated_at',
        'deleted_at',
        'employee_id',
        'skill_id',
    ];

    public function setIssueDateAttribute($value) {
        $this->attributes['issue_date'] = Carbon::parse($value)->format($this->formattedDates['in_format']);
    }
    public function getIssueDateAttribute() {
        if($this->attributes['issue_date'] != null) {
            return Carbon::parse($this->attributes['issue_date'])->format($this->formattedDates['out_format']);
        } else {
            return null;
        }

    }

    public function setExpireDateAttribute($value) {
        $this->attributes['expire_date'] = Carbon::parse($value)->format($this->formattedDates['in_format']);
    }

    public function getExpireDateAttribute() {
        if($this->attributes['expire_date'] != null) {
            return Carbon::parse($this->attributes['expire_date'])->format($this->formattedDates['out_format']);
        } else {
            return null;
        }

    }

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function skill() {
        return $this->belongsTo(Skill::class);
    }
}
