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
        $data = $request->all();

        foreach ($data as $clickData) {
            $validated = validator($clickData, [
                'site_token' => 'required|string',
                'url' => 'required|url',
                'timestamp' => 'nullable|date',
                'page_x' => 'required|numeric',
                'page_y' => 'required|numeric',
                'pct_x' => 'required|numeric',
                'pct_y' => 'required|numeric',
            ])->validate();

            $this->clicks->capture(array_merge($validated, $clickData));
        }

        return response()->json(['ok' => true, 'count' => count($data)], 201);
    }

}
