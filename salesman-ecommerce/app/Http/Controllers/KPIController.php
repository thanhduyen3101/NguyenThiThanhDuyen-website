<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KPI;
use App\Repositories\KPI\KPIRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class KPIController extends BaseController
{
    protected $kpiRepository;
    protected $userRepository;

    public function __construct(
        KPIRepositoryInterface $kpiRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->kpiRepository = $kpiRepository;
        $this->userRepository = $userRepository;
    }

    /**
     *  * *  @OA\Get(
     *      path="/api/admin/kpi/list",
     *      summary="Get list all kpi",
     *      tags={"KPI"},
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
    public function listAllKPI()
    {
        try {
            $data = $this->kpiRepository->getAllKPI();
            if (count($data)>0) {
                return response()->json([
                    'success' => true,
                    'data' => $data,
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

    /**
     *  * *  @OA\Get(
     *      path="/api/user/kpi",
     *      summary="Show kpi of salesman",
     *      tags={"KPI"},
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
    public function showKPIBySalesman()
    {
        try {
            $user = auth()->user();
            $data = $this->kpiRepository->getKPIBySalesman($user['user_id']);
            if ($data) {
                if(count($data)>0) {
                    $data['salesman'] = $user['name'];
                }
                return response()->json([
                    'success' => true,
                    'data' => $data,
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

    /**
     * * @OA\Post(
     *     path="/api/admin/kpi/save",
     *     summary="Add kpi",
     *     tags={"KPI"},
     *     @OA\RequestBody(
     *        required = true,
     *        @OA\JsonContent(
     *             type="object",
     *                         @OA\Property(
     *                             property="salesman_id",
     *                             type="string",
     *                             example="USER00000003"
     *                         ),
     *                         @OA\Property(
     *                             property="order_amount",
     *                             type="integer",
     *                             example="10"
     *                         ),
     *                         @OA\Property(
     *                             property="checkin",
     *                             type="integer",
     *                             example="10"
     *                         ),
     *        ),
     *     ),
     *     @OA\Response(
     *        response="200",
     *        description="Successful response",
     *     ),
     * )
     * Save KPI.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        try {
            $rule = [
                'student_id' => 'required|string',
                'test_2' => 'numeric','test_1' => 'numeric',
            ];
            $validator = Validator::make($req->all(), $rule);
            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors()->first(),
                ], 400);
            }
            $data = $this->kpiRepository->getKPI($req->student_id);
            if($data) {
                $total = ($req->test_1 + $req->test_2)/2;
                $kpi = array(
                    'test_2' => $req->test_2,'test_1' => $req->test_1,
                    'total' => $total
                );
                $this->kpiRepository->update($data->id, $kpi);
                return response()->json([
                    'success' => true,
                    "message" => "Update score succesfully",
                ]);
            } else {
                $entity = $this->kpiRepository->getLastKPIId();
                if ($entity) {
                    $id = ++$entity->kpi_id;
                } else {
                    $id = "KPI000000001";
                }
                $this->kpiRepository->create(
                    array_merge(
                        $validator->validated(),
                        [
                            'kpi_id' => $id,
                        ]
                    )
                );
                return response()->json([
                    'success' => true,
                    'message' => "Add score succesfully",
                ]);
            }   
        } catch (\Exception$e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    }

    /**
     *  *   @OA\Post(
     *      path="/api/admin/kpi/delete/{kpi_id}",
     *      summary="Delete KPI",
     *      tags={"KPI"},
     *      security={ {"bearer": {}} },
     *      @OA\Parameter(
     *          name="kpi_id",
     *          description="kpi_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
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
     * Delete kpi
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteKPI($id)
    {
        try {
            $kpi = KPI::find($id);
            if ($kpi) {
                $this->kpiRepository->delete($id);
                return response()->json([
                    'success' => true,
                    "message" => "Delete kpi complete",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "KPI not found",
                ], 404);
            }
        } catch (\Exception$e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function listKPI() {
        try {
            $user = auth()->user();
            if($user) {
                if ($user->type_id == "TEACHER") {
                    $data = $this->userRepository->getAllUserByTeacher($user->user_id);
                } elseif ($user->type_id == "ADM") {
                    $data = $this->userRepository->getUserByType('STUDENT');
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => "You have not permission",
                    ]);
                }
                if ($data) {
                    for($i = 0; $i<count($data); $i++) {
                        $kpi = $this->kpiRepository->getKPI($data[$i]->user_id);
                        if ($kpi) {
                            $data[$i]->test_2 = $kpi->test_2;
                            $data[$i]->test_1 = $kpi->test_1;
                            $data[$i]->total = $kpi->total;
                        } else {
                            $data[$i]->test_2 = 0;$data[$i]->test_1 = 0;
                            $data[$i]->total = 0;
                        }
                    }
                }
                return response()->json([
                    "success" => true,
                    "data" => $data,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "You must be login",
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
