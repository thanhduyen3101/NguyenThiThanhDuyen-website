<?php

namespace App\Http\Controllers;

use App\Repositories\Area\AreaRepositoryInterface;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    //
    protected $areaRepository;

    public function __construct(
        AreaRepositoryInterface $areaRepository
    ) {
        $this->areaRepository = $areaRepository;
    }

    /**
     *  * *  @OA\Get(
     *      path="/api/admin/area/list",
     *      summary="Get list all area",
     *      tags={"Area"},
     *      security={ {"bearer": {}} },
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listArea()
    {
        try {
            $area = $this->areaRepository->getAllArea();
            if ($area) {
                return response()->json([
                    'success' => true,
                    'data' => $area,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "No data found",
                ]);
            }
        } catch (\Exception$e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    }
}
