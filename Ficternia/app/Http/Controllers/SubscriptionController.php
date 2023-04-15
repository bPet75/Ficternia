<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends ConnectionController
{    
    /**
     * Feliratkozás beállítása vagy törlése.
     *
     * @param  Request $request
     * @param  int $userId
     */
    public static function setSubscription(Request $request, $userId){
        $array = explode('_',$request->input('subscribeButton'));
        if($array[0]== 0){
            parent::_store(Subscription::class, [
                'subscriber_id' => Auth::user()->id,
                'subscribed_to_id' => $array[1],
            ]);
        }
        else if($array[0]== 1){
            parent::_destroy(Subscription::class, [
                'subscriber_id' => Auth::user()->id,
                'subscribed_to_id' => $array[1],
            ]);
        }
        return redirect()->route('userPage',$userId);
    }
}
