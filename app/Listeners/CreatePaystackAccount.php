<?php

namespace App\Listeners;

use App\Events\Registered;
use Unicodeveloper\Paystack\Paystack;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;



class CreatePaystackAccount
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $user = $event->user;
        $paystackDetails = $event->paystackDetails;

        //dd(get_class_methods(app('Paystack')));
     $paystack = new Paystack();

      $data = [
         'business_name' => $paystackDetails['business_name'],
            'settlement_bank' => $paystackDetails['settlement_bank'],
            'account_number' => $paystackDetails['account_number'],
            'percentage_charge' => $paystackDetails['percentage_charge'],
      ];
      $response = $paystack->createSubAccount($data);
      $paystackAccountId = $response['data']['id'];

      if ($response['status'] && isset($response['data']['id'])) {
        $paystackAccountId = $response['data']['id'];
        $user->update([
            'paystack_account_id' => $paystackAccountId,
        ]);
    } else {
        \Log::error('Failed to create Paystack subaccount', [
            'user_id' => $user->id,
            'paystack_response' => $response,
        ]);
    }


    //   $event->user->update([
    //     'paystack_account_id' => $paystackAccountId,
    //   ]);

    }
}
