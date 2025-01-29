<?php


namespace App\Http\Controllers\API\User;


use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    /**
     * @OA\Post(
     *     path="/user/register",
     *     summary="Register a new user",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="Test tester"),
     *             @OA\Property(property="email", type="string", format="email", example="test1@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User registered successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Test tester"),
     *                 @OA\Property(property="email", type="string", example="test1@gmail.com"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", example={
     *                 "email": {"The email has already been taken."}
     *             })
     *         )
     *     )
     * )
     */
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $user = $this->userService->registerUser($request->all());
            return Response::json([
                'message' => 'User registered successfully',
                'data' => $user
            ]);
        } catch (ValidationException $exception) {
            return Response::json([
                'message' => 'Validation Error',
                'errors'  => $exception->errors()
            ], 422);
        }
    }


    /**
     * @OA\Get(
     *      path="/user/{id}",
     *      summary="Get user by ID",
     *      tags={"Users"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of user to return",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="name", type="string", example="Test tester"),
     *              @OA\Property(property="email", type="string", example="test1@gmail.com"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found"
     *      )
     * )
     */
    public function getUserById($id): \Illuminate\Http\JsonResponse
    {
        try {
            $user = $this->userService->getById((int)$id);

            if (!$user)
            {
                return Response::json([
                    'message' => 'User not found'
                ], 404);
            }

            return Response::json([
                $user
            ]);
        } catch (\TypeError $typeError) {
            return Response::json([
                'error' => 'Invalid ID format'
            ], 400);
        }
    }


    /**
     * @OA\Get(
     *      path="/users",
     *      summary="Get all users",
     *      tags={"Users"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="name", type="string", example="Test tester"),
     *                  @OA\Property(property="email", type="string", example="test1@gmail.com"),
     *              )
     *          )
     *      )
     * )
     */
    public function getAllUsers(): \Illuminate\Http\JsonResponse
    {
        $users = $this->userService->getAll();
        return Response::json([
            $users
        ]);
    }

}
