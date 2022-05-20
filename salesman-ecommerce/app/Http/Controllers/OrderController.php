<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Order_Detail;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Order_Detail\OrderDetailRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\Validator;


class OrderController extends BaseController
{
    protected $orderRepository;
    protected $orderDetailRepository;
    protected $userRepository;
    protected $customerRepository;
    protected $productRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderDetailRepositoryInterface $orderDetailRepository,
        UserRepositoryInterface $userRepository,
        CustomerRepositoryInterface $customerRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderDetailRepository = $orderDetailRepository;
        $this->userRepository = $userRepository;
        $this->customerRepository = $customerRepository;
        $this->productRepository = $productRepository;
    }

    /**
     *  * *  @OA\Get(
     *      path="/api/admin/order/list",
     *      summary="Get list all order",
     *      tags={"Order"},
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
    public function listAllOrder()
    {
        try {
            $user = auth()->user();
            if ($user) {
                if ($user->type_id == "TEACHER") {
                    $data = $this->orderRepository->getAllOrderByTeacher($user->user_id);    
                } elseif ($user->type_id == "ADM") {
                    $data = $this->orderRepository->getAllOrder();
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => "You have not permission",
                    ]);
                }
                return response()->json([
                    'success' => true,
                    'data' => $data,
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

    /**
     *  * *  @OA\Get(
     *      path="/api/admin/order/order_detail/list",
     *      summary="Get list all order detail",
     *      tags={"Order"},
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
    public function listAllOrderDetail()
    {
        try {
            $data = $this->orderDetailRepository->getAllOrderDetail();
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
     *      path="/api/user/order/order_detail/list",
     *      summary="Get list order detail by salesman",
     *      tags={"Order"},
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
    public function listOrderDetailBySalesman()
    {
        try {
            $user = auth()->user();
            if($user) {
                $data = $this->orderDetailRepository->getOrderDetailBySalesman($user->user_id);
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
     *  * *  @OA\Get(
     *      path="/api/order/list/student",
     *      summary="Get list order of salesman",
     *      tags={"Order"},
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
    public function listOrderByStudent()
    {
        try {
            $user = auth()->user();
            if($user) {
                $order = $this->orderRepository->getOrderByStudent($user->user_id);
                if ($order) {
                    return response()->json([
                        'success' => true,
                        'data' => $order,
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
     *  * *  @OA\Get(
     *      path="/api/order/information/{order_id}",
     *      summary="Get info order by id",
     *      tags={"Order"},
     *      security={ {"bearer": {}} },
     *      @OA\Parameter(
     *          name="order_id",
     *          description="order_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
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
     * Display information order.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = $this->orderRepository->getOrderById($id);
            if ($data) {
                if ($data->salesman_id) {
                    $salesman = $this->userRepository->getUserById($data->salesman_id);
                    $data->salesman_name = $salesman->name;
                } else {
                    $data->salesman_name = null;
                }
                
                if ($data->customer_id) {
                    $customer = $this->customerRepository->getCustomerById($data->customer_id);
                    $data->customer_name = $customer->name;
                    $data->address_customer = $customer->address;
                    $data->phone_customer = $customer->phone;
                } else {
                    $data->customer_name = null;
                    $data->address_customer = null;
                    $data->phone_customer = null;
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
     *  *  *@OA\Get(
     *      path="/api/order/order_detail/{order_id}",
     *      summary="View order_detail by order_id",
     *      tags={"Order"},
     *      security={ {"bearer": {}} },
     *        @OA\Parameter(
     *          name="order_id",
     *          description="order_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
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
     * Display the order detail.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function showOrderDetail($order_id)
    {
        try {
            $data = $this->orderDetailRepository->getOrderDetailByOrderId($order_id);
            if(count($data)>0) {
                return response()->json([
                    'success' => true,
                    'data' => $data,
                ]);
            }
            return response()->json([
                "success" => false,
                "message" => "Order empty",
            ], 400);
        } catch (\Exception$e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    }

    /**
     *  *  @OA\Post(
     *     path="/api/order/update/status/{order_id}",
     *     summary="Update status in order (STT1: Cart, STT2: Waiting, STT3: Canceled, STT4: Confirmed)",
     *     tags={"Order"},
     *     security={ {"bearer": {}} },
     *      @OA\Parameter(
     *          name="order_id",
     *          description="order_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *        required = true,
     *        @OA\JsonContent(
     *             type="object",
     *                         @OA\Property(
     *                             property="status",
     *                             type="string",
     *                             example="STT1"
     *                         ),
     *        ),
     *     ),
     *     @OA\Response(
     *        response="200",
     *        description="Successful response",
     *     ),
     * )
     * Update status in order.
     * 
     * @param  \Illuminate\Http\Request $req
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatusOrder(Request $req, $order_id)
    {
        try {
            $order = Order::find($order_id);
            if ($order) {
                $data = array(
                    'status' => $req->status,
                );
                $this->orderRepository->update($order->id, $data);
                return response()->json([
                    'success' => true,
                    "message" => "Succesfully",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "Order not found",
                ], 404);
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
     *      path="/api/user/order/order_detail/delete/{order_detail_id}",
     *      summary="Delete order detail",
     *      tags={"Order"},
     *      security={ {"bearer": {}} },
     *      @OA\Parameter(
     *          name="order_detail_id",
     *          description="order_detail_id",
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
     * Delete product in order
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteOrderDetail($id)
    {
        try {
            $order_detail = Order_Detail::find($id);
            if ($order_detail) {
                $this->orderDetailRepository->delete($id);
                return response()->json([
                    'success' => true,
                    "message" => "Delete product complete",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "Product not found",
                ], 404);
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
     *      path="/api/user/order/delete/{order_id}",
     *      summary="Delete order",
     *      tags={"Order"},
     *      security={ {"bearer": {}} },
     *      @OA\Parameter(
     *          name="order_id",
     *          description="order_id",
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
     * Delete order
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteOrder($id)
    {
        try {
            $order = Order::find($id);
            if ($order) {
                $item = $this->orderDetailRepository->getOrderDetailByOrderId($order->order_id);
                if (count($item)>0) {
                    for($i = 0; $i < count($item); $i++) {
                        $this->orderDetailRepository->delete($item[$i]->id);
                    }
                }
                $this->orderRepository->delete($id);
                return response()->json([
                    'success' => true,
                    "message" => "Delete order complete",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "Product not found",
                ], 404);
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
     *     path="/api/user/order/order_detail/update/{order_detail_id}",
     *     summary="Update product in order",
     *     tags={"Order"},
     *     security={ {"bearer": {}} },
     *      @OA\Parameter(
     *          name="order_detail_id",
     *          description="order_detail_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *        required = true,
     *        @OA\JsonContent(
     *             type="object",
     *                         @OA\Property(
     *                             property="order_id",
     *                             type="string",
     *                             example="ORDER0000002"
     *                         ),
     *                         @OA\Property(
     *                             property="quantity",
     *                             type="integer",
     *                             example="6"
     *                         ),
     *        ),
     *     ),
     *     @OA\Response(
     *        response="200",
     *        description="Successful response",
     *     ),
     * )
     * Update product in order.
     * @param  \Illuminate\Http\Request $req
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateOrderDetail(Request $req, $id)
    {
        try {
            if ($req->quantity) {
                $rule = [
                    'quantity' => 'numeric',
                ];
                $validator = Validator::make($req->all(), $rule);
                if ($validator->fails()) {
                    return response()->json([
                        "success" => false,
                        "message" => $validator->errors()->first(),
                    ], 400);
                }
                $data['quantity'] = $req->quantity;
            }

            if ($req->order_id) {
                $rule = [
                    'order_id' => 'string',
                ];
                $validator = Validator::make($req->all(), $rule);
                if ($validator->fails()) {
                    return response()->json([
                        "success" => false,
                        "message" => $validator->errors()->first(),
                    ], 400);
                }
                $data['order_id'] = $req->order_id;
            }
            
            $item = Order_Detail::find($id);
            if ($item) {
                $this->orderDetailRepository->update($item->id, $data);
                return response()->json([
                    'success' => true,
                    'message' => 'Update succesfully',
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    'message' => 'Product does not exist',
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
     *     path="/api/user/order/update/{order_id}",
     *     summary="Update order",
     *     tags={"Order"},
     *     security={ {"bearer": {}} },
     *      @OA\Parameter(
     *          name="order_id",
     *          description="order_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *        required = true,
     *        @OA\JsonContent(
     *             type="object",
     *                         @OA\Property(
     *                             property="customer_id",
     *                             type="string",
     *                             example="CUS0002"
     *                         ),
     *        ),
     *     ),
     *     @OA\Response(
     *        response="200",
     *        description="Successful response",
     *     ),
     * )
     * Update order.
     * @param  \Illuminate\Http\Request $req
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateOrder(Request $req, $id)
    {
        try {
            if ($req->customer_id) {
                $rule = [
                    'customer_id' => 'string',
                ];
                $validator = Validator::make($req->all(), $rule);
                if ($validator->fails()) {
                    return response()->json([
                        "success" => false,
                        "message" => $validator->errors()->first(),
                    ], 400);
                }
                $data = array_merge([
                    'customer_id' => $req->customer_id
                ]
                );
            }
            
            $item = Order::find($id);
            if ($item) {
                $this->orderRepository->update($item->id, $data);
                return response()->json([
                    'success' => true,
                    'message' => 'Update succesfully',
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    'message' => 'Order does not exist',
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
     *     path="/api/user/order/order_detail/create",
     *     summary="Create order detail",
     *     tags={"Order"},
     *     @OA\RequestBody(
     *        required = true,
     *        @OA\JsonContent(
     *             type="object",
     *                         @OA\Property(
     *                             property="product_id",
     *                             type="string",
     *                             example="ITEM000000003"
     *                         ),
     *                         @OA\Property(
     *                             property="order_id",
     *                             type="string",
     *                             example="ORDER0000001"
     *                         ),
     *                         @OA\Property(
     *                             property="quantity",
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
     * Create order detail.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function storeOrderDetail(Request $req)
    {
        try {
            $rule = [
                'order_id' => 'string',
                'product_id' => 'required',
                'quantity' => 'required|numeric',
            ];
            $validator = Validator::make($req->all(), $rule);
            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors()->first(),
                ], 400);
            }
            $entity = $this->orderDetailRepository->getLastOrderDetailId();
            if ($entity) {
                $id = ++$entity->order_detail_id;
            } else {
                $id = "DT000000001";
            }
            $this->orderDetailRepository->create(
                array_merge(
                    $validator->validated(),
                    [
                        'order_detail_id' => $id,
                    ]
                )
            );

            return response()->json([
                'success' => true,
                'message' => "Add order detail succesfully",
            ]);
        } catch (\Exception$e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    }

    /**
     * * @OA\Post(
     *     path="/api/user/order/create",
     *     summary="Create order",
     *     tags={"Order"},
     *     security={ {"bearer": {}} },
     *     @OA\RequestBody(
     *        required = true,
     *        @OA\JsonContent(
     *             type="object",
     *                         @OA\Property(
     *                             property="course_id",
     *                             type="string",
     *                             example="COURSE0001"
     *                         ),
     *        ),
     *     ),
     *     @OA\Response(
     *        response="200",
     *        description="Successful response",
     *     ),
     * )
     * Create order.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function storeOrder(Request $req)
    {
        try {
            $user = auth()->user();
            if($user) {
                $rule = [
                    'course_id' => 'string',
                ];
                $validator = Validator::make($req->all(), $rule);
                if ($validator->fails()) {
                    return response()->json([
                        "success" => false,
                        "message" => $validator->errors()->first(),
                    ], 400);
                }
                $check = $this->orderRepository->findOrderByStudentIdAndCourseId($user->user_id, $req->course_id);
                if ($check) {
                    return response()->json([
                        'success' => false,
                        'message' => "This course registed",
                    ]);
                }
                $entity = $this->orderRepository->getLastOrderId();
                if ($entity) {
                    $id = ++$entity->order_id;
                } else {
                    $id = "ORDER0000001";
                }
                $this->orderRepository->create(
                    array_merge(
                        $validator->validated(),
                        [
                            'order_id' => $id,
                            'student_id' => $user->user_id,
                            'course_id' => $req->course_id,
                            'status' => 'STT2'
                        ]
                    )
                );
                $data = $this->orderRepository->getOrderById($id);
                return response()->json([
                    'success' => true,
                    'data' => $data,
                    'message' => "Register for the course successfully",
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
