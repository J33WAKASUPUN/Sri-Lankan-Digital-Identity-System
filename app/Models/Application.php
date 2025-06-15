<?php
// app/Models/Application.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'application_number', 'first_name', 'last_name',
        'date_of_birth', 'gender', 'nationality', 'address', 'phone',
        'birth_certificate_path', 'photo_path', 'status',
        'gs_comments', 'ds_comments', 'gs_verified_by', 'ds_verified_by',
        'gs_verified_at', 'ds_verified_at', 'submitted_at'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'gs_verified_at' => 'datetime',
        'ds_verified_at' => 'datetime',
        'submitted_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($application) {
            $application->application_number = 'APP-' . date('Y') . '-' . str_pad(static::count() + 1, 6, '0', STR_PAD_LEFT);
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function digitalCard()
    {
        return $this->hasOne(\App\Models\DigitalCard::class);
    }

    public function gsVerifier()
    {
        return $this->belongsTo(\App\Models\User::class, 'gs_verified_by');
    }

    public function dsVerifier()
    {
        return $this->belongsTo(\App\Models\User::class, 'ds_verified_by');
    }

    // Helper methods
    public function getFullNameAttribute() { return $this->first_name . ' ' . $this->last_name; }
    public function isPending() { return $this->status === 'pending'; }
    public function isGsApproved() { return $this->status === 'gs_approved'; }
    public function isDsApproved() { return $this->status === 'ds_approved'; }
    public function isRejected() { return $this->status === 'rejected'; }
}
