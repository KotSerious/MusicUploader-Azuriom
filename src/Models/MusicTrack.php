<?php

namespace Azuriom\Plugin\MusicUploader\Models;

use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;

class MusicTrack extends Model
{
    protected $fillable = ['user_id', 'name', 'file_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
