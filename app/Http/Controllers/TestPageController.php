<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;

class TestPageController extends Controller
{
    public function show(Request $request)
    {
        $currentUrl = '/' . ltrim($request->path(), '/');
        $site = Site::where('domain', $currentUrl)->first();
        if (!$site) {
            abort(404, 'Сайт для этого URL не найден');
        }
        return view('test.page', [
            'site' => $site
        ]);
    }
}
