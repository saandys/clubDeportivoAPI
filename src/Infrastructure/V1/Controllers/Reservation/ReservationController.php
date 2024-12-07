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

    // Inyección de dependencias a través del constructor
    public function __construct(
        IndexReservationUseCase $indexReservationUseCase,
        StoreReservationUseCase $storeReservationUseCase,
        ShowReservationUseCase $showReservationUseCase,
        UpdateReservationUseCase $updateReservationUseCase,
        DestroyReservationUseCase $destroyReservationUseCase,
    ) {
        $this->indexReservationUseCase = $indexReservationUseCase;
        $this->storeReservationUseCase = $storeReservationUseCase;
        $this->showReservationUseCase = $showReservationUseCase;
        $this->updateReservationUseCase = $updateReservationUseCase;
        $this->destroyReservationUseCase = $destroyReservationUseCase;
    }

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
        } catch (CourtAlreadyBookedException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (MemberAlreadyHasReservationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (MaxDailyReservationsExceededException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (HourExceedeedTime $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (MaxTimeBetweenHours $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            // Manejar errores genéricos
            return response()->json(['error' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    public function show(string $id)
    {
        try{
            $reservation = new ReservationResource($this->showReservationUseCase->execute(
                $id
            ));
        } catch (NotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }


        return response()->json(['result' => 'Reservation login', 'data' => $reservation], 200);
    }

    public function destroy(string $id)
    {
        $reservation = new ReservationResource($this->destroyReservationUseCase->execute(
            $id
        ));

        return response()->json(['result' => 'Reservation deleted'], 200);
    }

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

            return response()->json(['result' => 'Reservation created'], 200);
        } catch (CourtAlreadyBookedException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (MemberAlreadyHasReservationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (MaxDailyReservationsExceededException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (HourExceedeedTime $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (MaxTimeBetweenHours $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            // Manejar errores genéricos
            return response()->json(['error' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    public function indexDay(IndexReservationRequest $request)
    {
        $data = $this->indexReservationUseCase->execute(
            $request->input('date'),
        );

        return response()->json(['result' => 'Reservation updated',
        'data' => $data], 200);
    }
}
