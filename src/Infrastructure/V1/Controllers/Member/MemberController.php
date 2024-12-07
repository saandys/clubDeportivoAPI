<?php
namespace Src\Infrastructure\V1\Controllers\Member;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\V1\MemberResource;
use Src\Application\V1\Member\ShowMemberUseCase;
use Src\Application\V1\Member\IndexMemberUseCase;
use Src\Application\V1\Member\StoreMemberUseCase;
use App\Http\Request\Member\StoreMemberRequest;
use Src\Application\V1\Member\UpdateMemberUseCase;
use App\Http\Request\Member\UpdateMemberRequest;
use Src\Application\V1\Member\DestroyMemberUseCase;
use Src\Infrastructure\V1\Exceptions\NotFoundException;

class MemberController extends Controller
{
    private StoreMemberUseCase $storeMemberUseCase;
    private ShowMemberUseCase $showMemberUseCase;
    private UpdateMemberUseCase $updateMemberUseCase;
    private DestroyMemberUseCase $destroyMemberUseCase;

    // Inyección de dependencias a través del constructor
    public function __construct(
        StoreMemberUseCase $storeMemberUseCase,
        ShowMemberUseCase $showMemberUseCase,
        UpdateMemberUseCase $updateMemberUseCase,
        DestroyMemberUseCase $destroyMemberUseCase,
    ) {
        $this->storeMemberUseCase = $storeMemberUseCase;
        $this->showMemberUseCase = $showMemberUseCase;
        $this->updateMemberUseCase = $updateMemberUseCase;
        $this->destroyMemberUseCase = $destroyMemberUseCase;
    }


    public function store(StoreMemberRequest $request)
    {
        $this->storeMemberUseCase->execute(
            $request->input('name'),
            $request->input('email'),
            $request->input('phone')
        );

        return response()->json(['result' => 'Member created']);
    }

    public function show(string $id)
    {
        try{
            $member = new MemberResource($this->showMemberUseCase->execute(
                $id
            ));
        } catch (NotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json(['result' => 'Member show', 'data' => $member], 200);
    }

    public function destroy(string $id)
    {
        $member = new MemberResource($this->destroyMemberUseCase->execute(
            $id
        ));

        return response()->json(['result' => 'Member deleted'], 200);
    }

    public function update(UpdateMemberRequest $request, string $id)
    {
        try{
            $this->updateMemberUseCase->execute(
                $id,
                $request->input('name'),
                $request->input('email'),
                $request->input('phone')
            );

            return response()->json(['result' => 'Member updated'], 200);
        }
        catch(Exception $e)
        {
            return response()->json(['result' => 'Ha ocurrido un error'], 422);
        }
    }
}
