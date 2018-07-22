<?php
namespace App\Http\Controllers\User;
use App\Mail\UserCreated;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
class UserController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->except(['update']);
        $this->middleware('auth:api')->except(['resend', 'verify', 'store']);

    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user->isAdmin()) {
            $users = User::all();
            return $this->showAll($users);
        } else {
            return response()->json(['error' => 'Unauthenticated',
                'code' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];
        $this->validate($request, $rules);
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['is_verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;
        $user = User::create($data);
        return $this->showOne($user, Response::HTTP_CREATED);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'email' => 'email|unique:users',
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER
        ];
        $this->validate($request, $rules);

        $authenticatedUser = Auth::user();

        if($authenticatedUser->id == $user->id || $authenticatedUser->isAdmin()) {
            if($request->has('name')) {
                $user->name = $request->name;
            }
            if($request->has('email') && $user->email != $request->email) {
                $user->is_verified = User::UNVERIFIED_USER;
                $user->verification_token = User::generateVerificationCode();
                $user->email = $request->email;
            }
            if($request->has('password')) {
                $user->password = bcrypt($request->password);
            }
            if($request->has('admin')) {
                if(!$user->isVerified()) {
                    return $this->errorResponse('Only verified users can be a admin',
                        Response::HTTP_CONFLICT);
                }
                if(!$user->isAdmin()) {
                    return $this->errorResponse('Only admin has privileges to change this attributes',
                        Response::HTTP_UNAUTHORIZED);
                }
                $user->admin = $request->admin;
            }

            if($user->isClean()) {
                if(!$user->isVerified()) {
                    return response()->json(['error' => 'You need to specify a different value to update',
                        'code' => Response::HTTP_UNPROCESSABLE_ENTITY], Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            }
            $user->save();
            return $this->showOne($user);
        } else {
            return response()->json(['error' => 'Unauthenticated',
                'code' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user);
    }


    public function verify($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();
        $user->is_verified = User::VERIFIED_USER;
        $user->verification_token = null;
        $user->save();
        return $this->showMessage('The account has been verified successfully');
    }


    public function resend(User $user) {
        if($user->isVerified()) {
            return $this->errorResponse('This user is already verified', Response::HTTP_CONFLICT);
        }
        retry(5, function() use($user) {
            Mail::to($user)->send(new UserCreated($user));
        }, 100);
        return $this->showMessage('The verification email is sent');
    }

    public function accessLevel() {

        $user = Auth::user();

        if($user->isAdmin()) {
            return response()->json(['access_level' => 'Admin',
                'code' => Response::HTTP_OK], Response::HTTP_OK);
        } elseif($user->isEmployee()) {
            return response()->json(['access_level' => 'Employee',
                'code' => Response::HTTP_OK], Response::HTTP_OK);
        } elseif($user->isClient()) {
            return response()->json(['access_level' => 'Client',
                'code' => Response::HTTP_OK], Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'Unauthenticated',
                'code' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }
    }
}