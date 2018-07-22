<?php

namespace App\Models\Base;

/**
 * Created By: Shofiul
 * Date: 23/05/2018
 * Time: 10:39 AM
 */



use Illuminate\Database\Eloquent\Model;


class BaseModel extends Model {
    /**
     * Datetime attributes that should be auto manages
     *
     * @var array
     */
    public $formattedDates = [
            'in_format'  => 'Y-m-d H:i:s',
            'out_format' => 'd/m/Y'
            ];
}