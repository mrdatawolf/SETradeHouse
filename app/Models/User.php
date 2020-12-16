<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use App\Traits\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property  $id
 * @property  $username
 * @property  $email
 * @property  $email_verified_at
 * @property  $password
 * @property  $remember_token
 * @property  $current_team_id
 * @property  $profile_photo_path
 * @property  $server_username
 * @property  $server_id
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'created_at',
        'server_id',
        'server_username',
        'current_team_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    public function roles()
    {
        return $this->belongsToMany('App\Models\Roles');
    }


    /**
     * note: is the user a website admin
     * @return bool
     */
    public function isAdmin()
    {
        foreach ($this->roles()->get() as $role)
        {
            if ($role->id === 8)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * note: is the user the admin for a server?
     * //todo::make this work correctly...
     * @return bool
     */
    public function isServerAdmin(): bool
    {
        return in_array($this->id, [7,15]);
    }
}
