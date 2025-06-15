<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $application_number
 * @property string $first_name
 * @property string $last_name
 * @property \Illuminate\Support\Carbon $date_of_birth
 * @property string $gender
 * @property string $nationality
 * @property string $address
 * @property string $phone
 * @property string $birth_certificate_path
 * @property string $photo_path
 * @property string $status
 * @property string|null $gs_comments
 * @property string|null $ds_comments
 * @property int|null $gs_verified_by
 * @property int|null $ds_verified_by
 * @property \Illuminate\Support\Carbon|null $gs_verified_at
 * @property \Illuminate\Support\Carbon|null $ds_verified_at
 * @property \Illuminate\Support\Carbon|null $submitted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DigitalCard|null $digitalCard
 * @property-read \App\Models\User|null $dsVerifier
 * @property-read mixed $full_name
 * @property-read \App\Models\User|null $gsVerifier
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereApplicationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereBirthCertificatePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereDsComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereDsVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereDsVerifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereGsComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereGsVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereGsVerifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application wherePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereSubmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereUserId($value)
 */
	class Application extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $application_id
 * @property string $card_number
 * @property array<array-key, mixed> $qr_code_data
 * @property string $qr_code_path
 * @property \Illuminate\Support\Carbon $issue_date
 * @property \Illuminate\Support\Carbon $expiry_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Application $application
 * @property-read mixed $qr_code_url
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DigitalCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DigitalCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DigitalCard query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DigitalCard whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DigitalCard whereCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DigitalCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DigitalCard whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DigitalCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DigitalCard whereIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DigitalCard whereQrCodeData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DigitalCard whereQrCodePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DigitalCard whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DigitalCard whereUpdatedAt($value)
 */
	class DigitalCard extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $email
 * @property string $token
 * @property \Illuminate\Support\Carbon $expires_at
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailVerification forEmail($email)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailVerification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailVerification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailVerification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailVerification valid()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailVerification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailVerification whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailVerification whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailVerification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailVerification whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailVerification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailVerification whereVerifiedAt($value)
 */
	class EmailVerification extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $time_ago
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification forUser($userId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification read()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification recent($days = 7)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification unread()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUserId($value)
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting byKey($key)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting startsWith($prefix)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting whereValue($value)
 */
	class SystemSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $office_location
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Application> $applications
 * @property-read int|null $applications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOfficeLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

