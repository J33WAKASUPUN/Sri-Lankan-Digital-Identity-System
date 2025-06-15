<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    protected $fillable = [
        'email',
        'token',
        'expires_at',
        'verified_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    // Helper methods
    public function isExpired()
    {
        return $this->expires_at < now();
    }

    public function isVerified()
    {
        return !is_null($this->verified_at);
    }

    public function isValid()
    {
        return !$this->isExpired() && !$this->isVerified();
    }

    public function markAsVerified()
    {
        $this->update(['verified_at' => now()]);
    }

    // Scopes
    public function scopeValid($query)
    {
        return $query->whereNull('verified_at')
                     ->where('expires_at', '>', now());
    }

    public function scopeForEmail($query, $email)
    {
        return $query->where('email', $email);
    }
}
