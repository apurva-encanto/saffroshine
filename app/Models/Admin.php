<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Notifications\Notifiable;
class Admin extends Model implements Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'device_token',
        'profile_img'
    ];

    // Add these properties and methods to satisfy the Authenticatable interface
    protected $table = 'admins'; // Specify the table name if it's different from the model name in plural form
    protected $hidden = ['password']; // Hide the password field when serializing the model

    public function getAuthIdentifierName()
    {
        return 'id'; // Assuming your admin table has an 'id' field
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return null; // Not used for now, you can implement it if needed
    }

    public function setRememberToken($value)
    {
        // Not used for now, you can implement it if needed
    }

    public function getRememberTokenName()
    {
        return null; // Not used for now, you can implement it if needed
    }


}
