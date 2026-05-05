<?php

namespace App\Payments;

use App\PaymentInterface;

class PaypalService implements PaymentInterface
{
    public function pay($amount)
    {
        // هون مستقبلاً رح تحط كود بايبال الحقيقي
        return "تم دفع مبلغ ($amount) بنجاح عبر PayPal للكورس المختب.";
    }
}
