<?php
namespace Src\Infrastructure\Controllers\User;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\UserResource;
use Src\Application\User\ShowUserUseCase;
use Src\Application\User\IndexUserUseCase;
use Src\Application\User\LoginUserUseCase;
use Src\Application\User\StoreUserUseCase;
use App\Http\Request\User\LoginUserRequest;
use App\Http\Request\User\StoreUserRequest;
use Src\Application\User\UpdateUserUseCase;
use App\Http\Request\User\UpdateUserRequest;
use Src\Application\User\DestroyUserUseCase;
use Src\Infrastructure\Exceptions\NotFoundException;

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
