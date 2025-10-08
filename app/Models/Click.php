<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    protected $fillable = [
        'site_id', 'url', 'clicked_at',
        'page_x', 'page_y', 'pct_x', 'pct_y',
        'vp_x', 'vp_y', 'target', 'user_agent',
        'viewport_width', 'viewport_height'
    ];

    protected $dates = ['clicked_at'];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
