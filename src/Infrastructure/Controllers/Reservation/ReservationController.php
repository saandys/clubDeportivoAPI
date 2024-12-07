<?php
namespace Src\Infrastructure\Controllers\Reservation;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\ReservationResource;
use Src\Infrastructure\Exceptions\HourExceedeedTime;
use Src\Infrastructure\Exceptions\MaxTimeBetweenHours;
use Src\Application\Reservation\ShowReservationUseCase;
use Src\Application\Reservation\IndexReservationUseCase;
use Src\Application\Reservation\StoreReservationUseCase;
use App\Http\Request\Reservation\IndexReservationRequest;
use App\Http\Request\Reservation\StoreReservationRequest;
use Src\Application\Reservation\UpdateReservationUseCase;
use App\Http\Request\Reservation\UpdateReservationRequest;
use Src\Application\Reservation\DestroyReservationUseCase;
use Src\Infrastructure\Exceptions\CourtAlreadyBookedException;
use Src\Infrastructure\Exceptions\MemberAlreadyHasReservationException;
use Src\Infrastructure\Exceptions\MaxDailyReservationsExceededException;

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
        )
    {
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

            return response()->json(['result' => 'Reservation created']);
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
        $reservation = new ReservationResource($this->showReservationUseCase->execute(
            $id
        ));

        return response()->json(['result' => 'Reservation login', 'data' => $reservation]);
   }

   public function destroy(string $id)
   {
        $reservation = new ReservationResource($this->destroyReservationUseCase->execute(
            $id
        ));

        return response()->json(['result' => 'Reservation deleted']);
   }

   public function update(UpdateReservationRequest $request)
   {
        try {
            $this->updateReservationUseCase->execute(
                $request->input('id'),
                $request->input('date'),
                $request->input('start_time'),
                $request->input('end_time'),
                $request->input('member_id'),
                $request->input('court_id'),
            );

            return response()->json(['result' => 'Reservation created']);
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
        'data' => $data]);
   }


}
