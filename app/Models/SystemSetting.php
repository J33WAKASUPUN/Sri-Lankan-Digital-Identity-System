<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = [
        'key',
        'value'
    ];

    // Helper methods
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value)
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    public static function has($key)
    {
        return static::where('key', $key)->exists();
    }

    public static function remove($key)
    {
        return static::where('key', $key)->delete();
    }

    // Get commonly used settings
    public static function getApplicationSettings()
    {
        return [
            'max_file_size' => static::get('max_file_size', '2048'), // KB
            'allowed_file_types' => static::get('allowed_file_types', 'pdf,jpg,jpeg,png'),
            'card_validity_years' => static::get('card_validity_years', '2'),
            'admin_email' => static::get('admin_email', 'admin@digitalid.gov.lk'),
            'system_name' => static::get('system_name', 'Sri Lanka Digital ID System'),
            'maintenance_mode' => static::get('maintenance_mode', 'false'),
        ];
    }

    // Scopes
    public function scopeByKey($query, $key)
    {
        return $query->where('key', $key);
    }

    public function scopeStartsWith($query, $prefix)
    {
        return $query->where('key', 'like', $prefix . '%');
    }
}
