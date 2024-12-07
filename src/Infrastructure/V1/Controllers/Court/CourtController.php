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


    // Inyección de dependencias a través del constructor
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

    public function store(StoreCourtRequest $request)
    {
        $this->storeCourtUseCase->execute(
            $request->input('name'),
            $request->input('sport_id'),
        );

        return response()->json(['result' => 'Court created'], 200);
    }

    public function show(string $id)
    {
        try{
            $court = new CourtResource($this->showCourtUseCase->execute(
                $id
            ));
        } catch (NotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json(['result' => 'Court login', 'data' => $court], 200);
    }

    public function destroy(string $id)
    {
        $court = new CourtResource($this->destroyCourtUseCase->execute(
            $id
        ));

        return response()->json(['result' => 'Court deleted'], 200);
    }

    public function update(UpdateCourtRequest $request, string $id)
    {
        try{
            $this->updateCourtUseCase->execute(
                $id,
                $request->input('name'),
                $request->input('sport_id'),
            );

            return response()->json(['result' => 'Court updated'], 200);
        }
        catch(Exception $e)
        {
            return response()->json(['result' => 'Ha ocurrido un error'], 422);
        }
    }

    public function getAvailableCourts(IndexCourtRequest $request)
    {

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
