<?php
namespace Src\Infrastructure\Controllers\Court;

use Illuminate\Routing\Controller;
use App\Http\Resources\CourtResource;
use Src\Application\Court\ShowCourtUseCase;
use Src\Application\Court\IndexCourtUseCase;
use Src\Application\Court\StoreCourtUseCase;
use App\Http\Request\Court\IndexCourtRequest;
use App\Http\Request\Court\StoreCourtRequest;
use Src\Application\Court\UpdateCourtUseCase;
use App\Http\Request\Court\UpdateCourtRequest;
use Src\Application\Court\DestroyCourtUseCase;
use Src\Application\Court\AvailablesCourtUseCase;
use Src\Infrastructure\Exceptions\MaxDailyReservationsExceededException;

class CourtController extends Controller
{
    private StoreCourtUseCase $storeCourtUseCase;
    private ShowCourtUseCase $showCourtUseCase;
    private UpdateCourtUseCase $updateCourtUseCase;
    private DestroyCourtUseCase $destroyCourtUseCase;
    private AvailablesCourtUseCase $availablesCourtUseCase;


    // Inyección de dependencias a través del constructor
    public function __construct(
        StoreCourtUseCase $storeCourtUseCase,
        ShowCourtUseCase $showCourtUseCase,
        UpdateCourtUseCase $updateCourtUseCase,
        DestroyCourtUseCase $destroyCourtUseCase,
        AvailablesCourtUseCase $availablesCourtUseCase
        )
    {
        $this->storeCourtUseCase = $storeCourtUseCase;
        $this->showCourtUseCase = $showCourtUseCase;
        $this->updateCourtUseCase = $updateCourtUseCase;
        $this->destroyCourtUseCase = $destroyCourtUseCase;
        $this->availablesCourtUseCase = $availablesCourtUseCase;

    }

   public function store(StoreCourtRequest $request)
   {
        $this->storeCourtUseCase->execute(
            $request->input('name'),
            $request->input('sport_id'),
        );

        return response()->json(['result' => 'Court created']);
   }

   public function show(string $id)
   {
        $court = new CourtResource($this->showCourtUseCase->execute(
            $id
        ));

        return response()->json(['result' => 'Court login', 'data' => $court]);
   }

   public function destroy(string $id)
   {
        $court = new CourtResource($this->destroyCourtUseCase->execute(
            $id
        ));

        return response()->json(['result' => 'Court deleted']);
   }

   public function update(UpdateCourtRequest $request)
   {
        $this->updateCourtUseCase->execute(
            $request->input('id'),
            $request->input('name'),
            $request->input('sport_id'),
        );

        return response()->json(['result' => 'Court updated']);
   }

   public function getAvailableCourts(IndexCourtRequest $request){

    try {
        $availableReservations =  $this->availablesCourtUseCase->execute(

            $request->input('date'),
            $request->input('member_id'),
            $request->input('sport_id'),
        );
        return response()->json(['result' => $availableReservations, 200]);
    } catch (MaxDailyReservationsExceededException $e) {
        return response()->json(['error' => $e->getMessage()], 422);
    }
   }


}
