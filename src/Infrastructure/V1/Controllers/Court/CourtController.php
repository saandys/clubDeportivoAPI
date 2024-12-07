<?php
namespace Src\Infrastructure\V1\Controllers\Court;

use Exception;
use Illuminate\Routing\Controller;
use App\Http\Resources\V1\CourtResource;
use Src\Application\Court\IndexCourtUseCase;
use App\Http\Request\Court\IndexCourtRequest;
use App\Http\Request\Court\StoreCourtRequest;
use App\Http\Request\Court\UpdateCourtRequest;
use Src\Application\V1\Court\ShowCourtUseCase;
use Src\Application\V1\Court\StoreCourtUseCase;
use Src\Application\V1\Court\UpdateCourtUseCase;
use Src\Application\V1\Court\DestroyCourtUseCase;
use Src\Application\V1\Court\AvailablesCourtUseCase;
use Src\Infrastructure\V1\Exceptions\NotFoundException;
use Src\Infrastructure\V1\Exceptions\MaxDailyReservationsExceededException;


class CourtController extends Controller
{
    private StoreCourtUseCase $storeCourtUseCase;
    private ShowCourtUseCase $showCourtUseCase;
    private UpdateCourtUseCase $updateCourtUseCase;
    private DestroyCourtUseCase $destroyCourtUseCase;
    private AvailablesCourtUseCase $availablesCourtUseCase;

    public function __construct(
        StoreCourtUseCase $storeCourtUseCase,
        ShowCourtUseCase $showCourtUseCase,
        UpdateCourtUseCase $updateCourtUseCase,
        DestroyCourtUseCase $destroyCourtUseCase,
        AvailablesCourtUseCase $availablesCourtUseCase
    ) {
        $this->storeCourtUseCase = $storeCourtUseCase;
        $this->showCourtUseCase = $showCourtUseCase;
        $this->updateCourtUseCase = $updateCourtUseCase;
        $this->destroyCourtUseCase = $destroyCourtUseCase;
        $this->availablesCourtUseCase = $availablesCourtUseCase;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/court",
     *     summary="Crear una pista deportiva",
     *     tags={"Court"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Court A"),
     *             @OA\Property(property="sport_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pista creada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="Court created")
     *         )
     *     )
     * )
     */
    public function store(StoreCourtRequest $request)
    {
        $this->storeCourtUseCase->execute(
            $request->input('name'),
            $request->input('sport_id'),
        );

        return response()->json(['result' => 'Court created'], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/court/{id}",
     *     summary="Obtener detalles de una pista",
     *     tags={"Court"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la pista",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la pista",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="Court login"),
     *             @OA\Property(property="data", type="object", example={"name":"Court A","sport":"1"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="No se ha encontrado este id"
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            $court = new CourtResource($this->showCourtUseCase->execute($id));
        } catch (NotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json(['result' => 'Court login', 'data' => $court], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/court/{id}",
     *     summary="Eliminar una pista deportiva",
     *     tags={"Court"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la pista",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pista eliminada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="Court deleted")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $this->destroyCourtUseCase->execute($id);

        return response()->json(['result' => 'Court deleted'], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/court/{id}",
     *     summary="Actualizar una pista deportiva",
     *     tags={"Court"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la pista",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Court B"),
     *             @OA\Property(property="sport_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pista actualizada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="Court updated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error al actualizar la pista"
     *     )
     * )
     */
    public function update(UpdateCourtRequest $request, string $id)
    {
        try {
            $this->updateCourtUseCase->execute(
                $id,
                $request->input('name'),
                $request->input('sport_id'),
            );

            return response()->json(['result' => 'Court updated'], 200);
        } catch (Exception $e) {
            return response()->json(['result' => 'Ha ocurrido un error'], 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/court/free",
     *     summary="Obtener pistas disponibles",
     *     tags={"Court"},
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Fecha para consultar la disponibilidad",
     *         required=true,
     *         @OA\Schema(type="string", format="date", example="2024-12-07")
     *     ),
     *     @OA\Parameter(
     *         name="member_id",
     *         in="query",
     *         description="ID del socio que consulta",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="sport_id",
     *         in="query",
     *         description="ID del deporte",
     *         required=true,
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pistas disponibles",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="result",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Court A"),
     *                     @OA\Property(property="sport_id", type="integer", example=1),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-07T17:26:38.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-07T17:26:38.000000Z"),
     *                     @OA\Property(
     *                         property="availableHours",
     *                         type="array",
     *                         @OA\Items(type="string", example="08:00:00")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error al obtener disponibilidad",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid parameters or no available courts")
     *         )
     *     )
     * )
     */

    public function getAvailableCourts(IndexCourtRequest $request)
    {
        try {
            $availableReservations = $this->availablesCourtUseCase->execute(
                $request->input('date'),
                $request->input('member_id'),
                $request->input('sport_id'),
            );
            return response()->json(['result' => $availableReservations], 200);
        } catch (MaxDailyReservationsExceededException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
