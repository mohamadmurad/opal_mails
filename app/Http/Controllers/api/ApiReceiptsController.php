<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use App\Models\receipts;


use I18N_Arabic;
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

        return \App\Http\Resources\ReceiptsResource::collection($receipts);

    }

    public function show(Request $request, receipts $receipt){
         $receipt->load(['company','manager']);
      //  $obj = new I18N_Arabic('Numbers');

       // $text = $obj->int2str($receipt->amount);




        //return view('receipt.show',compact('receipt','text'));
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
