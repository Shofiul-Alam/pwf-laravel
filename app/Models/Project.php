<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\ProjectTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $transformer = ProjectTransformer::class;

    protected $fillable = [
        'id',
        'name',
        'address',
        'created_at',
        'updated_at',
        'deleted_at',
        'client_id',
    ];

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function timesheets() {
        return $this->hasMany(Timesheet::class);
    }

    public function skills() {
        return $this->belongsToMany(Skill::class);
    }

    public function inductions() {
        return $this->belongsToMany(Form::class);
    }

    public function contacts() {
        return $this->belongsToMany(Contact::class);
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }
}
