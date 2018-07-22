<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\SkillTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $transformer = SkillTransformer::class;

    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function qualification() {
        return $this->hasOne(Qualification::class);
    }

    public function projects() {
        return $this->belongsToMany(Project::class);
    }
}
