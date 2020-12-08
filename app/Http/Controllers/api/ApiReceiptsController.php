<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use App\Http\Controllers\FcmController;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\ReceiptsResource;
use App\Models\receipts;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;



class ApiReceiptsController extends Controller
{
    public function index(Request  $request)
    {

        if ($request->has('date') && $request->get('date') !== null ){
            $receipts = receipts::whereDate('created_at',$request->get('date'))->paginate();

        }else{
            $receipts = receipts::orderBy('created_at','desc')->paginate();
        }

        $receipts->load(['employee','manager','company','files']);

        return ReceiptsResource::collection($receipts);

    }

    public function show(Request $request, receipts $receipt){
         $receipt->load(['employee','manager','company','files']);

        return new ReceiptsResource($receipt);

    }

    public function accept(Request $request){

        $request->validate([
            'receipt_id'=> 'required|exists:receipts,id',
            'notes' => 'nullable',
        ]);




//        $d = Auth::user()->receipts()->attach([Auth::id() => [
//            'notes' => $request['notes'],
//            'receipts_id' => $request['receipt_id'],
//            'status' => 1,
//        ]]);
        //$data = $request->json();

        $receipt = receipts::findOrFail($request['receipt_id']);
        $receipt->fill([
            'status' => 1,
            'notes' => $request['notes'],
            'manager_id' => Auth::user()->id,
        ])->save();


        return response()->json([
            'data' => true,
            'code' => 200,
        ]);
        //return redirect::route('receipt.show', $data['receipt_id']);

    }


    public function refuse(Request $request){

        $request->validate([
            'receipt_id'=> 'required|exists:receipts,id',
            'notes' => 'nullable',
        ]);


//        $d = Auth::user()->receipts()->attach([Auth::id() => [
//            'notes' => $request['notes'],
//            'receipts_id' => $request['receipt_id'],
//            'status' => 0,
//        ]]);


        $receipt = receipts::findOrFail($request['receipt_id']);
        $receipt->fill([
            'status' => 0,
            'notes' => $request['notes'],
            'manager_id' =>Auth::user()->id,
        ])->save();


        return response()->json([
            'data' => true,
            'code' => 200,
        ]);
       // return redirect::route('receipt.show', $request['receipt_id']);

    }


    public function fcm(Request $request){

        $user = User::where('id','=',Auth::user()->id)->first();

        $user->fill([
            'fcm_token' => $request['fcm'],
        ])->save();

        $title ="اهلا بك " . $user->name;
        $body = "اهلا بك";

        $icon =null;
        $data = null;
        $auth_id = Auth::user()->id;
        $device_token = DB::table('users')->where('isManager','=',1)->where('fcm_token','!=','')->pluck('fcm_token')->toArray();

        if (count($device_token)>0){
            $ob = new FcmController();
            $result = $ob->sendTo($data,$device_token,$title,$body,$icon);
        }

        return response()->json([
            'data' => true,
            'code' => 200,
        ]);
        // return redirect::route('receipt.show', $request['receipt_id']);

    }



}
