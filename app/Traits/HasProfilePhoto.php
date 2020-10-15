<?php namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasProfilePhoto
{
    /**
     * Update the user's profile photo.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @return void
     */
    public function updateProfilePhoto(UploadedFile $photo)
    {
        tap($this->profile_photo_path, function ($previous) use ($photo) {
            $this->forceFill([
                'profile_photo_path' => $photo->storePublicly(
                    'profile-photos', ['disk' => $this->profilePhotoDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->profilePhotoDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the user's profile photo.
     *
     * @return void
     */
    public function deleteProfilePhoto()
    {
        Storage::disk($this->profilePhotoDisk())->delete($this->profile_photo_path);

        $this->forceFill([
            'profile_photo_path' => null,
        ])->save();
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
            if (env('APP_ENV') === 'local') {
                return $this->profile_photo_path ? 'https://setradinghouse.com/storage/'.$this->profile_photo_path
                    : $this->defaultProfilePhotoUrl();
            }

            return $this->profile_photo_path ? Storage::disk($this->profilePhotoDisk())->url($this->profile_photo_path)
                : $this->defaultProfilePhotoUrl();
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    protected function defaultProfilePhotoUrl()
    {
        $getUrl = 'https://ui-avatars.com/api/?name=' . urlencode($this->username) . '&color=7F9CF5&background=EBF4FF';
        if(! empty($this->email)) {
            $hash = md5(strtolower(trim($this->attributes['email'])));
            $getUrl = 'https://www.gravatar.com/avatar/' . $hash . '?d=https%3A%2F%2Fui-avatars.com%2Fapi%2F/' . urlencode($this->username) . '/128/7F9CF5/EBF4FF';
        }

        return $getUrl;
    }

    /**
     * Get the disk that profile photos should be stored on.
     *
     * @return string
     */
    protected function profilePhotoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : 'public';
    }
}
