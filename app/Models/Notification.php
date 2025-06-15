<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function isRead()
    {
        return !is_null($this->read_at);
    }

    public function isUnread()
    {
        return is_null($this->read_at);
    }

    public function markAsRead()
    {
        if ($this->isUnread()) {
            $this->update(['read_at' => now()]);
        }
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Static helper methods
    public static function createForUser($userId, $title, $message)
    {
        return static::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
        ]);
    }

    public static function notifyApplicationUpdate($userId, $applicationNumber, $status)
    {
        $messages = [
            'pending' => "Your application {$applicationNumber} has been submitted and is pending review.",
            'gs_approved' => "Your application {$applicationNumber} has been approved by Grama Sevaka and forwarded to Divisional Secretariat.",
            'ds_approved' => "Congratulations! Your application {$applicationNumber} has been approved. Your digital ID card is ready!",
            'rejected' => "Your application {$applicationNumber} has been rejected. Please check the comments for details."
        ];

        $titles = [
            'pending' => 'Application Submitted',
            'gs_approved' => 'Application Approved by GS',
            'ds_approved' => 'Application Approved - ID Ready!',
            'rejected' => 'Application Rejected'
        ];

        return static::createForUser(
            $userId,
            $titles[$status] ?? 'Application Status Update',
            $messages[$status] ?? "Your application {$applicationNumber} status has been updated to {$status}."
        );
    }
}
