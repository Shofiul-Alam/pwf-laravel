<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
//Route::resource('users', 'User\UserController', ['only' => ['show']]);



/*
 * Employee
 */
Route::resource('employees', 'Employee\EmployeeController', ['except' => ['create', 'edit']]);
Route::name('employees')->get('employee/approve', 'Employee\EmployeeController@approval');
//Route::resource('buyers.categories', 'Buyer\BuyerCategoryController', ['only' => ['index']]);
//Route::resource('buyers.products', 'Buyer\BuyerProductController', ['only' => ['index']]);
//Route::resource('buyers.sellers', 'Buyer\BuyerSellerController', ['only' => ['index']]);
//Route::resource('buyers.transactions', 'Buyer\BuyerTransactionController', ['only' => ['index']]);


/*
 * Users
 */
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
Route::name('verify')->get('users/verify/{token}', 'User\UserController@verify');
Route::name('resend')->get('users/{user}/resend', 'User\UserController@resend');
Route::name('users')->get('user/access-level', 'User\UserController@accessLevel');

/*
 * Client
 */
Route::resource('clients', 'Client\ClientController', ['except' => ['create', 'edit']]);

/*
 * contacts
 */
Route::resource('contacts', 'Contact\ContactController', ['except' => ['create', 'edit']]);

/*
 * Projects
 */
Route::resource('projects', 'Project\ProjectController', ['except' => ['create', 'edit']]);

/*
 * Orders
 */
Route::resource('orders', 'Order\OrderController', ['except' => ['create', 'edit']]);

/*
 * Tasks
 */
Route::resource('tasks', 'Task\TaskController', ['except' => ['create', 'edit']]);

/*
 * Positions
 */
Route::resource('positions', 'Position\PositionController', ['except' => ['create', 'edit']]);

/*
 * Employee Allocations
 */
Route::resource('employee-allocations', 'Allocation\EmployeeAllocationController', ['except' => ['create', 'edit']]);
Route::name('employee-allocations')->post('employee-allocations/filter-employees',
                'Allocation\EmployeeAllocationController@filterEmployeesForAllocation');

/*
 * Date Allocations
 */
Route::resource('date-allocations', 'Allocation\AllocatedDateController', ['except' => ['create', 'edit']]);

/*
 * Forms
 */
Route::resource('forms', 'Form\FormController', ['except' => ['create', 'edit']]);


/*
 * Fields
 */
Route::resource('fields', 'Field\FieldController', ['except' => ['create', 'edit']]);
Route::name('fields')->post('fields/add-fields', 'Field\FieldController@addFields');
Route::name('forms')->post('forms/update-fields', 'Field\FieldController@updateFields');

/*
 * Qualifications
 */
Route::resource('qualifications', 'Qualification\QualificationController', ['except' => ['create', 'edit']]);


/*
 * Skills
 */
Route::resource('skills', 'Skill\SkillController', ['except' => ['create', 'edit']]);

/*
 * Inductions
 */
Route::resource('inductions', 'Induction\InductionController', ['except' => ['create', 'edit']]);

/*
 * EmployeeInductions
 */
Route::resource('employee-inductions', 'EmployeeInduction\EmployeeInductionController', ['except' => ['create', 'edit']]);

/*
 * EmployeeTimeLine
 */
Route::resource('employee-timelines', 'Allocation\EmployeeTimelineController', ['except' => ['create', 'edit']]);


