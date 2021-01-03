<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use App\Http\Controllers\FcmController;
use App\Http\Requests\StoreReceiptRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\ReceiptsResource;
use App\Models\files;
use App\Models\receipts;


use App\Models\User;
use Carbon\Carbon;
use http\Exception;
use I18N_Arabic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
include 'ar/Arabic.php';

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
            return response()->json([
                'data' => $request->all(),
                'code' => 400,
            ]);

            if($request->hasFile('file')){

                $files = $request->file('file');

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

            return response()->json([
                'data' => true,
                'code' => 200,
            ]);
        }catch (Exception $e){
            DB::rollBack();
            foreach ($filesX as $fileX){

                if (Storage::disk('files')->exists($fileX)){
                    Storage::disk('files')->delete($fileX);
                }

            }

        }

        return response()->json([
            'data' => "error",
            'code' => 400,
        ]);




    }

    public function update(StoreReceiptRequest $request){

        $MyReceipt = receipts::all()->where('id','=',$request['id'])->first();

        if ($MyReceipt->status === null){
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

            return response()->json([
                'data' => true,
                'code' => 200,
            ]);
        }

        return response()->json([
            'data' => false,
            'code' => 500,
        ]);




    }

    public function destroy(Request $request){
        $MyReceipt = receipts::all()->where('id','=',$request['id'])->first();

        $MyReceipt->delete();

        return response()->json([
            'data' => true,
            'code' => 200,
        ]);
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

        if(Auth::user()->isManager === 1){

            $receipt = receipts::findOrFail($request['receipt_id']);
            $receipt->fill([
                'status' => 1,
                'notes' => $request['notes'],
                'manager_id' => Auth::user()->id,
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

        }



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

        if(Auth::user()->isManager === 1){
            $receipt = receipts::findOrFail($request['receipt_id']);
            $receipt->fill([
                'status' => 0,
                'notes' => $request['notes'],
                'manager_id' =>Auth::user()->id,
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

        }



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
