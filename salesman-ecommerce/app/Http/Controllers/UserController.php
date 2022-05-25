<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\User;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class UserController extends BaseController
{
    protected $userRepository;
    protected $productRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
    }

    public function me() {
        return response()->json([
            "success" => true
        ]);
    }

    /**
     * * @OA\Post(
     *     path="/api/auth/user/register",
     *     summary="Register user",
     *     tags={"Auth"},
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
     *                             example="Admin"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="email",
     *                             type="string",
     *                             example="example@gmail.com"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="tel",
     *                             type="string",
     *                             example="1235264895"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="password",
     *                             type="string",
     *                             example="123456789"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="address",
     *                             type="string",
     *                             example="DN"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             description="",
     *                             property="avatar",
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
     * Register a User.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function register(Request $req)
    {
        try {
            $rule = [
                'tel' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|size:10|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|max:25',
                // 'birthday' => 'required',
                'name' => 'required',
                'address' => 'required',
            ];
            $validator = Validator::make($req->all(), $rule);
            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors()->first(),
                ], 400);
            }
            $entity = $this->userRepository->getLastUserId();
            if ($entity) {
                $id = ++$entity->user_id;
            } else {
                $id = "USER00000001";
            }
            $data = array(
                'user_id' => $id,
                'tel' => $req->tel,
                'email' => $req->email,
                'password' => Hash::make($req->password),
                'name' => $req->name,
                'address' => $req->address,
                'birthday' => $req->birthday,
                'type_id' => "STUDENT",
            );
            if ($req->file('avatar')) {
                $validator = Validator::make($req->all(), [
                    'avatar' => 'image|mimes:jpeg,png,jpg|max:10000',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        "success" => false,
                        "message" => $validator->errors()->first(),
                    ], 400);
                }
                $i = 1;
                if ($req->file('avatar')) {
                    $data['avatar'] = $i;
                }

            }
            $user = $this->userRepository->create(
                $data
            );

            if ($req->file('avatar')) {
                $path = '/static/avatar/user/' . $user['user_id'] . '/' . $i;
                $path_image = $this->userRepository->upload($path, $req->avatar);
                $user['avatar'] = $path_image;
            }

            return response()->json([
                'success' => true,
                'message' => 'Register succesfully'
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
     *     path="/api/admin/create",
     *     summary="Add admin",
     *     tags={"User"},
     *     @OA\RequestBody(
     *        required = true,
     *        @OA\JsonContent(
     *             type="object",
     *                         @OA\Property(
     *                             property="name",
     *                             type="string",
     *                             example="Admin"
     *                         ),
     *                         @OA\Property(
     *                             property="email",
     *                             type="string",
     *                             example="example@gmail.com"
     *                         ),
     *                         @OA\Property(
     *                             property="tel",
     *                             type="string",
     *                             example="1235264895"
     *                         ),
     *                         @OA\Property(
     *                             property="password",
     *                             type="string",
     *                             example="123456789"
     *                         ),
     *                         @OA\Property(
     *                             property="address",
     *                             type="string",
     *                             example="DN"
     *                         ),
     *                         @OA\Property(
     *                             property="sex",
     *                             type="string",
     *                             example=""
     *                         ),
     *        ),
     *     ),
     *     @OA\Response(
     *        response="200",
     *        description="Successful response",
     *     ),
     * )
     * Store a Admin.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function storeAdmin(Request $req)
    {
        try {
            $rule = [
                'tel' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|size:10|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|max:25',
                'name' => 'required',
                'address' => 'required',
                'sex' => 'required',
            ];
            $validator = Validator::make($req->all(), $rule);
            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors()->first(),
                ], 400);
            }
            $entity = $this->userRepository->getLastUserId();
            if ($entity) {
                $id = ++$entity->user_id;
            } else {
                $id = "USER00000001";
            }
            $this->userRepository->create(
                array_merge(
                    $validator->validated(),
                    [
                        'user_id' => $id,
                        'password' => bcrypt($req->password),
                        'type_id' => "TEACHER",
                        'admin' => 1
                    ]
                )
            );

            return response()->json([
                'success' => true,
                'message' => "Add admin succesfully",
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
     *     path="/api/admin/user/create",
     *     summary="Add User",
     *     tags={"User"},
     *     @OA\RequestBody(
     *        required = true,
     *        @OA\JsonContent(
     *             type="object",
     *                         @OA\Property(
     *                             property="name",
     *                             type="string",
     *                             example="Admin"
     *                         ),
     *                         @OA\Property(
     *                             property="email",
     *                             type="string",
     *                             example="example@gmail.com"
     *                         ),
     *                         @OA\Property(
     *                             property="tel",
     *                             type="string",
     *                             example="1235264895"
     *                         ),
     *                         @OA\Property(
     *                             property="password",
     *                             type="string",
     *                             example="123456789"
     *                         ),
     *                         @OA\Property(
     *                             property="address",
     *                             type="string",
     *                             example="DN"
     *                         ),
     *                         @OA\Property(
     *                             property="sex",
     *                             type="string",
     *                             example=""
     *                         ),
     *        ),
     *     ),
     *     @OA\Response(
     *        response="200",
     *        description="Successful response",
     *     ),
     * )
     * Store a User.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function storeUser(Request $req)
    {
        try {
            $rule = [
                'tel' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|size:10|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|max:25',
                'name' => 'required',
                'address' => 'required',
                'sex' => 'required',
            ];
            $validator = Validator::make($req->all(), $rule);
            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors()->first(),
                ], 400);
            }
            $entity = $this->userRepository->getLastUserId();
            if ($entity) {
                $id = ++$entity->user_id;
            } else {
                $id = "USER00000001";
            }
            $this->userRepository->create(
                array_merge(
                    $validator->validated(),
                    [
                        'user_id' => $id,
                        'password' => bcrypt($req->password),
                        'type_id' => "SM",
                        'enabled' => 1,
                    ]
                )
            );

            return response()->json([
                'success' => true,
                'message' => "Add user succesfully",
            ]);
        } catch (\Exception$e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/admin/login",
     *     summary="Login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *        required = true,
     *        @OA\JsonContent(
     *             type="object",
     *                      @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="example@gmail.com"
     *                      ),
     *                      @OA\Property(
     *                         property="password",
     *                         type="string",
     *                         example="123456789"
     *                      ),
     *        ),
     *     ),
     *
     *
     *     @OA\Response(
     *        response="200",
     *        description="Successful response",
     *     ),
     * )
     *
     * Login Admin
     *
     * @return void
     */
    public function loginAdmin(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:8',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors()->first(),
                ], 400);
            }

            $user = $this->userRepository->getUserByEmail($req->email);
            if ((!$token = auth()->attempt($validator->validated())) || $user == null) {
                return response()->json([
                    "success" => false,
                    "message" => "Email or password is not matched",
                ]);
            }
            if ($user != null && $user->type_id == "STUDENT") {
                return response()->json([
                    "success" => false,
                    "message" => "You have not permission access this page",
                ]);
            }
            return $this->createNewToken($token);
        } catch (\Exception$e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/user/login",
     *     summary="Login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *        required = true,
     *        @OA\JsonContent(
     *             type="object",
     *                      @OA\Property(
     *                         property="tel",
     *                         type="string",
     *                         example="2563148956"
     *                      ),
     *                      @OA\Property(
     *                         property="password",
     *                         type="string",
     *                         example="123456789"
     *                      ),
     *        ),
     *     ),
     *
     *
     *     @OA\Response(
     *        response="200",
     *        description="Successful response",
     *     ),
     * )
     *
     * Login User
     *
     * @return void
     */
    public function loginUser(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'tel' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|size:10',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors()->first(),
                ], 400);
            }

            $user = $this->userRepository->getUserByTel($req->tel);
            if ((!$token = auth()->attempt($validator->validated())) || $user == null) {
                return response()->json([
                    "success" => false,
                    "message" => "Phone number or password is not matched",
                ]);
            }
            if ($user && $user->type_id != "STUDENT") {
                return response()->json([
                    "success" => false,
                    "message" => "You have not permission access this app",
                ]);
            }
            return $this->createNewToken($token);
        } catch (\Exception$e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    }

    /**
     * * @OA\Post(
     *     path="/api/auth/update",
     *     summary="Update user",
     *     tags={"Auth"},
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
     *                             example="Admin"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="email",
     *                             type="string",
     *                             example="example@gmail.com"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="tel",
     *                             type="string",
     *                             example="1235264895"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="address",
     *                             type="string",
     *                             example="DN"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             description="",
     *                             property="avatar",
     *                             type="string", format="binary"
     *                         )
     *                     ),
     *                     @OA\Schema(
     *                         @OA\Property(
     *                            property="birthday",
     *                            type="string",
     *                            example=""
     *                         )
     *                     ),
     *                     @OA\Schema(
     *                         @OA\Property(
     *                            property="sex",
     *                            type="string",
     *                            example=""
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
     * Update User.
     * @param  \Illuminate\Http\Request $req
     * @return \Illuminate\Http\Response
     */
    public function updateUserLogin(Request $req)
    {
        try {
            $user = auth()->user();
            $rule = [
                'tel' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|size:10',
                'email' => 'required|email',
                'name' => 'required',
                'address' => 'required',
                'sex' => 'required',
                'birthday' => 'required|date'
            ];
            $validator = Validator::make($req->all(), $rule);
            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors()->first(),
                ], 400);
            }
            if ($req->file('avatar')) {
                $validator = Validator::make($req->all(), [
                    'avatar' => 'image|mimes:jpeg,png,jpg|max:10000',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        "success" => false,
                        "message" => $validator->errors()->first(),
                    ], 400);
                }

            }
            $data = array(
                'name' => $req->name,
                'email' => $req->email,
                'sex' => $req->sex,
                'address' => $req->address,
                'tel' => $req->tel,
                'birthday' => $req->birthday,
            );

            if ($user) {
                if ($req->file('avatar')) {
                    if ($user->avatar == null) {
                        $id_image = 1;
                    } else {
                        $id_image = intval($user->avatar) + 1;
                    }
                    
                    $data['avatar'] = $id_image;
                    $path = '/static/avatar/user/' . $user->user_id . '/' . $id_image;
                    $path_image = $this->userRepository->upload($path, $req->avatar);
                } else {
                    if (isset($user->avatar) && !empty($user->avatar)) {
                        $path = '/static/avatar/user/' . $user->user_id . '/' . $user->avatar;
                        $path_image = $this->userRepository->getImg($path);
                    }
                }
                $this->userRepository->update($user->id, $data);
                $data['avatar'] = $path_image;
                return response()->json([
                    'success' => true,
                    'message' => 'Update succesfully',
                    'data' => $data,
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => '',
                    'message' => 'Please login before making this action',
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
     *      path="/api/admin/user/detail/{user_id}",
     *      summary="View detail user by id",
     *      tags={"User"},
     *      security={ {"bearer": {}} },
     *        @OA\Parameter(
     *          name="user_id",
     *          description="user_id",
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = User::find($id);
            if ($data) {
                if (isset($data['avatar']) && !empty($data['avatar'])) {
                    $path = '/static/avatar/user/' . $data['user_id'] . '/' . $data['avatar'];
                    $data['avatar'] = $this->userRepository->getImg($path);
                } else {
                    $path = '/static/avatar/user/no-avatar/no-avatar.png';
                    $avatar = config('filesystems.disks')['public']['url'].$path;
                    $data['avatar'] = $avatar; 
                }
                return response()->json([
                    'success' => true,
                    'data' => $data,
                ]);
            }
            return response()->json([
                "success" => false,
                "message" => "User does not exist",
            ], 400);
        } catch (\Exception$e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    }

    /**
     *  * *  @OA\Get(
     *      path="/api/admin/user/list",
     *      summary="Get list user",
     *      tags={"User"},
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
    public function listUser()
    {
        try {
            $user = auth()->user();
            if ($user) {
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
     *      path="/api/admin/teacher/list",
     *      summary="Get list teacher",
     *      tags={"User"},
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
    public function listTeacher()
    {
        try {
            $user = auth()->user();
            $data = array();
            if ($user) {
                if ($user->type_id == 'TEACHER') {
                    $data[0] = $this->userRepository->getUserById($user->user_id);
                } elseif ($user->type_id == 'ADM') {
                    $data = $this->userRepository->getUserByType('TEACHER');
                } else {
                    return response()->json([
                        "success" => false,
                        "message" => 'You have not permission',
                    ]);
                }
                return response()->json([
                    'success' => true,
                    'data' => $data,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be login',
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
     *      path="/api/admin/user/shop/list",
     *      summary="Get list shop",
     *      tags={"User"},
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
    public function listShop()
    {
        try {
            $data = $this->userRepository->getUserByType('SHOP');
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
     *      path="/api/admin/list",
     *      summary="Get list admin",
     *      tags={"User"},
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
    public function listAdmin()
    {
        try {
            $user = auth()->user();
            if($user) {
                if($user->admin == 1) {
                    $data = $this->userRepository->getAllAdmin();
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
                        'message' => "You have not permission to access this page",
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
     *  *   @OA\Post(
     *      path="/api/admin/user/delete/{user_id}",
     *      summary="Delete user",
     *      tags={"User"},
     *      security={ {"bearer": {}} },
     *      @OA\Parameter(
     *          name="user_id",
     *          description="user_id",
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if ($user) {
                // $product = $this->productRepository->getProductByOwner($user->user_id);
                // for ($i = 0; $i<count($product); $i++) {
                //     $item = Products::find($product[$i]->id);
                //     if ($item) {
                //         $entity = array(
                //             'enabled' => 0,
                //         );
                //         $this->productRepository->update($item->id, $entity);
                //     }
                // }
                $data = array(
                    'state' => 0,
                );
                $this->userRepository->update($user->id, $data);
                return response()->json([
                    'success' => true,
                    "message" => "Delete user complete",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "User not found",
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
     *      path="/api/admin/user/confirm/{user_id}",
     *      summary="Confirm user",
     *      tags={"User"},
     *      security={ {"bearer": {}} },
     *      @OA\Parameter(
     *          name="user_id",
     *          description="user_id",
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirmUser($id)
    {
        try {
            $user = User::find($id);
            if ($user) {
                $data = array(
                    'enabled' => 1,
                );
                $this->userRepository->update($user->id, $data);
                $this->sendEmail('email.email', $user->email, ['name' => $user->name] , 'Notice confirm account' );
                return response()->json([
                    'success' => true,
                    "message" => "Confirm user complete",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "User not found",
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    }

    /**
     *  *   @OA\Post(
     *      path="/api/admin/user/area/update/{user_id}",
     *      summary="Update area salesman",
     *      tags={"User"},
     *      security={ {"bearer": {}} },
     *      @OA\Parameter(
     *          name="user_id",
     *          description="user_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *        required = true,
     *        @OA\JsonContent(
     *             type="object",
     *                      @OA\Property(
     *                         property="area_id",
     *                         type="string",
     *                         example="HC001"
     *                      ),
     *        ),
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateArea(Request $req, $id)
    {
        try {
            $user = User::find($id);
            if ($user) {
                $data = array(
                    'area_id' => $req->area_id,
                );
                $this->userRepository->update($user->id, $data);
                return response()->json([
                    'success' => true,
                    "message" => "Update area complete",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "User not found",
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        $user = auth()->user();
        if(!empty($user->avatar)){
            $path = '/static/avatar/user/'.$user->user_id.'/'.$user->avatar;
            $user->avatar = $this->userRepository->getImg($path) ;  
        }else{
            $path = '/static/avatar/user/no-avatar/no-avatar.png';
            $avatar = config('filesystems.disks')['public']['url'].$path;
            $user->avatar = $avatar;   
        }
        $user->token = $token;
        return response()->json([
            'success' => true,
            'data' => $user,
        ]);
    }
}
