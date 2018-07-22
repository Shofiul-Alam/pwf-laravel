<?php
/**
 * Created by Md Shofiul Alam.
 * User: Shofiul
 * Date: 8/06/2018
 * Time: 3:45 PM
 */

namespace App\Search\EmployeeSearch\Filters;


use App\Models\Base\BaseModel;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;

class EmployeeFilter extends BaseModel {

    public $dateRange = false;

    protected $fillable = [
        'inductions',
        'qualifications',
        'position',
        'startDate',
        'endDate',
        'dateRange',
    ];



    function __construct()
    {
            parent::__construct();

            if($this->startDate && $this->endDate) {
                $this->dateRange = true;
            }

            $this->setDateRangeAttribute(true);

    }

    public function setDateRangeAttribute($boolean=false)
    {
        $this->dateRange = $boolean;
    }


    public function getEmployees() {

        $query = (new Employee())->newQuery();

        foreach ($this->getAttributes() as $attribute => $value) {
            if($this->{$attribute}) {
                if(method_exists($this, 'apply'.studly_case($attribute))) {
                    $query = $this->{'apply'.studly_case($attribute)}($query);
                }
            }
        }

        return $query->get();

    }

    public function getAllocatedDates() {

        $value = [$this->startDate, $this->endDate];

        return (new Employee())->newQuery()->whereBetween('allocatedDates.date', $value);

    }



    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public function applyInductions(Builder $builder)
    {
        $values = $this->inductions;
        foreach ($values as $value) {
            $builder->whereHas('employeeInductions', function ($q) use ($value) {
                $q->where('employee_inductions.form_id', $value);
            });
        }

        return $builder;

    }

    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */

    public function applyQualifications(Builder $builder)
    {
        $values = $this->qualifications;
        foreach ($values as $value) {
            return $builder->whereHas('qualifications', function ($q) use ($value) {
                $q->where('qualifications.skill_id', $value);
            });
        }

    }


    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public function applyPosition(Builder $builder)
    {
        $value = $this->position;
        return $builder->where('position_id', $value);
    }

    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public function applyDateRange(Builder $builder)
    {
        $value = [$this->startDate, $this->endDate];
        return $builder->whereNotExists('allocatedDates', function ($q) use ($value) {
            $q->whereBetween('allocatedDates.date', $value);
        });
    }
}