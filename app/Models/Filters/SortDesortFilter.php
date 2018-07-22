<?php
/**
 * Created by Md Shofiul Alam.
 * User: Shofiul
 * Date: 8/06/2018
 * Time: 3:45 PM
 */

namespace App\Models\Filters;


class SortDesortFilter {
    public static CONST ASC = 'ASC';
    public static CONST DESC = 'DESC';

    public $propertyName;
    public $value;
    public $asc = '';
    public $desc = '';

    function __construct()
    {}

}