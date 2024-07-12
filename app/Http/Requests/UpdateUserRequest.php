<?php

namespace App\Http\Requests;

use App\Http\Requests\Common\PublicRequest;

class UpdateUserRequest extends PublicRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'bio' => 'nullable|string|max:255',
            'role' => 'nullable|string|in:ADMIN,USER',
            'banner_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'username.string' => 'Username must be a string',
            'username.max' => 'Username must not be greater than 255 characters',

            'bio.string' => 'Bio must be a string',
            'bio.max' => 'Bio must not be greater than 255 characters',

            'banner_picture.image' => 'Banner picture must be an image',
            'banner_picture.mimes' => 'Banner picture must be a file of type: jpeg, png, jpg, gif, svg',
            'banner_picture.max' => 'Banner picture must not be greater than 2048 kilobytes',
            
            'profile_picture.image' => 'Profile picture must be an image',
            'profile_picture.mimes' => 'Profile picture must be a file of type: jpeg, png, jpg, gif, svg',
            'profile_picture.max' => 'Profile picture must not be greater than 2048 kilobytes',
        ];
    }
}
