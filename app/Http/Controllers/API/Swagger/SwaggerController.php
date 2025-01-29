<?php


namespace App\Http\Controllers\API\Swagger;


use App\Http\Controllers\Controller;

class SwaggerController extends Controller
{

    /**
     * @OA\Info(
     *      title="Laravel Users API",
     *      version="1.0.0",
     *      description="Test API TASK Users",
     *      @OA\Contact(
     *          email="sh.jamoliddin2001@gmail.com"
     *      )
     * )
     * @OA\Server(
     *     url="/api",
     *     description="API server"
     * )
     */
    public function index()
    {
        $openapi = \OpenApi\Generator::scan([app_path('Http/Controllers/API')]);
        return response()->json($openapi->toJson());
    }

}
