<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password', // Make sure this is here and explicit
        'role',
        'office_location',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        // Remove the password hashing cast - we'll do it manually
    ];

    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class);
    }

    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class);
    }

    // Helper methods
    public function isApplicant() { return $this->role === 'applicant'; }
    public function isGramaSevaka() { return $this->role === 'grama_sevaka'; }
    public function isDivisionalSecretariat() { return $this->role === 'divisional_secretariat'; }
    public function isAdmin() { return $this->role === 'admin'; }
}
