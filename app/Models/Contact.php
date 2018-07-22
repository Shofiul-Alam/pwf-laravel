<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\ContactTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public $transformer = ContactTransformer::class;

    protected $fillable = [
        'id',
        'name',
        'mobile',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function clients() {
        return $this->belongsToMany(Client::class);
    }

    public function projects() {
        return $this->belongsToMany(Project::class);
    }
}
