<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SiteService;
use App\Services\ClickService;

use Carbon\Carbon;

class SiteController extends Controller
{
    public function __construct(
        private SiteService $sites,
        private ClickService $clicks
    ) {}

    public function index()
    {
        $sites = $this->sites->list();
        return view('admin.sites.index', compact('sites'));
    }

    public function create()
    {
        return view('admin.sites.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'domain' => 'required']);
        $this->sites->create($request->only('name', 'domain'));
        return redirect()->route('admin.sites')->with('success', 'Site added');
    }

    public function view(int $siteId, Request $request)
    {
        $site = $this->sites->getById($siteId);
        $clicks = $this->clicks->getClicksForSite($siteId, $request->query('from'), $request->query('to'));
        $clicksJson = $clicks->map(fn($c) => [
            'pct_x' => $c->pct_x,
            'pct_y' => $c->pct_y,
            'clicked_at' => $c->clicked_at
                ? Carbon::parse($c->clicked_at)->format('Y-m-d H:i:s')
                : null,
            'url' => $c->url,
        ]);
        return view('admin.sites.view', compact('site', 'clicksJson'));
    }
}
