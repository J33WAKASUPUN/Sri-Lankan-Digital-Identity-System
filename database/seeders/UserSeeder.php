<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SystemSetting;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@digitalid.gov.lk',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'office_location' => 'Central Office',
            'email_verified_at' => now(),
        ]);

        // Create Test Grama Sevaka
        User::create([
            'name' => 'Sunil Perera',
            'email' => 'gs.colombo@digitalid.gov.lk',
            'password' => Hash::make('gs123456'),
            'role' => 'grama_sevaka',
            'office_location' => 'Colombo 01',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Kamala Silva',
            'email' => 'gs.kandy@digitalid.gov.lk',
            'password' => Hash::make('gs123456'),
            'role' => 'grama_sevaka',
            'office_location' => 'Kandy Central',
            'email_verified_at' => now(),
        ]);

        // Create Test Divisional Secretariat
        User::create([
            'name' => 'Dr. Priya Rathnayake',
            'email' => 'ds.colombo@digitalid.gov.lk',
            'password' => Hash::make('ds123456'),
            'role' => 'divisional_secretariat',
            'office_location' => 'Colombo Divisional Secretariat',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Mr. Ajith Fernando',
            'email' => 'ds.kandy@digitalid.gov.lk',
            'password' => Hash::make('ds123456'),
            'role' => 'divisional_secretariat',
            'office_location' => 'Kandy Divisional Secretariat',
            'email_verified_at' => now(),
        ]);

        // Create Test Applicant
        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'password' => Hash::make('user123456'),
            'role' => 'applicant',
            'office_location' => null,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@gmail.com',
            'password' => Hash::make('user123456'),
            'role' => 'applicant',
            'office_location' => null,
            'email_verified_at' => now(),
        ]);

        // Create System Settings
        $this->createSystemSettings();

        $this->command->info('✅ Users and system settings created successfully!');
        $this->command->info('📧 Admin: admin@digitalid.gov.lk / admin123');
        $this->command->info('🏘️ GS: gs.colombo@digitalid.gov.lk / gs123456');
        $this->command->info('🏢 DS: ds.colombo@digitalid.gov.lk / ds123456');
        $this->command->info('👤 User: john.doe@gmail.com / user123456');
    }

    private function createSystemSettings()
    {
        $settings = [
            'system_name' => 'Sri Lanka Digital ID System',
            'admin_email' => 'admin@digitalid.gov.lk',
            'max_file_size' => '2048', // KB
            'allowed_file_types' => 'pdf,jpg,jpeg,png',
            'card_validity_years' => '2',
            'maintenance_mode' => 'false',
            'email_verification_required' => 'true',
            'auto_approve_applications' => 'false',
            'system_version' => '1.0.0',
            'support_email' => 'support@digitalid.gov.lk',
            'support_phone' => '+94-11-1234567',
        ];

        foreach ($settings as $key => $value) {
            SystemSetting::create([
                'key' => $key,
                'value' => $value,
            ]);
        }
    }
}
