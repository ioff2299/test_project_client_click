<?php

namespace App\Services;

use App\Repositories\ClickRepository;
use App\Repositories\SiteRepository;
use App\Models\Click;

class ClickService
{
    public function __construct(
        private ClickRepository $clicks,
        private SiteRepository $sites
    ) {}

    public function capture(array $data): ?Click
    {
        $site = $this->sites->findByToken($data['site_token']);
        if (!$site) return null;
        return $this->clicks->create([
            'site_id' => $site->id,
            'url' => $data['url'],
            'clicked_at' => $data['timestamp'] ?? now(),
            'page_x' => intval($data['page_x']),
            'page_y' => intval($data['page_y']),
            'pct_x' => floatval($data['pct_x']),
            'pct_y' => floatval($data['pct_y']),
            'vp_x' => floatval($data['vp_x'] ?? 0),
            'vp_y' => floatval($data['vp_y'] ?? 0),
            'target' => $data['target'] ?? null,
            'user_agent' => $data['user_agent'] ?? null,
            'viewport_width' => intval($data['viewport_width'] ?? 0),
            'viewport_height' => intval($data['viewport_height'] ?? 0),
        ]);
    }

    public function getClicksForSite(int $siteId, ?string $from = null, ?string $to = null)
    {
        return $this->clicks->getBySiteId($siteId, $from, $to);
    }
}
