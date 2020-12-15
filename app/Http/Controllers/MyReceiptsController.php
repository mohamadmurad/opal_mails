<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReceiptRequest;
use App\Models\Company;
use App\Models\files;
use App\Models\receipts;

use Carbon\Carbon;
use http\Exception;
use I18N_Arabic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

include 'ar/Arabic.php';


class MyReceiptsController extends Controller
{
    public function index(Request $request)
    {

        if ($request->has('date') && $request->get('date') !== null ){

            $receipts = receipts::whereDate('created_at',$request->get('date'))->paginate();

        }else{
            $receipts = receipts::orderBy('created_at','desc')->paginate();
        }

        $receipts->load('employee');

        return view('myreceipt.index',compact('receipts'));
    }


    public function create(){

        $company = Company::all();
        return view('myreceipt.create',compact('company'));
    }

    public function store(StoreReceiptRequest $request)
    {
        $filesX = [];
        DB::beginTransaction();
        try {
            $obj = new I18N_Arabic('Numbers');

            $text = $obj->int2str($request['amount']);

            $receipt = receipts::create([
                'recipient_name' => $request['recipient_name'],
                'amount' => $request['amount'],
                'amountText' => $text,
                'reason' => $request['reason'],
                'employee_id' => Auth::id(),
                'company_id' => $request['company_id'],
                'status' =>null,
            ]);

            if($request->hasFile('files')){

                $files = $request->file('files');

                $i = 1;
                foreach ($files as $file){

                    $extension = $file->getClientOriginalExtension();

                    $fileName = Str::slug( $request->get('recipient_name')) . '_' . $i++ .Str::slug( Carbon::now()) . '.' .$extension;
                    $dd= Storage::disk('files')->put($fileName,  File::get($file));


                    files::create([
                        'name' => $fileName,
                        'size' => $file->getSize(),
                        'type' =>  $file->getMimeType(),
                        'receipts_id' => $receipt->id,
                    ]);


                    $filesX +=[$fileName];
                }

            }

            DB::commit();
            return Redirect::route('MyReceipt.show',$receipt->id)
                ;
        }catch (Exception $e){
            DB::rollBack();
            foreach ($filesX as $fileX){

                if (Storage::disk('files')->exists($fileX)){
                    Storage::disk('files')->delete($fileX);
                }

            }

        }
        return Redirect::back()
            ;




    }


    public function show(Request $request, receipts $MyReceipt){


        $MyReceipt->load(['employee.company','manager']);


        $obj = new I18N_Arabic('Numbers');

        $text = $obj->int2str($MyReceipt->amount);


        return view('MyReceipt.show',compact('MyReceipt','text'));
    }


    public function edit( receipts $MyReceipt){

        $company = Company::all();
        return view('MyReceipt.edit',compact('MyReceipt','company'));
    }


    public function update(Request $request ,  receipts $MyReceipt){



        if ($MyReceipt->status === 0 ){
            $request->validate( [
                'recipient_name' => 'required|max:255',
                'amount' => 'required|integer|min:0',
                'reason' => 'required|string',
                'company_id' => 'required',
            ]);



            $MyReceipt->forceFill([
                'recipient_name' =>$request['recipient_name'],
                'amount' => $request['amount'],
                'reason' => $request['reason'],
                'company_id' => $request['company_id'],

            ])->save();
        }


        return Redirect::route('MyReceipt.show',$MyReceipt->id);

    }

    public function destroy(receipts $MyReceipt){

        $MyReceipt->delete();
        return Redirect::route('MyReceipt.index')
            ->with('success','Receipt Deleted successfully.');
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

        $title ="تم قبول أمر دفع لـ  :" .  $receipt->recipient_name;
        $body = "المبلغ  : " .  $receipt->amount . "\n من قبل المدير : " .$receipt->manager->name
            . "\n ملاحظات : " . $receipt->notes;
        $icon = asset('logo/'.$receipt->company->logo);
        $data = $receipt;
        $auth_id = 1;
        $device_token = DB::table('users')->where('fcm_token','!=','')->pluck('fcm_token')->toArray();
        if (count($device_token)>0){
            $ob = new FcmController();
            $result = $ob->sendTo($data,$device_token,$title,$body,$icon);


        }



        return redirect::route('MyReceipt.show', $request['receipt_id']);

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


        $title ="تم رفض أمر دفع لـ  :" .  $receipt->recipient_name;
        $body = "المبلغ  : " .  $receipt->amount . "\n من قبل المدير : " .$receipt->manager->name
            . "\n ملاحظات : " . $receipt->notes;
        $icon = asset('logo/'.$receipt->company->logo);
        $data = $receipt;
        $auth_id = 1;
        $device_token = DB::table('users')->where('fcm_token','!=','')->pluck('fcm_token')->toArray();
        if (count($device_token)>0){
            $ob = new FcmController();
            $result = $ob->sendTo($data,$device_token,$title,$body,$icon);
        }

        return redirect::route('MyReceipt.show', $request['receipt_id']);

    }
}
