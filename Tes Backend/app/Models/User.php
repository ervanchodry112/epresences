<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'npp',
        'npp_supervisor'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public static function getUserWithToken($email){
        $user = static::where('email', $email)->firstOrFail();

        if (!empty($user->tokens->toArray())) {
            $user->tokens()->delete();
        }

        $token = $user->createToken('authentication');

        $user_data = $user->toArray();
        $user_data['token'] = $token->plainTextToken;
        unset($user_data['tokens']);

        return $user_data;
    }

    public function presences() {
        return $this->hasMany(EPresence::class, 'id_users', 'id');
    }

    public function supervisor(){
        return $this->belongsTo(User::class, 'npp_supervisor', 'npp');
    }

    public function karyawan(){
        return $this->hasMany(User::class, 'npp_supervisor', 'npp');
    }
}
