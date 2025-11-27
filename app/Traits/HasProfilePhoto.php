<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasProfilePhoto
{
    /**
     * Update the user's profile photo.
     */
    public function updateProfilePhoto(UploadedFile $photo): void
    {
        tap($this->profile_photo_path, function ($previous) use ($photo) {
            $this->forceFill([
                'profile_photo_path' => $photo->storePublicly(
                    'profile-photos',
                    ['disk' => $this->profilePhotoDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->profilePhotoDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the user's profile photo.
     */
    public function deleteProfilePhoto(): void
    {
        if (is_null($this->profile_photo_path)) {
            return;
        }

        Storage::disk($this->profilePhotoDisk())->delete($this->profile_photo_path);

        $this->forceFill([
            'profile_photo_path' => null,
        ])->save();
    }

    /**
     * Get the URL to the user's profile photo.
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : $this->defaultProfilePhotoUrl();
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     * Uses ui-avatars.com API to generate avatars with initials (same as Jetstream)
     */
    protected function defaultProfilePhotoUrl(): string
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=7F9CF5&background=EBF4FF&size=150&bold=true';
    }

    /**
     * Get the disk that profile photos should be stored on.
     */
    protected function profilePhotoDisk(): string
    {
        return config('app.profile_photo_disk', 'public');
    }

    /**
     * Get the user's initials for display.
     */
    public function getInitialsAttribute(): string
    {
        return collect(explode(' ', $this->name))
            ->map(fn ($name) => mb_substr($name, 0, 1))
            ->take(2)
            ->implode('');
    }

    /**
     * Determine if the user has a profile photo.
     */
    public function hasProfilePhoto(): bool
    {
        return !is_null($this->profile_photo_path);
    }
}
