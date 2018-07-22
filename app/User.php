<?php

namespace App;

use App\Models\Client;
use App\Models\Employee;
use App\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    const VERIFIED_USER = 1;
    const UNVERIFIED_USER = 0;
    const ADMIN_USER = true;
    const REGULAR_USER = false;

    public $transformer = UserTransformer::class;
    protected $dates = ['deleted_at'];


    /*
     * the table attribute confirm that users is the table but the virtual entity buyer and
     * Seller Inherited from users table.
     */
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'is_verified',
        'verification_token',
        'admin',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];


    public function employee() {
        return $this->hasOne(Employee::class);
    }
    public function client() {
        return $this->hasOne(Client::class);
    }
    public function setEmailAttribute($email) {
        $this->attributes['email'] = strtolower($email);
    }
    public function isVerified() {
        return $this->is_verified == User::VERIFIED_USER;
    }
    public function isAdmin() {
        return boolval($this->admin);
    }
    public function isEmployee() {
        return (bool) $this->employee()->first();
    }
    public function isClient() {
        return (bool) $this->client()->first();
    }
    public static function generateVerificationCode() {
        return str_random(40);
    }

}
