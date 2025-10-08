<?php

namespace App\Services;

use App\Repositories\SiteRepository;
use App\Models\Site;

class SiteService
{
    public function __construct(private SiteRepository $sites) {}

    public function list()
    {
        return $this->sites->all();
    }

    public function create(array $data): Site
    {
        return $this->sites->create($data);
    }

    public function getById(int $id): ?Site
    {
        return $this->sites->findById($id);
    }

    public function getByToken(string $token): ?Site
    {
        return $this->sites->findByToken($token);
    }
}
