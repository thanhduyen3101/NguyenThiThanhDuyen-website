<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkin;
use App\Repositories\Checkin\CheckinRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
class CheckinController extends Controller
{
    //
    protected $checkinRepository;
    protected $userRepository;

    public function __construct(
        CheckinRepositoryInterface $checkinRepository
    ) {
        $this->checkinRepository = $checkinRepository;
    }

    /**
     *  * *  @OA\Get(
     *      path="/api/admin/checkin/list",
     *      summary="Get list all checkin",
     *      tags={"Checkin"},
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
    public function listAllCheckin()
    {
        try {
            $data = $this->checkinRepository->getAllCheckin();
            if ($data) {
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
     *      path="/api/user/checkin",
     *      summary="Show checkin of salesman",
     *      tags={"Checkin"},
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
    public function showCheckinBySalesman()
    {
        try {
            $user = auth()->user();
            if($user) {
                $data = $this->checkinRepository->getCheckinBySalesman($user->user_id);
                if ($data) {
                    for($i=0; $i<count($data); $i++){
                        if(!empty($data[$i]->image)){
                            $path = '/static/image/checkin/'.$data[$i]->checkin_id.'/'.$data[$i]->image;
                            $data[$i]->image = $this->checkinRepository->getImg($path) ;  
                        }else{
                            $path = '/static/image/checkin/no-avatar/no-avatar.png';
                            $image = config('filesystems.disks')['public']['url'].$path;
                            $data[$i]->image = $image;   
                        }
                        $data[$i]->salesman = $user->name;
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

    /**
     * * @OA\Post(
     *     path="/api/user/checkin/create",
     *     summary="Add checkin",
     *     tags={"Checkin"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 allOf={
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="lat",
     *                             type="float",
     *                             example="16.067859"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="long",
     *                             type="float",
     *                             example="108.220026"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             description="",
     *                             property="image",
     *                             type="string", 
     *                             format="binary"
     *                         )
     *                     ),
     *                  }
     *              ),
     *        ),
     *     ),
     *     @OA\Response(
     *        response="200",
     *        description="Successful response",
     *     ),
     * )
     * Create Checkin.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        try {
            $user = auth()->user();
            if ($user) {
                $rule = [
                    'lat' => 'required',
                    'long' => 'required',
                    'image' => 'required|image|mimes:jpg,jpef,png|max:10000',
                ];
                $validator = Validator::make($req->all(), $rule);
                if ($validator->fails()) {
                    return response()->json([
                        "success" => false,
                        "message" => $validator->errors()->first(),
                    ], 400);
                }
                $entity = $this->checkinRepository->getLastCheckinId();
                if ($entity) {
                    $id = ++$entity->checkin_id;
                } else {
                    $id = "CK000000001";
                }
                $i = 1;
                $data = array(
                    'checkin_id' => $id,
                    'salesman_id' => $user->user_id,
                    'lat' => $req->lat,
                    'long' => $req->long,
                    'image' => $i,
                );
                $this->checkinRepository->create(
                    $data
                );
                if ($req->file('image')) {
                    $path = '/static/image/checkin/' . $data['checkin_id'] . '/' . $i;
                    $path_image = $this->checkinRepository->upload($path, $req->image);
                    $data['image'] = $path_image;
                }
                return response()->json([
                    'success' => true,
                    'message' => "Add checkin succesfully",
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
