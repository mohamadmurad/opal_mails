<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;


use App\Http\Resources\EmployeeResource;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Http\Requests\LoginRequest;
use Laravel\Passport\Client;



class AuthApiController extends Controller
{

    use ApiResponser;

    private $getTokenURI ;

    public function __construct()
    {

        $this->getTokenURI  = url('/') . '/oauth/token';
    }


    public function login(LoginRequest $request) {
        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {


            return $this->getTokenAndRefreshToken($request->get('email'), $request->get('password'));
        }
        else {

            return response()->json(['error'=> "Email Or Password Error!"], 401);
        }
    }


    public function getTokenAndRefreshToken($email, $password) {

        $client = Client::where('password_client', 1)->first();

        if (!$client){
            return $this->errorResponse(trans('error.passport_client'),403);
        }

        $data = [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $email,
            'password' => $password,
            'scope' => '*',
        ];


        $r = Request::create($this->getTokenURI,'post',$data);


        $content = json_decode(app()->handle($r)->getContent());

        return $this->successResponse($content,200);

    }



    public function myInfo(Request $request){

        dd(Auth::user());
        return  new EmployeeResource(Auth::user());


    }

}
