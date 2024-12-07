<?php
namespace Src\Infrastructure\V1\Controllers\Reservation;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\V1\ReservationResource;
use Src\Infrastructure\V1\Exceptions\HourExceedeedTime;
use Src\Infrastructure\V1\Exceptions\NotFoundException;
use Src\Infrastructure\V1\Exceptions\MaxTimeBetweenHours;
use Src\Application\V1\Reservation\ShowReservationUseCase;
use Src\Application\V1\Reservation\IndexReservationUseCase;
use Src\Application\V1\Reservation\StoreReservationUseCase;
use App\Http\Request\Reservation\IndexReservationRequest;
use App\Http\Request\Reservation\StoreReservationRequest;
use Src\Application\V1\Reservation\UpdateReservationUseCase;
use App\Http\Request\Reservation\UpdateReservationRequest;
use Src\Application\V1\Reservation\DestroyReservationUseCase;
use Src\Infrastructure\V1\Exceptions\CourtAlreadyBookedException;
use Src\Infrastructure\V1\Exceptions\MemberAlreadyHasReservationException;
use Src\Infrastructure\V1\Exceptions\MaxDailyReservationsExceededException;


class ReservationController extends Controller
{
    private IndexReservationUseCase $indexReservationUseCase;
    private StoreReservationUseCase $storeReservationUseCase;
    private ShowReservationUseCase $showReservationUseCase;
    private UpdateReservationUseCase $updateReservationUseCase;
    private DestroyReservationUseCase $destroyReservationUseCase;

    public function __construct(
        IndexReservationUseCase $indexReservationUseCase,
        StoreReservationUseCase $storeReservationUseCase,
        ShowReservationUseCase $showReservationUseCase,
        UpdateReservationUseCase $updateReservationUseCase,
        DestroyReservationUseCase $destroyReservationUseCase
    ) {
        $this->indexReservationUseCase = $indexReservationUseCase;
        $this->storeReservationUseCase = $storeReservationUseCase;
        $this->showReservationUseCase = $showReservationUseCase;
        $this->updateReservationUseCase = $updateReservationUseCase;
        $this->destroyReservationUseCase = $destroyReservationUseCase;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/reservation",
     *     summary="Crear una nueva reserva",
     *     tags={"Reservation"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="date", type="string", format="date", example="2024-12-07"),
     *             @OA\Property(property="start_time", type="string", format="time", example="08:00"),
     *             @OA\Property(property="end_time", type="string", format="time", example="09:00"),
     *             @OA\Property(property="member_id", type="integer", example=1),
     *             @OA\Property(property="court_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reserva creada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="Reservation created")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error en la validación o lógica de negocio",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Ha ocurrido un error")
     *         )
     *     )
     * )
     */
    public function store(StoreReservationRequest $request)
    {
        try {
            $this->storeReservationUseCase->execute(
                $request->input('date'),
                $request->input('start_time'),
                $request->input('end_time'),
                $request->input('member_id'),
                $request->input('court_id'),
            );

            return response()->json(['result' => 'Reservation created'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/reservation/{id}",
     *     summary="Obtener detalles de una reserva",
     *     tags={"Reservation"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la reserva",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la reserva",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="Reservation details"),
     *             @OA\Property(property="data", type="object", example={"court":"1","member":"1","date":"2024-12-07 00:00:00","start_time":"2024-12-07 08:00:00","end_time":"2024-12-07 09:00:00"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Reserva no encontrada"
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            $reservation = new ReservationResource($this->showReservationUseCase->execute($id));
        } catch (NotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json(['result' => 'Reservation details', 'data' => $reservation], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/reservation/{id}",
     *     summary="Eliminar una reserva",
     *     tags={"Reservation"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la reserva",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reserva eliminada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="Reservation deleted")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $this->destroyReservationUseCase->execute($id);

        return response()->json(['result' => 'Reservation deleted'], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/reservation/{id}",
     *     summary="Actualizar una reserva",
     *     tags={"Reservation"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la reserva",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="date", type="string", format="date", example="2024-12-07"),
     *             @OA\Property(property="start_time", type="string", format="time", example="08:00"),
     *             @OA\Property(property="end_time", type="string", format="time", example="09:00"),
     *             @OA\Property(property="member_id", type="integer", example=1),
     *             @OA\Property(property="court_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reserva actualizada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="Reservation updated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error en la validación"
     *     )
     * )
     */
    public function update(UpdateReservationRequest $request, string $id)
    {
        try {
            $this->updateReservationUseCase->execute(
                $id,
                $request->input('date'),
                $request->input('start_time'),
                $request->input('end_time'),
                $request->input('member_id'),
                $request->input('court_id'),
            );

            return response()->json(['result' => 'Reservation updated'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/reservation/day",
     *     summary="Obtener reservas de un día específico",
     *     tags={"Reservation"},
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Fecha de las reservas",
     *         required=true,
     *         @OA\Schema(type="string", format="date", example="2024-12-22")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de reservas del día",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="Reservations for the day"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="member", type="object",
     *                         @OA\Property(property="id", type="integer", example=5),
     *                         @OA\Property(property="name", type="string", example="John Doe")
     *                     ),
     *                     @OA\Property(property="court", type="object",
     *                         @OA\Property(property="id", type="integer", example=2),
     *                         @OA\Property(property="name", type="string", example="Court A")
     *                     ),
     *                     @OA\Property(property="sport", type="object",
     *                         @OA\Property(property="id", type="integer", example=3),
     *                         @OA\Property(property="name", type="string", example="Tennis")
     *                     ),
     *                     @OA\Property(property="date", type="string", format="date", example="2024-12-22"),
     *                     @OA\Property(property="start_time", type="string", format="time", example="08:00:00"),
     *                     @OA\Property(property="end_time", type="string", format="time", example="09:00:00")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Fecha inválida o sin reservas",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No reservations found for the given date")
     *         )
     *     )
     * )
     */

    public function indexDay(IndexReservationRequest $request)
    {
        $data = $this->indexReservationUseCase->execute(
            $request->input('date'),
        );

        return response()->json(['result' => 'Reservations for the day', 'data' => $data], 200);
    }
}
