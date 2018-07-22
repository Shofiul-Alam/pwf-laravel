<?php
/**
 * Created by Shofiul Alam.
 * Author: Shofiul
 * Date: 29/6/18
 * Time: 1:10 PM
 */

namespace App\Models\ViewModels;



use App\Models\Employee;
use App\Transformers\EmployeeTimelineTransformer;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;

class EmployeeTimeline {
    public $employeeName;
    public $employeeIdentifier;
    public $allocatedDates;
    public $allocationOfPeriod = array();

    public $transformer = EmployeeTimelineTransformer::class;


    public function __construct(Employee $employee, array $range)
    {
        $this->employeeIdentifier = $employee->id;
        $this->employeeName = $employee->first_name;

        $period = new DatePeriod(
            $range['startDate'],
            new DateInterval('P1D'),
            $range['endDate']
        );

        /**
         * Create a new Eloquent Collection instance.
         *
         * @param  array  $models
         * @return \Illuminate\Database\Eloquent\Collection
         */

        $this->allocatedDates = $this->getAllocatedDatesByDateRange($employee, $range);

        $this->allocationOfPeriod = $this->prepareAllocatedDates($period);


    }

    protected function prepareAllocatedDates($period) {


        $allocationOfPeriod = array();

        foreach ($period as $key => $date) {

            $allocationOfPeriod[$key]['date'] = $date;

            if($this->allocatedDates->isNotEmpty()) {
                $carbonDate = Carbon::instance($date);
                if($this->allocatedDates->where('date', $carbonDate->toDateString())->isNotEmpty()) {
                    $allocationOfPeriod[$key]['allocatedDates'] = $this->allocatedDates->where('date', $carbonDate->toDateString());
                };
            }
        }


        return $allocationOfPeriod;
    }

    protected function getAllocatedDatesByDateRange(Employee $employee, array $range) {

        $allocatedDates = $employee->allocatedDates();

        return $allocatedDates->whereBetween('date', $range)->get();
    }

//
//$employees = Employee::with(['allocatedDates' => function ($q) use($value) {
//            $q->whereBetween('allocatedDates.date', $value);
//        }])->get();

}