<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReceiptRequest;
use App\Models\receipts;

use I18N_Arabic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

include 'ar/Arabic.php';

class ReceiptsController extends Controller
{
    public function index()
    {

        $receipts = receipts::orderBy('created_at','desc')->paginate();

        $receipts->load('employee');

       //  dd($receipts);

        return view('receipt.index',compact('receipts'));
    }


   /* public function create(){

        return view('receipt.create');
    }*/

    /*public function store(StoreReceiptRequest $request)
    {

        $receipt = receipts::create([
            'recipient_name' => $request['recipient_name'],
            'amount' => $request['amount'],
            'reason' => $request['reason'],
            'employee_id' => Auth::id(),
        ]);


        return Redirect::route('receipt.show',$receipt->id)
            ;

    }*/


    public function show(Request $request, receipts $receipt){
         $receipt->load('company');
        $obj = new I18N_Arabic('Numbers');

        $text = $obj->int2str($receipt->amount);




        return view('receipt.show',compact('receipt','text'));
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
        ])->save();


        return redirect::route('receipt.show', $request['receipt_id']);

    }



    /*public function edit( receipts $receipt){

        return view('receipt.edit',compact('receipt'));
    }*/


  /*  public function update(Request $request ,  receipts $receipt){



        if ($receipt->status === 0 ){
            $request->validate( [
                'recipient_name' => 'required|max:255',
                'amount' => 'required|integer|min:0',
                'reason' => 'required|string',
            ]);



            $receipt->forceFill([
                'recipient_name' =>$request['recipient_name'],
                'amount' => $request['amount'],
                'reason' => $request['reason'],

            ])->save();
        }


        return Redirect::route('receipt.show',$receipt->id);

    }
*/
    /*
    public function destroy(receipts $receipt){

        $receipt->delete();
        return Redirect::route('receipt.index')
            ->with('success','Receipt Deleted successfully.');
    }
    */
}
