<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    protected $productRepository;
    protected $userRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    /**
     *  * *  @OA\Get(
     *      path="/api/product/list/{course_id}",
     *      summary="Get list product",
     *      tags={"Product"},
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
    public function listProduct($course_id)
    {
        try {
            $data = $this->productRepository->getProductByCourseId($course_id);
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
     *  *  *@OA\Get(
     *      path="/api/product/detail/{product_id}",
     *      summary="View detail product by id",
     *      tags={"Product"},
     *      security={ {"bearer": {}} },
     *        @OA\Parameter(
     *          name="product_id",
     *          description="product_id",
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
            $data = Products::find($id);
            if($data) {
                $owner = $this->userRepository->getUserById($data['owner_id']);
                if (isset($data['image']) && !empty($data['image'])) {
                    $path = '/static/image/product/' . $data['product_id'] . '/' . $data['image'];
                    $data['image'] = $this->productRepository->getImg($path);
                } else {
                    $path = '/static/image/product/no-avatar/no-avatar.png';
                    $image = config('filesystems.disks')['public']['url'].$path;
                    $data['image'] = $image; 
                }
                $data["owner_name"] = $owner->name;
                return response()->json([
                    'success' => true,
                    'data' => $data,
                ]);
            }
            return response()->json([
                "success" => false,
                "message" => "Product does not exist",
            ], 400);
        } catch (\Exception$e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    }

    /**
     *  *  *@OA\Get(
     *      path="/api/product/detail/{course_id}",
     *      summary="View product by category",
     *      tags={"Product"},
     *      security={ {"bearer": {}} },
     *        @OA\Parameter(
     *          name="category_id",
     *          description="category_id",
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
     * Display the specified resource.
     *
     * @param  string  $category
     * @return \Illuminate\Http\Response
     */
    public function listProductByCourse($course_id)
    {
        try {
            $data = $this->productRepository->getProductByCourseId($course_id);
                return response()->json([
                    'success' => true,
                    'data' => $data,
                ]);
        } catch (\Exception$e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    }
    
    /**
     *  *  *@OA\Get(
     *      path="/api/product/list/owner/{owner_id}",
     *      summary="View product by owner",
     *      tags={"Product"},
     *      security={ {"bearer": {}} },
     *        @OA\Parameter(
     *          name="owner_id",
     *          description="owner_id",
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
     * Display the specified resource.
     *
     * @param  string  $owner_id
     * @return \Illuminate\Http\Response
     */
    public function listProductByOwner($owner_id)
    {
        try {
            $data = $this->productRepository->getProductByOwner($owner_id);
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
     *     path="/api/admin/product/create",
     *     summary="Create product",
     *     tags={"Product"},
     *     security={ {"bearer": {}} },
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 allOf={
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="title",
     *                             type="string",
     *                             example="T-shirt"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="owner_id",
     *                             type="string",
     *                             example="USER00000003"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="category",
     *                             type="string",
     *                             example="CATE001"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="size",
     *                             type="string",
     *                             example="M"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="price",
     *                             type="float",
     *                             example="53.2"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="description",
     *                             type="text",
     *                             example=""
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
     * Create product.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        try {
            $rule = [
                'title' => 'required|string',
                'course_id' => 'required',
                'content' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
            ];
            $validator = Validator::make($req->all(), $rule);
            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors()->first(),
                ], 400);
            }
            $entity = $this->productRepository->getLastProductId();
            if ($entity) {
                $id = ++$entity->lesson_id;
            } else {
                $id = "ITEM000000001";
            }
            $i = 1;
            $data = array(
                'lesson_id' => $id,
                'title' => $req->title,
                'course_id' => $req->course_id,
                'content' => $req->content,
                'image' => $req->file('image') ? $i : null,
            );
            $product = $this->productRepository->create(
                $data
            );
            if ($req->file('image')) {
                $path = '/static/image/product/' . $product['lesson_id'] . '/' . $i;
                $path_image = $this->productRepository->upload($path, $req->image);
                $product['image'] = $path_image;
            }
            return response()->json([
                'success' => true,
                'message' => "Create lesson succesfully",
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
     *     path="/api/admin/product/update/{id}",
     *     summary="Update product",
     *     tags={"Product"},
     *     security={ {"bearer": {}} },
     *      @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 allOf={
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="title",
     *                             type="string",
     *                             example="T-shirt"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="owner_id",
     *                             type="string",
     *                             example="USER00000003"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="category",
     *                             type="string",
     *                             example="CATE001"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="size",
     *                             type="string",
     *                             example="M"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="price",
     *                             type="float",
     *                             example="53.2"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="description",
     *                             type="text",
     *                             example=""
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
     * Update Product.
     * @param  \Illuminate\Http\Request $req
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        try {
            $rule = [
                'title' => 'required|string',
                'content' => 'required',
            ];
            $validator = Validator::make($req->all(), $rule);
            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors()->first(),
                ], 400);
            }
            if ($req->file('image')) {
                $validator = Validator::make($req->all(), [
                    'image' => 'image|mimes:jpeg,png,jpg|max:10000',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        "success" => false,
                        "message" => $validator->errors()->first(),
                    ], 400);
                }

            }
            $data = array(
                'title' => $req->title,
                'content' => $req->content,
            );
            $entity = Products::find($id);
            if ($entity) {
                if ($req->file('image')) {
                    if ($entity->image == null) {
                        $id_image = 1;
                    } else {
                        $id_image = intval($entity->image) + 1;
                    }
                    
                    $data['image'] = $id_image;
                    $path = '/static/image/product/' . $entity->lesson_id . '/' . $id_image;
                    $path_image = $this->productRepository->upload($path, $req->image);
                } else {
                    if (isset($entity->image) && !empty($entity->image)) {
                        $path = '/static/image/product/' . $entity->lesson_id . '/' . $entity->image;
                        $path_image = $this->productRepository->getImg($path);
                    }
                }
                $data['lesson_id'] = $entity['lesson_id'];
                $this->productRepository->update($entity->id, $data);
                $data['image'] = $path_image;
                return response()->json([
                    'success' => true,
                    'message' => 'Update succesfully',
                    'data' => $data,
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    'message' => 'Lesson does not exist',
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
     *      path="/api/admin/product/delete/{product_id}",
     *      summary="Delete product",
     *      tags={"Product"},
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
            $product = Products::find($id);
            if ($product) {
                $data = array(
                    'enabled' => 0,
                );
                $this->productRepository->update($product->id, $data);
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

}
