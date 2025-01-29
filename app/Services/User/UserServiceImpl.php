<?php


namespace App\Services\User;


use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserServiceImpl implements UserService
{

    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws ValidationException
     */
    public function registerUser(array $data): User
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails())
        {
            throw new ValidationException($validator);
        }

        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data);
    }

    public function getById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->userRepository->getAll();
    }

}
