<?php

namespace App\Repositories;

use App\Models\Click;
use Illuminate\Support\Collection;

class ClickRepository
{
    public function create(array $data): Click
    {
        return Click::create($data);
    }

    public function getBySiteId(int $siteId, ?string $from = null, ?string $to = null): Collection
    {
        $query = Click::where('site_id', $siteId);
        if ($from) $query->where('clicked_at', '>=', $from);
        if ($to) $query->where('clicked_at', '<=', $to);
        return $query->orderBy('clicked_at', 'desc')->get();
    }
}
