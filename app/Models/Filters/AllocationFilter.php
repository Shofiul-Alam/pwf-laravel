<?php
/**
 * Created by Md Shofiul Alam.
 * User: Shofiul
 * Date: 8/06/2018
 * Time: 3:45 PM
 */

namespace App\Models\Filters;


class AllocationFilter {

    public $inductions = array();

    public $skills = array();

    public $position = array();

    public $startDate;

    public $endDate;


    protected $employees;

    protected $allocatedDates;


    function __construct($inductionIds, $skillIds, $positionId)
    {


    }


    private function getEmployees() {


    }


}