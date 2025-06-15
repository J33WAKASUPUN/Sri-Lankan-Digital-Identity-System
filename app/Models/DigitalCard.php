<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DigitalCard extends Model
{
    protected $fillable = [
        'application_id', 'card_number', 'qr_code_data', 'qr_code_path',
        'issue_date', 'expiry_date', 'status'
    ];

    protected $casts = [
        'qr_code_data' => 'array',
        'issue_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function application() { return $this->belongsTo(Application::class); }
    public function getQrCodeUrlAttribute() { return asset('storage/' . $this->qr_code_path); }
}
