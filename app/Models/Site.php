<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Site extends Model
{
    protected $fillable = ['name', 'domain', 'token'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->token) {
                $model->token = Str::random(40);
            }
        });
    }

    public function clicks()
    {
        return $this->hasMany(Click::class);
    }
}

