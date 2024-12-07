<?php
namespace Src\Infrastructure\Controllers\Reservation;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\ReservationResource;
use Src\Application\Reservation\ShowReservationUseCase;
use Src\Application\Reservation\IndexReservationUseCase;
use Src\Application\Reservation\StoreReservationUseCase;
use App\Http\Request\Reservation\StoreReservationRequest;
use Src\Application\Reservation\UpdateReservationUseCase;
use App\Http\Request\Reservation\UpdateReservationRequest;
use Src\Application\Reservation\DestroyReservationUseCase;

class ReservationController extends Controller
{
    private StoreReservationUseCase $storeReservationUseCase;
    private ShowReservationUseCase $showReservationUseCase;
    private UpdateReservationUseCase $updateReservationUseCase;
    private DestroyReservationUseCase $destroyReservationUseCase;

    // Inyección de dependencias a través del constructor
    public function __construct(
        StoreReservationUseCase $storeReservationUseCase,
        ShowReservationUseCase $showReservationUseCase,
        UpdateReservationUseCase $updateReservationUseCase,
        DestroyReservationUseCase $destroyReservationUseCase,
        )
    {
        $this->storeReservationUseCase = $storeReservationUseCase;
        $this->showReservationUseCase = $showReservationUseCase;
        $this->updateReservationUseCase = $updateReservationUseCase;
        $this->destroyReservationUseCase = $destroyReservationUseCase;

    }

   public function store(StoreReservationRequest $request)
   {
        $this->storeReservationUseCase->execute(
            $request->input('date'),
            $request->input('start_time'),
            $request->input('end_time'),
            $request->input('member_id'),
            $request->input('court_id'),
        );

        return response()->json(['result' => 'Reservation created']);
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
        $this->updateReservationUseCase->execute(
            $request->input('id'),
            $request->input('date'),
            $request->input('start_time'),
            $request->input('end_time'),
            $request->input('member_id'),
            $request->input('court_id'),
        );

        return response()->json(['result' => 'Reservation updated']);
   }


}
