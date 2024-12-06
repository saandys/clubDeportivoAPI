<?php
namespace Src\Infrastructure\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\UserResource;
use Src\Application\User\ShowUserUseCase;
use Src\Application\User\IndexUserUseCase;
use Src\Application\User\StoreUserUseCase;
use App\Http\Request\User\StoreUserRequest;
use Src\Application\User\UpdateUserUseCase;
use App\Http\Request\User\UpdateUserRequest;
use Src\Application\User\DestroyUserUseCase;

class UserController extends Controller
{
    private StoreUserUseCase $storeUserUseCase;
    private ShowUserUseCase $showUserUseCase;
    private UpdateUserUseCase $updateUserUseCase;
    private IndexUserUseCase $indexUserUseCase;
    private DestroyUserUseCase $destroyUserUseCase;

    // Inyección de dependencias a través del constructor
    public function __construct(
        StoreUserUseCase $storeUserUseCase,
        ShowUserUseCase $showUserUseCase,
        UpdateUserUseCase $updateUserUseCase,
        IndexUserUseCase $indexUserUseCase,
        DestroyUserUseCase $destroyUserUseCase,
        )
    {
        $this->storeUserUseCase = $storeUserUseCase;
        $this->showUserUseCase = $showUserUseCase;
        $this->updateUserUseCase = $updateUserUseCase;
        $this->indexUserUseCase = $indexUserUseCase;
        $this->destroyUserUseCase = $destroyUserUseCase;

    }

    public function index(){
        dd(4);
    }

   public function register(StoreUserRequest $request)
   {
        $this->storeUserUseCase->execute(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        return response()->json(['result' => 'User created']);
   }

   public function login(string $id)
   {
        $user = new UserResource($this->showUserUseCase->execute(
            $id
        ));

        return response()->json(['result' => 'User login', 'data' => $user]);
   }

   public function delete(string $id)
   {
        $user = new UserResource($this->destroyUserUseCase->execute(
            $id
        ));

        return response()->json(['result' => 'User deleted']);
   }

   public function update(UpdateUserRequest $request)
   {
        $this->updateUserUseCase->execute(
            $request->input('id'),
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        return response()->json(['result' => 'User updated']);
   }


}
