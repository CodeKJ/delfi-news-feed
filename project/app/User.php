<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Intervention\Image\Facades\Image;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Set user avatar accessor
     *
     * @param $value
     * @return string
     */
    public function getAvatarAttribute($value){
        return $value ? "/storage/uploads/{$value}" : "/img/user.png";
    }

    /**
     * Upload, resize and save user avatar
     *
     * @param $image
     */
    public function uploadAvatar($image){
        $avatar = md5(time().$this->id).'.png';
        $destinationPath = public_path('/storage/uploads');

        $img = Image::make($image);
        $img->resize(64, 64, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$avatar);

        $this->avatar = $avatar;
        $this->save();
    }
}
