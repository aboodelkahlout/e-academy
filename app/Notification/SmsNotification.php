<?php

namespace App\Notification;

use App\NotificationInterface;

class SmsNotification implements NotificationInterface
{
    function Notification($message){

        //logic of Notification system

        return 'sms Notification';

    }
}
