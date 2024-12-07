<?php
namespace Src\Infrastructure\V1\Controllers\User;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\V1\UserResource;
use Src\Application\V1\User\ShowUserUseCase;
use Src\Application\V1\User\IndexUserUseCase;
use Src\Application\V1\User\LoginUserUseCase;
use Src\Application\V1\User\StoreUserUseCase;
use App\Http\Request\User\V1\LoginUserRequest;
use App\Http\Request\User\V1\StoreUserRequest;
use Src\Application\V1\User\UpdateUserUseCase;
use App\Http\Request\User\V1\UpdateUserRequest;
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

    // Inyección de dependencias a través del constructor
    public function __construct(
        StoreUserUseCase $storeUserUseCase,
        LoginUserUseCase $loginUserUseCase,
        ShowUserUseCase $showUserUseCase,
        UpdateUserUseCase $updateUserUseCase,
        IndexUserUseCase $indexUserUseCase,
        DestroyUserUseCase $destroyUserUseCase,
    ) {
        $this->storeUserUseCase = $storeUserUseCase;
        $this->loginUserUseCase = $loginUserUseCase;
        $this->showUserUseCase = $showUserUseCase;
        $this->updateUserUseCase = $updateUserUseCase;
        $this->indexUserUseCase = $indexUserUseCase;
        $this->destroyUserUseCase = $destroyUserUseCase;
    }

    public function register(StoreUserRequest $request)
    {
        $this->storeUserUseCase->execute(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        return response()->json(['result' => 'User created'], 200);
    }
    public function login(LoginUserRequest $request)
    {
        try{
            $data = $this->loginUserUseCase->execute(
            $request->input('email'),
            $request->input('password')
            );
        } catch (NotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }


        return response()->json([$data], 200);
    }

    public function show(string $id)
    {
        try{
            $user = new UserResource($this->showUserUseCase->execute(
                $id
            ));
        } catch (NotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }


        return response()->json(['result' => 'User ', 'data' => $user], 200);
    }

    public function delete(string $id)
    {
        $user = new UserResource($this->destroyUserUseCase->execute(
            $id
        ));

        return response()->json(['result' => 'User deleted'], 200);
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        try{
            $this->updateUserUseCase->execute(
                $id,
                $request->input('name'),
                $request->input('email'),
                $request->input('password')
            );

            return response()->json(['result' => 'User updated'], 200);
        }
        catch(Exception $e)
        {
            return response()->json(['result' => 'Ha ocurrido un error'], 422);
        }
    }
}
