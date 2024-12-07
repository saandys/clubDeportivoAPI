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

    // Inyección de dependencias a través del constructor
    public function __construct(
        StoreSportUseCase $storeSportUseCase,
        ShowSportUseCase $showSportUseCase,
        UpdateSportUseCase $updateSportUseCase,
        DestroySportUseCase $destroySportUseCase,
    ) {
        $this->storeSportUseCase = $storeSportUseCase;
        $this->showSportUseCase = $showSportUseCase;
        $this->updateSportUseCase = $updateSportUseCase;
        $this->destroySportUseCase = $destroySportUseCase;
    }

    public function store(StoreSportRequest $request)
    {
        $this->storeSportUseCase->execute(
            $request->input('name'),
        );

        return response()->json(['result' => 'Sport created']);
    }

    public function show(string $id)
    {
        try{
            $sport = new SportResource($this->showSportUseCase->execute(
                $id
            ));
        } catch (NotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }


        return response()->json(['result' => 'Sport login', 'data' => $sport], 200);
    }

    public function destroy(string $id)
    {
        $sport = new SportResource($this->destroySportUseCase->execute(
            $id
        ));

        return response()->json(['result' => 'Sport deleted'], 200);
    }

    public function update(UpdateSportRequest $request, string $id)
    {
        try{
            $this->updateSportUseCase->execute(
                $id,
                $request->input('name'),
            );

            return response()->json(['result' => 'Sport updated'], 200);
        }
        catch(Exception $e)
        {
            return response()->json(['result' => 'Ha ocurrido un error'], 422);
        }
    }
}
