<?php
// app/Http/Requests/ApplicationRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'applicant'; // 💕 Fixed!
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'date_of_birth' => 'required|date|before:today|after:1900-01-01',
            'gender' => 'required|in:male,female',
            'nationality' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20|regex:/^[0-9+\-\s]+$/',
            'birth_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'photo' => 'required|file|mimes:jpg,jpeg,png|max:1024|dimensions:min_width=300,min_height=300',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'first_name.regex' => 'First name can only contain letters and spaces.',
            'last_name.regex' => 'Last name can only contain letters and spaces.',
            'date_of_birth.before' => 'Date of birth must be before today.',
            'date_of_birth.after' => 'Please enter a valid date of birth.',
            'phone.regex' => 'Please enter a valid phone number.',
            'birth_certificate.mimes' => 'Birth certificate must be a PDF or image file.',
            'birth_certificate.max' => 'Birth certificate file size must not exceed 2MB.',
            'photo.mimes' => 'Photo must be an image file (JPG, JPEG, PNG).',
            'photo.max' => 'Photo file size must not exceed 1MB.',
            'photo.dimensions' => 'Photo must be at least 300x300 pixels.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'first_name' => 'first name',
            'last_name' => 'last name',
            'date_of_birth' => 'date of birth',
            'birth_certificate' => 'birth certificate',
            'photo' => 'photograph',
        ];
    }
}
