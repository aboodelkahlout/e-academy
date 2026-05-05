<?php

namespace App\Payments;

use App\PaymentInterface;

class StripeService implements PaymentInterface
{

    public function pay($amount){

        //the logic of stripe payment

        return "you paid ($amount) by stripe payment";
    }

}
