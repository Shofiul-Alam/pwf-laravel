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
        $this->issue_date = Carbon::parse($value)->format('d/m/Y');
    }

    public function setExpireDateAttribute($value) {
        $this->expire_date = Carbon::parse($value)->format('d/m/Y');
    }

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function skill() {
        return $this->belongsTo(Skill::class);
    }
}
