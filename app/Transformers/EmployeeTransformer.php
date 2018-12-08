<?php

namespace App\Transformers;


use App\Models\Client;
use App\Models\Employee;
use App\User;
use League\Fractal\TransformerAbstract;

class EmployeeTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(Employee $employee)
    {

        return [
            'identifier' => (int) $employee->id,
            'firstName' => (string) $employee->first_name,
            'lastName' => (string) $employee->last_name,
            'mobile' => (string) $employee->mobile,
            'dob' => (string) $employee->dob,
            'address' => (string) $employee->address,
            'nationality' => (string) $employee->nationality,
            'emargencyContact' => (string) $employee->emergency_contact_name,
            'emargencyPhone' => (string) $employee->emergency_contact_phone,
            'bankName' => (string) $employee->bank_name,
            'accountNo' => (string) $employee->bank_account_no,
            'bsbNo' => (string) $employee->bank_bsb,
            'tfn' => (string) $employee->tfn_no,
            'abn' => (string) $employee->abn_no,
            'superProvider' => (string) $employee->super_provider,
            'superAccountNo' => (string) $employee->super_no,
            'isConvictedForCrime' => (string) $employee->is_commited_crime,
            'convictionDetails' => (string) $employee->crime_details,
            'isAboriginal' => (string) $employee->isAboriginal,
            'isIslander' => (string) $employee->isIslander,
            'avater' => (string) $employee->avater_name,
            'avaterUrl' => (string) $employee->avater_url,
            'avaterType' => (string) $employee->avater_file_type,
            'avaterSize' => (string) $employee->avater_file_size,
            'avaterUpdatedOn' => (string) $employee->avater_updated_at,
            'createdOn' => (string) $employee->created_at,
            'updatedOn' => (string) $employee->updated_at,
            'deletedOn' => (string) $employee->deleted_at,
            'approved' => $employee->isApproved,
            'lat' => (string) $employee->lat,
            'long' => (string) $employee->long,
            'user' => UserTransformer::transform(User::findOrFail($employee->user_id)),
            'positions' => $this->transformPositions($employee->positions),

            'links' =>[
//                [
//                    'rel' => 'access.vehicle',
//                    'href' => route('vehicles.show', $employee->vehicle_id),
//                ],
            ]
        ];
    }

    private function transformPositions($positions) {
        $positionsArr= array();
        foreach ($positions as $position) {
            array_push($positionsArr, PositionTransformer::transform($position));
        }

        return $positionsArr;
    }

    public static function originalAttribute($index) {

        $attributes = [
            'identifier' => 'id',
            'firstName' => 'first_name',
            'lastName' => 'last_name',
            'mobile' => 'mobile',
            'dob' => 'dob',
            'address' => 'address',
            'nationality' => 'nationality',
            'emargencyContact' => 'emergency_contact_name',
            'emargencyPhone' => 'emergency_contact_phone',
            'bankName' => 'bank_name',
            'accountNo' => 'bank_account_no',
            'bsbNo' => 'bank_bsb',
            'tfn' => 'tfn_no',
            'abn' => 'abn_no',
            'superProvider' => 'super_provider',
            'superAccountNo' => 'super_no',
            'isConvictedForCrime' => 'is_commited_crime',
            'convictionDetails' => 'crime_details',
            'isAboriginal' => 'isAboriginal',
            'isIslander' => 'isIslander',
            'avater' => 'avater_name',
            'avaterUrl' => 'avater_url',
            'avaterType' => 'avater_file_type',
            'avaterSize' => 'avater_file_size',
            'avaterUpdatedOn' => 'avater_updated_at',
            'createdOn' => 'created_at',
            'updatedOn' => 'updated_at',
            'deletedOn' => 'deleted_at',
            'approved' => 'isApproved',
            'userIdentifier' => 'user_id',
            'image' => 'image',
            'positionsIdentifier' => 'positionsIdentifier',
            'lat' => 'lat',
            'long' => 'long'


        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }

    public static function transformedAttribute($index) {

        $attributes = [
            'id' => 'identifier',
            'first_name' => 'firstName',
            'last_name' => 'lastName',
            'mobile' => 'mobile',
            'dob' => 'dob',
            'address' => 'address',
            'nationality' => 'nationality',
            'emergency_contact_name' => 'emargencyContact',
            'emergency_contact_phone' => 'emargencyPhone',
            'bank_name' => 'bankName',
            'bank_account_no' => 'accountNo',
            'bank_bsb' => 'bsbNo',
            'tfn_no' => 'tfn',
            'abn_no' => 'abn',
            'super_provider' => 'superProvider',
            'super_no' => 'superAccountNo',
            'is_commited_crime' => 'isConvictedForCrime',
            'crime_details' => 'convictionDetails',
            'isAboriginal' => 'isAboriginal',
            'isIslander' => 'isIslander',
            'avater_name' => 'avater',
            'avater_url' => 'avaterUrl',
            'avater_file_type' => 'avaterType',
            'avater_file_size' => 'avaterSize',
            'avater_updated_at' => 'avaterUpdatedOn',
            'created_at' => 'createdOn',
            'updated_at' => 'updatedOn',
            'deleted_at' => 'deletedOn',
            'isApproved' => 'approved',
            'user_id' => 'userIdentifier',
            'lat' => 'lat',
            'long' => 'long'

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
