<?php
namespace Src\Infrastructure\V1\Controllers\User;

use Exception;
use Illuminate\Routing\Controller;
use App\Http\Resources\V1\UserResource;
use App\Http\Request\User\LoginUserRequest;
use App\Http\Request\User\StoreUserRequest;
use App\Http\Request\User\UpdateUserRequest;
use Src\Application\V1\User\ShowUserUseCase;
use Src\Application\V1\User\IndexUserUseCase;
use Src\Application\V1\User\LoginUserUseCase;
use Src\Application\V1\User\StoreUserUseCase;
use Src\Application\V1\User\UpdateUserUseCase;
use Src\Application\V1\User\DestroyUserUseCase;
use Src\Infrastructure\V1\Exceptions\NotFoundException;


class UserController extends Controller
{
    private StoreUserUseCase $storeUserUseCase;
    private LoginUserUseCase $loginUserUseCase;
    private ShowUserUseCase $showUserUseCase;
    private UpdateUserUseCase $updateUserUseCase;
    private IndexUserUseCase $indexUserUseCase;
    private DestroyUserUseCase $destroyUserUseCase;

    public function __construct(
        StoreUserUseCase $storeUserUseCase,
        LoginUserUseCase $loginUserUseCase,
        ShowUserUseCase $showUserUseCase,
        UpdateUserUseCase $updateUserUseCase,
        IndexUserUseCase $indexUserUseCase,
        DestroyUserUseCase $destroyUserUseCase
    ) {
        $this->storeUserUseCase = $storeUserUseCase;
        $this->loginUserUseCase = $loginUserUseCase;
        $this->showUserUseCase = $showUserUseCase;
        $this->updateUserUseCase = $updateUserUseCase;
        $this->indexUserUseCase = $indexUserUseCase;
        $this->destroyUserUseCase = $destroyUserUseCase;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/register",
     *     summary="Registrar un nuevo usuario",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Sandra Montero"),
     *             @OA\Property(property="email", type="string", example="sandra@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="User created")
     *         )
     *     )
     * )
     */

    public function register(StoreUserRequest $request)
    {
        $this->storeUserUseCase->execute(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        return response()->json(['result' => 'User created'], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="Iniciar sesión",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="sandra1@gmail.com"),
     *             @OA\Property(property="password", type="string", example="12345678")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="object",
     *                 @OA\Property(property="headers", type="object", example={}),
     *                 @OA\Property(property="original", type="object",
     *                     @OA\Property(property="user", type="object",
     *                         @OA\Property(property="id", type="integer", example=6),
     *                         @OA\Property(property="name", type="string", example="Sandra"),
     *                         @OA\Property(property="email", type="string", example="sandra1@gmail.com"),
     *                         @OA\Property(property="email_verified_at", type="string", nullable=true, example=null),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-07T17:29:11.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-07T17:29:11.000000Z")
     *                     ),
     *                     @OA\Property(property="token", type="string", example="1|TMmazWlwprJsmI6Mqqav36g8pfA7oIFyuB2zLRP6d2a5a7df")
     *                 ),
     *                 @OA\Property(property="exception", type="object", nullable=true, example=null)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Credenciales inválidas",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid credentials")
     *         )
     *     )
     * )
     */

    public function login(LoginUserRequest $request)
    {
        try {
            $data = $this->loginUserUseCase->execute(
                $request->input('email'),
                $request->input('password')
            );
        } catch (NotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json(['token' => $data], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/user/{id}",
     *     summary="Obtener un usuario por ID",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del usuario",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="User"),
     *             @OA\Property(property="data", type="object", example={"name":"Admin User","email":"admin1@example.com","emailVerifiedDate":""})
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Usuario no encontrado"
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            $user = new UserResource($this->showUserUseCase->execute($id));
        } catch (NotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json(['result' => 'User', 'data' => $user], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/user/{id}",
     *     summary="Eliminar un usuario",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario eliminado",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="User deleted")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $this->destroyUserUseCase->execute($id);

        return response()->json(['result' => 'User deleted'], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/user/{id}",
     *     summary="Actualizar un usuario",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Sandra Montero Sanz"),
     *             @OA\Property(property="email", type="string", example="sandra1@gmail.com"),
     *             @OA\Property(property="password", type="string", example="12345678")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario actualizado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="User updated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error al actualizar el usuario"
     *     )
     * )
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        try {
            $this->updateUserUseCase->execute(
                $id,
                $request->input('name'),
                $request->input('email'),
                $request->input('password')
            );

            return response()->json(['result' => 'User updated'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error'], 422);
        }
    }
}
