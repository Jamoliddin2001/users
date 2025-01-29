<?php


namespace App\Repositories\User;


use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{

    protected User $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function findById(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

}
