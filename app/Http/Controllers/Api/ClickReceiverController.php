<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ClickService;
use Illuminate\Http\Request;

class ClickReceiverController extends Controller
{
    public function __construct(private ClickService $clicks) {}

    public function store(Request $request)
    {
        $data = $request->validate([
            'site_token' => 'required|string',
            'url' => 'required|url',
            'timestamp' => 'nullable|date',
            'page_x' => 'required|numeric',
            'page_y' => 'required|numeric',
            'pct_x' => 'required|numeric',
            'pct_y' => 'required|numeric',
        ]);
        $click = $this->clicks->capture(array_merge($data, $request->all()));
        if (!$click) {
            return response()->json(['error' => 'invalid token'], 403);
        }
        return response()->json(['ok' => true], 201);
    }
}
