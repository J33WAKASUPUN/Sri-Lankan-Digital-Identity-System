<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // Digital ID System Specific Services
    'digital_id' => [
        'system_name' => env('SYSTEM_NAME', 'Sri Lanka Digital ID System'),
        'admin_email' => env('ADMIN_EMAIL', 'admin@digitalid.gov.lk'),
        'support_email' => env('SUPPORT_EMAIL', 'support@digitalid.gov.lk'),
        'support_phone' => env('SUPPORT_PHONE', '+94-11-1234567'),
        'card_validity_years' => env('CARD_VALIDITY_YEARS', 2),
        'max_file_size_kb' => env('MAX_FILE_SIZE_KB', 2048),
        'allowed_file_types' => env('ALLOWED_FILE_TYPES', 'pdf,jpg,jpeg,png'),
    ],

    // Email Configuration
    'mail' => [
        'verification_expiry_hours' => env('EMAIL_VERIFICATION_EXPIRY', 24),
        'from_address' => env('MAIL_FROM_ADDRESS', 'noreply@digitalid.gov.lk'),
        'from_name' => env('MAIL_FROM_NAME', 'Sri Lanka Digital ID System'),
    ],

    // File Storage
    'storage' => [
        'documents_disk' => env('DOCUMENTS_DISK', 'public'),
        'qr_codes_disk' => env('QR_CODES_DISK', 'public'),
        'photos_disk' => env('PHOTOS_DISK', 'public'),
    ],

    // PDF Generation
    'pdf' => [
        'default_paper_size' => env('PDF_PAPER_SIZE', 'A4'),
        'default_orientation' => env('PDF_ORIENTATION', 'portrait'),
        'margin_top' => env('PDF_MARGIN_TOP', '10mm'),
        'margin_bottom' => env('PDF_MARGIN_BOTTOM', '10mm'),
        'margin_left' => env('PDF_MARGIN_LEFT', '10mm'),
        'margin_right' => env('PDF_MARGIN_RIGHT', '10mm'),
    ],

    // QR Code Settings
    'qr_code' => [
        'size' => env('QR_CODE_SIZE', 300),
        'margin' => env('QR_CODE_MARGIN', 10),
        'format' => env('QR_CODE_FORMAT', 'png'),
        'encoding' => env('QR_CODE_ENCODING', 'UTF-8'),
    ],

    // Security Settings
    'security' => [
        'max_login_attempts' => env('MAX_LOGIN_ATTEMPTS', 5),
        'lockout_duration' => env('LOCKOUT_DURATION', 15), // minutes
        'session_lifetime' => env('SESSION_LIFETIME', 120), // minutes
        'force_https' => env('FORCE_HTTPS', false),
    ],

];
