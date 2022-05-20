<?php

namespace App\Http\Controllers;

use App\Imports\CustomerImport;
use App\Models\User;
use App\Models\Customer;
use App\Repositories\Customer\CustomerRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    //
    protected $customerRepository;

    public function __construct(
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
    }

    /**
     *  * *  @OA\Get(
     *      path="/api/customer/list",
     *      summary="Get list customer",
     *      tags={"Customer"},
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
    public function listCustomer()
    {
        try {
            $data = $this->customerRepository->getAllCustomer();
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
     * * @OA\Post(
     *     path="/api/customer/create",
     *     summary="Create customer",
     *     tags={"Customer"},
     *     security={ {"bearer": {}} },
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 allOf={
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="name",
     *                             type="string",
     *                             example="Thai Long Mart"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="owner",
     *                             type="string",
     *                             example="Nhat Quang"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="phone",
     *                             type="string",
     *                             example="1235264895"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="address",
     *                             type="string",
     *                             example="32 Phan Chau Trinh"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="lat",
     *                             type="double",
     *                             example="16.00550079345703"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="long",
     *                             type="double",
     *                             example="16.00550079345703"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="area_id",
     *                             type="string",
     *                             example="HC001"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             description="",
     *                             property="images",
     *                             type="string", format="binary"
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
     * Register a customer.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req) {
        try {
            $rule = [
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|size:10|unique:customer',
                'name' => 'required',
                'owner' => 'required',
                'address' => 'required',
                'lat' => 'required',
                'long' => 'required',
                'area_id' => 'required',
            ];
            $validator = Validator::make($req->all(), $rule);
            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors()->first(),
                ], 400);
            }
            $entity = $this->customerRepository->getLastCustomerId();
            if ($entity) {
                $id = ++$entity->customer_id;
            } else {
                $id = "CUS0001";
            }
            $data = array(
                'customer_id' => $id,
                'phone' => $req->phone,
                'name' => $req->name,
                'owner' => $req->owner,
                'address' => $req->address,
                'lat' => $req->lat,
                'long' => $req->long,
                'area_id' => $req->area_id
            );
            if ($req->file('images')) {
                $validator = Validator::make($req->all(), [
                    'images' => 'image|mimes:jpeg,png,jpg|max:10000',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        "success" => false,
                        "message" => $validator->errors()->first(),
                    ], 400);
                }
                $i = 1;
                $data['images'] = $i;
            }
            $user = $this->customerRepository->create(
                $data
            );

            if ($req->file('images')) {
                $path = '/static/image/customer/' . $user['customer_id'] . '/' . $i;
                $path_image = $this->customerRepository->upload($path, $req->images);
                $user['images'] = $path_image;
            }

            return response()->json([
                'success' => true,
                'message' => "Add customer succesfully",
            ]);
        } catch (\Exception$e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    } 

    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileImport(Request $request) 
    {
        
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Customer::truncate();
            Excel::import(new CustomerImport, $request->file('file')->store('temp'));
            return response()->json([
                "success" => true,
                "message" => "Succesfully",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
       
    }
}
