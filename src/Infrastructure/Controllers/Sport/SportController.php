<?php
namespace Src\Infrastructure\Controllers\Sport;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\SportResource;
use Src\Application\Sport\ShowSportUseCase;
use Src\Application\Sport\IndexSportUseCase;
use Src\Application\Sport\StoreSportUseCase;
use App\Http\Request\Sport\StoreSportRequest;
use Src\Application\Sport\UpdateSportUseCase;
use App\Http\Request\Sport\UpdateSportRequest;
use Src\Application\Sport\DestroySportUseCase;

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
        )
    {
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
        $sport = new SportResource($this->showSportUseCase->execute(
            $id
        ));

        return response()->json(['result' => 'Sport login', 'data' => $sport]);
   }

   public function destroy(string $id)
   {
        $sport = new SportResource($this->destroySportUseCase->execute(
            $id
        ));

        return response()->json(['result' => 'Sport deleted']);
   }

   public function update(UpdateSportRequest $request)
   {
        $this->updateSportUseCase->execute(
            $request->input('id'),
            $request->input('name'),
        );

        return response()->json(['result' => 'Sport updated']);
   }


}
