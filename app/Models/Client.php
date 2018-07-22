<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\ClientTransformer;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];


    public $transformer = ClientTransformer::class;

    protected $fillable = [
        'id',
        'company_name',
        'company_abn_no',
        'office_phone',
        'mobile',
        'contact_details',
        'acn_no',
        'tfn',
        'credit_limit',
        'client_avater_name',
        'client_avater_url',
        'client_avater_type',
        'client_avater_size',
        'user_id',
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function projects() {
        return $this->hasMany(Project::class);
    }

    public function timesheets() {
        return $this->hasMany(Timesheet::class);
    }

    public function contacts() {
        return $this->belongsToMany(Contact::class);
    }



}
