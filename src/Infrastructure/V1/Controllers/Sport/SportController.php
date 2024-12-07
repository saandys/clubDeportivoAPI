<?php
namespace Src\Infrastructure\V1\Controllers\Sport;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\V1\SportResource;
use Src\Application\V1\Sport\ShowSportUseCase;
use Src\Application\V1\Sport\IndexSportUseCase;
use Src\Application\V1\Sport\StoreSportUseCase;
use App\Http\Request\Sport\StoreSportRequest;
use Src\Application\V1\Sport\UpdateSportUseCase;
use App\Http\Request\Sport\UpdateSportRequest;
use Src\Application\V1\Sport\DestroySportUseCase;
use Src\Infrastructure\V1\Exceptions\NotFoundException;


class SportController extends Controller
{
    private StoreSportUseCase $storeSportUseCase;
    private ShowSportUseCase $showSportUseCase;
    private UpdateSportUseCase $updateSportUseCase;
    private DestroySportUseCase $destroySportUseCase;

    public function __construct(
        StoreSportUseCase $storeSportUseCase,
        ShowSportUseCase $showSportUseCase,
        UpdateSportUseCase $updateSportUseCase,
        DestroySportUseCase $destroySportUseCase
    ) {
        $this->storeSportUseCase = $storeSportUseCase;
        $this->showSportUseCase = $showSportUseCase;
        $this->updateSportUseCase = $updateSportUseCase;
        $this->destroySportUseCase = $destroySportUseCase;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/sport",
     *     summary="Crear un deporte",
     *     tags={"Sport"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Fútbol")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Deporte creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="Sport created")
     *         )
     *     )
     * )
     */
    public function store(StoreSportRequest $request)
    {
        $this->storeSportUseCase->execute(
            $request->input('name'),
        );

        return response()->json(['result' => 'Sport created']);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/sport/{id}",
     *     summary="Obtener detalles de un deporte",
     *     tags={"Sport"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del deporte",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del deporte",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="Sport details"),
     *             @OA\Property(property="data", type="object", example={"name": "Fútbol"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Deporte no encontrado"
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            $sport = new SportResource($this->showSportUseCase->execute($id));
        } catch (NotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json(['result' => 'Sport details', 'data' => $sport], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/sport/{id}",
     *     summary="Eliminar un deporte",
     *     tags={"Sport"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del deporte",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Deporte eliminado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="Sport deleted")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $this->destroySportUseCase->execute($id);

        return response()->json(['result' => 'Sport deleted'], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/sport/{id}",
     *     summary="Actualizar un deporte",
     *     tags={"Sport"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del deporte",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Baloncesto")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Deporte actualizado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="Sport updated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error al actualizar el deporte"
     *     )
     * )
     */
    public function update(UpdateSportRequest $request, string $id)
    {
        try {
            $this->updateSportUseCase->execute(
                $id,
                $request->input('name'),
            );

            return response()->json(['result' => 'Sport updated'], 200);
        } catch (Exception $e) {
            return response()->json(['result' => 'Ha ocurrido un error'], 422);
        }
    }
}
