<?php

namespace App\Observers;

use App\Http\Controllers\FcmController;
use App\Models\receipts;

class ReceiptsObserver
{
    /**
     * Handle the receipts "created" event.
     *
     * @param  \App\Models\receipts  $receipts
     * @return void
     */
    public function created(receipts $receipts)
    {
//        $title ="Fcmapp";
//        $body = "امر دفع جديد  : ".$receipts->recipient_name;
//        $icon =null;
//        $data = $receipts;
//        $auth_id = auth()->id();
//       // $device_token = DB::table('users')->where('id','<>',$auth_id)->where('fcm_token','!=','')->pluck('fcm_token')->toArray();
//        $device_token = "dRePvDu_RSCEedaKXcmL8x:APA91bH3COqRpQ0i1d8AKXL5vdrU1pm0VxEUE6ZRybEoFrTYnRpr_XC-40jIAnaKULGSkRFBVDeITx-fWywxLYFiM4L5ClN--FgmK-xZpCB3aKDSO2JJZT94a6Yu7FQX7qCxL8ahf-T7";
//        $ob = new FcmController();
//        $result = $ob->sendTo($data,$device_token,$title,$body,$icon);
//        dump($result);
    }

    /**
     * Handle the receipts "updated" event.
     *
     * @param  \App\Models\receipts  $receipts
     * @return void
     */
    public function updated(receipts $receipts)
    {
        //
    }

    /**
     * Handle the receipts "deleted" event.
     *
     * @param  \App\Models\receipts  $receipts
     * @return void
     */
    public function deleted(receipts $receipts)
    {
        //
    }

    /**
     * Handle the receipts "restored" event.
     *
     * @param  \App\Models\receipts  $receipts
     * @return void
     */
    public function restored(receipts $receipts)
    {
        //
    }

    /**
     * Handle the receipts "force deleted" event.
     *
     * @param  \App\Models\receipts  $receipts
     * @return void
     */
    public function forceDeleted(receipts $receipts)
    {
        //
    }
}
