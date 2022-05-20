<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KPIController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//admin
Route::group(['prefix' => 'admin'], function () {
    Route::post('/create', [UserController::class, 'storeAdmin']);
    Route::get('/list', [UserController::class, 'listAdmin']);
    Route::get('/teacher/list', [UserController::class, 'listTeacher']);
    
    //user_management
    Route::group(['prefix' => 'user'], function () {
        Route::post('/create', [UserController::class, 'storeUser']);
        Route::get('/detail/{id}', [UserController::class, 'show']);
        Route::post('/delete/{id}', [UserController::class, 'destroy']);
        Route::post('/confirm/{id}', [UserController::class, 'confirmUser']);
        Route::post('/area/update/{id}', [UserController::class, 'updateArea']);
        Route::get('/list', [UserController::class, 'listUser']);
        Route::get('/salesman/list', [UserController::class, 'listSalesman']);
        Route::get('/shop/list', [UserController::class, 'listShop']);
    });

    //dashboard
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/total', [DashboardController::class, 'getTotal']);
    });

    //checkin
    Route::group(['prefix' => 'checkin'], function () {
        Route::get('/list', [CheckinController::class, 'listAllCheckin']);
    });

    //product_management
    Route::group(['prefix' => 'product'], function () {
        Route::post('/create', [ProductController::class, 'store']);
        Route::post('/update/{product_id}', [ProductController::class, 'update']);
        Route::post('/delete/{product_id}', [ProductController::class, 'destroy']);
    });

    //order_management
    Route::group(['prefix' => 'order'], function () {
        Route::get('/list', [OrderController::class, 'listAllOrder']);
        Route::get('/order_detail/list', [OrderController::class, 'listAllOrderDetail']);
        Route::post('/confirm/{order_id}', [OrderController::class, 'confirmOrder']);
    });

    //area
    Route::group(['prefix' => 'area'], function () {
        Route::get('/list', [AreaController::class, 'listArea']);
    });

    //category_management
    Route::group(['prefix' => 'category'], function () {
        Route::post('/create', [CategoryController::class, 'store']);
        Route::get('/detail/{category_id}', [CategoryController::class, 'show']);
        Route::post('/update/{category_id}', [CategoryController::class, 'update']);
        Route::post('/delete/{category_id}', [CategoryController::class, 'delete']);
    });

    //kpi_management
    Route::group(['prefix' => 'kpi'], function () {
        Route::post('/save', [KPIController::class, 'store']);
        Route::get('/list', [KPIController::class, 'listAllKPI']);
        Route::post('/delete/{kpi_id}', [KPIController::class, 'deleteKPI']);
        Route::get('/salesman', [KPIController::class, 'listKPI']);
    });

    //customer
    Route::group(['prefix' => 'customer'], function () {
        Route::post('/import', [CustomerController::class, 'fileImport']);
    });
});

Route::group(['prefix' => 'user'], function () {
    //order_management
    Route::group(['prefix' => 'order'], function () {
        Route::post('/order_detail/delete/{order_detail_id}', [OrderController::class, 'deleteOrderDetail']);
        Route::post('/delete/{order_id}', [OrderController::class, 'deleteOrder']);
        Route::post('/order_detail/update/{order_detail_id}', [OrderController::class, 'updateOrderDetail']);
        Route::post('/update/{order_id}', [OrderController::class, 'updateOrder']);
        Route::post('/create', [OrderController::class, 'storeOrder']);
        Route::post('/order_detail/create', [OrderController::class, 'storeOrderDetail']);
        Route::get('/order_detail/list', [OrderController::class, 'listOrderDetailBySalesman']);
    });

    //kpi_management
    Route::group(['prefix' => 'kpi'], function () {
        Route::get('/', [KPIController::class, 'showKPIBySalesman']);
    });

    //checkin
    Route::group(['prefix' => 'checkin'], function () {
        Route::get('/', [CheckinController::class, 'showCheckinBySalesman']);
        Route::post('/create', [CheckinController::class, 'store']);
    });
});

Route::group(['prefix' => 'auth'], function () {
    //login & register user
    Route::post('/user/login', [UserController::class, 'loginUser']);
    Route::post('/user/register', [UserController::class, 'register']);

    //login admin
    Route::post('admin/login', [UserController::class, 'loginAdmin']);

    //update
    Route::post('update', [UserController::class, 'updateUserLogin']);
});

//categories
Route::post('addCategory', [CategoryController::class, 'addCategory']);
Route::get('listCategory', [CategoryController::class, 'listCategory']);

//product
Route::group(['prefix' => 'product'], function () {
    Route::get('/list/{course_id}', [ProductController::class, 'listProduct']);
    Route::get('/detail/{course_id}', [ProductController::class, 'listProductByCourse']);
    // Route::get('/list/category/{category_id}', [ProductController::class, 'listProductByCategory']);
    Route::get('/list/owner/{owner_id}', [ProductController::class, 'listProductByOwner']);
});

//category
Route::get('student/category/list', [CategoryController::class, 'listCategoryForStudent']);
Route::get('student/category/detail/{course_id}', [CategoryController::class, 'detailCategoryForStudent']);
Route::get('admin/category/list', [CategoryController::class, 'listCategory']);

//order
Route::group(['prefix' => 'order'], function () {
    Route::get('/list/student', [OrderController::class, 'listOrderByStudent']);
    Route::get('/information/{order_id}', [OrderController::class, 'show']);
    Route::get('/order_detail/{order_id}', [OrderController::class, 'showOrderDetail']);
    Route::post('/update/status/{order_id}', [OrderController::class, 'updateStatusOrder']);
});

//customer
Route::group(['prefix' => 'customer'], function () {
    Route::get('/list', [CustomerController::class, 'listCustomer']);
    Route::post('/create', [CustomerController::class, 'store']);
});

Route::middleware(['auth:api'])->get('me', [UserController::class, 'me']);