<?php
namespace Src\Infrastructure\V1\Controllers\Member;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\V1\MemberResource;
use Src\Application\V1\Member\ShowMemberUseCase;
use Src\Application\V1\Member\IndexMemberUseCase;
use Src\Application\V1\Member\StoreMemberUseCase;
use App\Http\Request\Member\StoreMemberRequest;
use Src\Application\V1\Member\UpdateMemberUseCase;
use App\Http\Request\Member\UpdateMemberRequest;
use Src\Application\V1\Member\DestroyMemberUseCase;
use Src\Infrastructure\V1\Exceptions\NotFoundException;

class MemberController extends Controller
{
    private StoreMemberUseCase $storeMemberUseCase;
    private ShowMemberUseCase $showMemberUseCase;
    private UpdateMemberUseCase $updateMemberUseCase;
    private DestroyMemberUseCase $destroyMemberUseCase;

    public function __construct(
        StoreMemberUseCase $storeMemberUseCase,
        ShowMemberUseCase $showMemberUseCase,
        UpdateMemberUseCase $updateMemberUseCase,
        DestroyMemberUseCase $destroyMemberUseCase
    ) {
        $this->storeMemberUseCase = $storeMemberUseCase;
        $this->showMemberUseCase = $showMemberUseCase;
        $this->updateMemberUseCase = $updateMemberUseCase;
        $this->destroyMemberUseCase = $destroyMemberUseCase;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/member",
     *     summary="Crear un socio",
     *     tags={"Member"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Sandra Montero"),
     *             @OA\Property(property="email", type="string", example="sandra1@gmail.com"),
     *             @OA\Property(property="phone", type="string", example="1234567890")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Socio creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="Member created")
     *         )
     *     )
     * )
     */
    public function store(StoreMemberRequest $request)
    {
        $this->storeMemberUseCase->execute(
            $request->input('name'),
            $request->input('email'),
            $request->input('phone')
        );

        return response()->json(['result' => 'Member created'], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/member/{id}",
     *     summary="Obtener detalles de un socio",
     *     tags={"Member"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del socio",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del socio",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="Member show"),
     *             @OA\Property(property="data", type="object", example={"name": "John Doe", "email": "sandra1@gmail.com", "phone": "1234567890"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Socio no encontrado"
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            $member = new MemberResource($this->showMemberUseCase->execute($id));
        } catch (NotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json(['result' => 'Member show', 'data' => $member], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/member/{id}",
     *     summary="Eliminar un socio",
     *     tags={"Member"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del socio",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Socio eliminado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="Member deleted")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $this->destroyMemberUseCase->execute($id);

        return response()->json(['result' => 'Member deleted'], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/member/{id}",
     *     summary="Actualizar un socio",
     *     tags={"Member"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del socio",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Jane Montero"),
     *             @OA\Property(property="email", type="string", example="sandra@example.com"),
     *             @OA\Property(property="phone", type="string", example="0987654321")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Socio actualizado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="Member updated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error al actualizar el socio"
     *     )
     * )
     */
    public function update(UpdateMemberRequest $request, string $id)
    {
        try {
            $this->updateMemberUseCase->execute(
                $id,
                $request->input('name'),
                $request->input('email'),
                $request->input('phone')
            );

            return response()->json(['result' => 'Member updated'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error'], 422);
        }
    }
}
