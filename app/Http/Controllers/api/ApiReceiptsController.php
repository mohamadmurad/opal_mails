<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use App\Http\Resources\ReceiptsResource;
use App\Models\receipts;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $receipts->load(['employee','manager','company']);

        return ReceiptsResource::collection($receipts);

    }

    public function show(Request $request, receipts $receipt){
         $receipt->load(['employee','manager','company']);

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

        $receipt = receipts::findOrFail($request['receipt_id']);
        $receipt->fill([
            'status' => 1,
            'notes' => $request['notes'],
            'manager_id' => Auth::id(),
        ])->save();

        return redirect::route('receipt.show', $request['receipt_id']);

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
            'manager_id' => Auth::id(),
        ])->save();


        return redirect::route('receipt.show', $request['receipt_id']);

    }


}
