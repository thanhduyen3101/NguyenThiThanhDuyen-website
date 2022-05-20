<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    protected $categoryRepository;
    protected $productRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * * @OA\Post(
     *     path="/api/admin/category/create",
     *     summary="Create category",
     *     tags={"Category"},
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
     *                             example="Laptop"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="maximum_student",
     *                             type="integer",
     *                             example="30"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="description",
     *                             type="integer",
     *                             example="30"
     *                         )
     *                      ),
     *                      @OA\Schema(
     *                         @OA\Property(
     *                             property="id_teacher",
     *                             type="string",
     *                             example="USER00003"
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
                'name' => 'required',
                'maximum_student' => 'required|numeric',
                'id_teacher' => 'required',
                'description' => 'required',
                'start_day' => 'required',
                'end_day' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:10000',
            ];
            $validator = Validator::make($req->all(), $rule);
            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors()->first(),
                ], 400);
            }
            $entity = $this->categoryRepository->getLastCategoryId();
            if ($entity) {
                $id = ++$entity->course_id;
            } else {
                $id = "COURSE001";
            }
            $i = 1;
            $data = array(
                'course_id' => $id,
                'name' => $req->name,
                'image' => $i,
                'id_teacher' => $req->id_teacher,
                'description' => $req->description ? $req->description : "",
                'start_day' => $req->start_day,
                'end_day' => $req->end_day,
                'maximum_student' => $req->maximum_student,
            );
            $category = $this->categoryRepository->create(
                $data
            );
            if ($req->file('image')) {
                $path = '/static/image/category/' . $category['course_id'] . '/' . $i;
                $path_image = $this->categoryRepository->upload($path, $req->image);
                $category['image'] = $path_image;
            }
            return response()->json([
                'success' => true,
                'data' => $category,
                'message' => "Create course succesfully",
            ]);
        } catch (\Exception$e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    }

    /**
     *  * *  @OA\Get(
     *      path="/api/student/category/list",
     *      summary="Get list all categories for student",
     *      tags={"Category"},
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
    public function listCategoryForStudent()
    {
        try {
            $category = $this->categoryRepository->getAllCategoryForStudent();
            if ($category) {
                return response()->json([
                    'success' => true,
                    'data' => $category,
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

    public function listCategory()
    {
        try {
            $user = auth()->user();
            if ($user) {
                if ($user->type_id == "TEACHER") {
                    $data = $this->categoryRepository->getAllCategoryByTeacher($user->user_id);    
                } elseif ($user->type_id == "ADM") {
                    $data = $this->categoryRepository->getAllCategory();
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
     *  *  *@OA\Get(
     *      path="/api/admin/category/detail/{category_id}",
     *      summary="View detail category by id",
     *      tags={"Category"},
     *      security={ {"bearer": {}} },
     *        @OA\Parameter(
     *          name="category_id",
     *          description="category_id",
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
            $data = Category::find($id);
            if($data) {
                if (isset($data['image']) && !empty($data['image'])) {
                    $path = '/static/image/category/' . $data['course_id'] . '/' . $data['image'];
                    $data['image'] = $this->categoryRepository->getImg($path);
                } else {
                    $path = '/static/image/category/no-avatar/no-avatar.png';
                    $image = config('filesystems.disks')['public']['url'].$path;
                    $data['image'] = $image; 
                }
                return response()->json([
                    'success' => true,
                    'data' => $data,
                ]);
            }
            return response()->json([
                "success" => false,
                "message" => "Course does not exist",
            ], 400);
        } catch (\Exception$e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function detailCategoryForStudent($course_id)
    {
        try {
            $user = auth()->user();
            if ($user) {
                $data = $this->categoryRepository->findCategoryByStudentIdAndCourseId($course_id, $user->user_id);
                if($data && $data['id']) {
                    return response()->json([
                        'success' => true,
                        'data' => $data,
                    ]);
                }
                return response()->json([
                    "success" => false,
                    "message" => "Course does not exist",
                ], 400);
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
     *     path="/api/admin/category/update/{id}",
     *     summary="Update category",
     *     tags={"Category"},
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
     *                             property="name",
     *                             type="string",
     *                             example="Laptop"
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
     * Update Category.
     * @param  \Illuminate\Http\Request $req
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        try {
            $rule = [
                'name' => 'required|string',
                'maximum_student' => 'required|numeric',
                'id_teacher' => 'required',
                'start_day' => 'required',
                'end_day' => 'required'
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
                'name' => $req->name,
                'maximum_student' => $req->maximum_student,
                'id_teacher' => $req->id_teacher,
                'description' => $req->description ? $req->description : '',
                'start_day' => $req->start_day,
                'end_day' => $req->end_day,
            );
            $entity = Category::find($id);
            if ($entity) {
                if ($req->file('image')) {
                    if ($entity->image == null) {
                        $id_image = 1;
                    } else {
                        $id_image = intval($entity->image) + 1;
                    }
                    
                    $data['image'] = $id_image;
                    $path = '/static/image/category/' . $entity->course_id . '/' . $id_image;
                    $path_image = $this->categoryRepository->upload($path, $req->image);
                } else {
                    if (isset($entity->image) && !empty($entity->image)) {
                        $path = '/static/image/category/' . $entity->course_id . '/' . $entity->image;
                        $path_image = $this->categoryRepository->getImg($path);
                    }
                }
                $data['course_id'] = $entity['course_id'];
                $this->categoryRepository->update($entity->id, $data);
                $data['image'] = $path_image;
                return response()->json([
                    'success' => true,
                    'message' => 'Update succesfully',
                    'data' => $data,
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    'message' => 'Category does not exist',
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
     *      path="/api/admin/category/delete/{category_id}",
     *      summary="Delete category",
     *      tags={"Category"},
     *      security={ {"bearer": {}} },
     *      @OA\Parameter(
     *          name="category_id",
     *          description="category_id",
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
     * Delete category
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $category = Category::find($id);
            if ($category) {
                $product = $this->productRepository->getProductByCourseId($category->course_id);
                if (count($product)>0) {
                    for ($i = 0; $i<count($product); $i++) {
                        $data = array(
                            'category' => null
                        );
                        $this->productRepository->update($product[$i]->id, $data);
                    }
                }
                
                $folderPath = "storage/static/image/category/" . $category->course_id;

                $response = File::deleteDirectory($folderPath);

                $this->categoryRepository->delete($id);
                return response()->json([
                    'success' => true,
                    "message" => "Delete category complete",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "Category not found",
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
