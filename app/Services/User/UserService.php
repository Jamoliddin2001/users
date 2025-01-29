<?php


namespace App\Services\User;


use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserService
{

    function registerUser(array $data): User;

    function getById(int $id): ?User;

    function getAll(): Collection;
}
