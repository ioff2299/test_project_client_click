<?php

namespace App\Repositories;

use App\Models\Site;

class SiteRepository
{
    public function all()
    {
        return Site::orderBy('id', 'desc')->get();
    }

    public function findByToken(string $token): ?Site
    {
        return Site::where('token', $token)->first();
    }

    public function findById(int $id): ?Site
    {
        return Site::find($id);
    }

    public function create(array $data): Site
    {
        return Site::create($data);
    }
}
