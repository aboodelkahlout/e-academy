<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage;
use App\Models\appointment;
use App\Models\cart_item;
use App\Models\category;
use App\Models\contact;
use App\Models\course;
use App\Models\CourseStudent;
use App\Models\order_item;
use App\Models\order;
use App\Models\payment;
use App\Models\teacher_schedule;
use App\Models\teacher;
use App\Models\User;
use App\NotificationInterface;
use App\PaymentInterface;
use App\Payments\PaypalService;
use App\Payments\StripeService;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;
use Stripe\Product;
use Stripe\Stripe;

class   SiteController extends Controller
{
    //


        function  welcome(){

           $stu = User::where('role','student')->get();
            return view('site.welcome',compact('stu'));
    }

        function courses(){

        $cate=category::withCount('courses')->get();
        $courses=course::with('teacher','students')->paginate(3);
        $stu=user::where('role','student')->get();


        return view('site.courses',compact('cate','courses','stu'));

    }

        function ourteachers(){

            $teachers=teacher::all();
            return view('site.ourteachers',compact('teachers'));
    }

    function teacherdetails($id){



        $teacher=teacher::findOrFail($id);

        $courses=course::where('teacher_id' , $id)->get();


        $avilabletime=teacher_schedule::where('teacher_id',$id)->where('is_available', 1)->get();


      $events  =  $avilabletime->map(function($data){
      return [
                'title' =>  $data->start_time .'-' . $data->end_time ,
                'start' => $data->date,
                'url' => url('site/payment/' .$data->id),
                ];
        })->toArray();


        return view('site.teacherdetails',compact('teacher','courses','events'));
    }


    function paypallpayment(PaymentInterface $payment){

    $price=50;

    $result = $payment->pay($price);

    return $result;

      }


      function Notification(NotificationInterface $notification){

        $message='your sign in this course';

        $result=$notification->Notification($message);

        return $result;
      }

      function coursedetails($id){


       $course=course::find($id);


       return view('site.coursedetails',compact('course'));

      }

      function addtocart($id){

       $course =  course::find($id);

       $user_id   = Auth::user()->id;


       $cart_item = cart_item::where('user_id' , $user_id)->where('course_id',$id)->exists();

       $count = cart_item::where('user_id', $user_id)->count();

       $course_stu = CourseStudent::where('student_id', $user_id)->where('course_id', $course->id)->exists();

            if ($course_stu) {
                return response()->json([
                    'success' => false,
                    'msg' => 'you have already enrolled in this course',
                    'type' => 'error',
                    'count' => $count
                ]);
            }


       if ($user_id && $course->id)
        {

            if (!$cart_item)
            {

                cart_item::create([

                'user_id'=>$user_id,

                'course_id'=>$course->id,

                ]);



                return response()->json([
                    'success'=>true,
                    'msg'=>'added to cart successfully',
                    'type'=> 'success',
                    'count' => $count
                ]);

            }
            else
               {

               return response()->json([
                    'success'=>false,
                    'msg'=>'this course has been added',
                    'type'=> 'error',
                    'count' => $count
                ]);


               }
       }
          else{
          return response()->json([
                    'success'=>false,
                    'msg'=>'you have to sign in to do it',
                    'type'=> 'error',
                    'count' => $count
                ]);
       }


    }


    function showcart(){

        $user_id = Auth::user()->id;

        $cart_items = cart_item::where('user_id',$user_id)->get();

        $total = 0 ;
        foreach ($cart_items as $key => $value) {
           $total  +=  $value->course->price ;
        }



        return view('site.cart',compact('cart_items','total'));

    }

    function checkout(){

        $user_id = Auth::user()->id;

        $cart_items=cart_item::where('user_id',$user_id)->get();

        $total = 0 ;

        foreach ($cart_items as $cart_item) {

        $total += $cart_item->course->price;

        }


        return view('site.checkout',compact('cart_items','total'));
    }




      function paymentconfirmpage(){

      $user_id = Auth::id();

      $cart_items   = cart_item::with('course')->where('user_id', $user_id)->get();

      $order        = order::where('user_id', $user_id)->where('status','pending')->latest()->first();

      $total_amount = 0;



      if ($cart_items->isEmpty()) {
          return redirect()->route('site.showcart');
        }

        foreach ($cart_items as $cart_item) {

            $total_amount += $cart_item->course->price;

        }

        if (!$order) {

        /*
        |----------------------------------------
        | Create New Order Every Payment Attempt
        |----------------------------------------
        */

        $order = order::create([
            'user_id'      => $user_id,
            'total_amount' => $total_amount,
            'status'       => 'pending'
        ]);


    }else{

        $order->update([
         'total_amount' => $total_amount,
        ]);

        order_item::where('order_id', $order->id)->delete();

        }


        /*
        |----------------------------------------
        | Create Order Items
        |----------------------------------------
        */

        foreach ($cart_items as $cart_item) {

            order_item::create([
                'order_id'  => $order->id,
                'course_id' => $cart_item->course->id,
                'price'     => $cart_item->course->price
            ]);
        }





    /*
    |----------------------------------------
    | Kashier Payment Data
    |----------------------------------------
    */

    $merchantId = env('KASHIER_MID');

    $paymentKey = env('KASHIER_PAYMENT_KEY');

    $order_id = $order->id;

    $amount = $total_amount;

    $currency = "EGP";

    $path = "/?payment="
        . $merchantId . "."
        . $order_id . "."
        . $amount . "."
        . $currency;

    $hash = hash_hmac(
        'sha256',
        $path,
        $paymentKey
    );

    /*
    |----------------------------------------
    | Payment URL
    |----------------------------------------
    */




    $paymentUrl = "https://checkout.kashier.io/?merchantId={$merchantId}"
        . "&mode=test"
        . "&orderId={$order_id}"
        . "&amount={$amount}"
        . "&currency={$currency}"
        . "&hash={$hash}"
        . "&allowedPaymentMethods=card"
        . "&merchantRedirect="
        . urlencode(
            route('site.payment.callback', [
                'order_id' => $order->id
            ])
        );


        payment::create([
            'user_id' => $user_id,
            'order_id' => $order->id,
            'currency' => $currency,
            'amount' => $total_amount,
            'status' => 'pending',
            'payment_method' => 'kashier',
            'transaction_id' => null,
            'payment_reference'=> $order->id.'.'.time()
        ]);


    return redirect()->away($paymentUrl);
    }





   public function showpaymentpage(){

      return view('site.payment');

    }


    function paymentCallback(Request $request){

        $user_id = Auth::id();

            $order = order::where('user_id', $user_id)
                ->where('status', 'pending')
                ->latest()
                ->first();

            $payment = payment::where('order_id', $order->id)->first();

            if (!$order) {
                return redirect()->route('site.checkout');
            }

            /*
            |----------------------------------------
            | Check Payment Status
            |----------------------------------------
            */


            if ($request->paymentStatus == 'serverError') {

                 $payment->update([
                'status' => 'paid',
                'payment_method' => 'kashier',
                'transaction_id' => $request->transactionId,
                'payment_reference'=> $order->id.'.'.time()
            ]);



               foreach ($order->order_item as $item) {
                CourseStudent::create([
                    'student_id' => $order->user_id,
                    'course_id'  => $item->course_id
                ]);
               }

               $order->update([
                'status' => 'paid'
               ]);

                cart_item::where('user_id', $user_id)->delete();

                return redirect()->route('site.courses');
            }

            $order->update([
                'status' => 'failed'
            ]);

             $payment->update([
                'status' => 'failed',
                'payment_method' => 'kashier',
                'transaction_id' => $request->transactionId,
                'payment_reference'=> $order->id.'.'.time()
            ]);

            return redirect()->route('site.checkout');
    }



    function deletecart($id){

     $cart_item =cart_item::find($id);

     $user_id = Auth::id();

     $cart_item->delete();

     $count = cart_item::where('user_id', $user_id)->count();

     return response()->json([
        'success' =>true,
        'msg' => 'course removed from cart successfully',
        'type' => 'success',
        'count' => $count
        ]);

    }



    function contact(){
        return view('site.contact');
    }


    function contactus(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        $data=$request->all();

        Mail::to('e-academy@gmail.com')->send(new ContactMessage($data));


        return redirect()->back()->with('msg', 'Thank you for contacting us! We will get back to you soon.')->with('type', 'success');
    }


    function about(){
        return view('site.about');
    }

    function payment($id){

        $schedule = teacher_schedule::findOrFail($id);


        return view('site.payment',compact('schedule'));
    }


    function confirmappointment($id){

            $schedule = teacher_schedule::findOrFail($id);

            $appointment = appointment::create([
            'user_id' => auth()->id(),
            'teacher_id' => $schedule->teacher_id,
            'schedule_id' => $schedule->id,
            'status' => 'pending'
        ]);


    $merchantId = env('KASHIER_MID');

    $paymentKey = env('KASHIER_PAYMENT_KEY');


    $amount = $schedule->price;

    $currency = "EGP";

    $path = "/?payment="
        . $merchantId . "."
        . $appointment->id . "."
        . $amount . "."
        . $currency;

    $hash = hash_hmac(
        'sha256',
        $path,
        $paymentKey
    );

    /*
    |----------------------------------------
    | Payment URL
    |----------------------------------------
    */




    $paymentUrl = "https://checkout.kashier.io/?merchantId={$merchantId}"
        . "&mode=test"
        . "&amount={$amount}"
        . "&orderId={$appointment->id}"
        . "&currency={$currency}"
        . "&hash={$hash}"
        . "&allowedPaymentMethods=card"
        . "&merchantRedirect="
        . urlencode(
            route('site.payment.appointment.callback', [
                'teacher_schedule_id' => $id
            ])
        );

    return redirect()->away($paymentUrl);


    }

    function appointmentPaymentCallback(Request $request){

        $user = Auth::user()->id;

        $appointment = appointment::where('user_id', $user)
            ->where('status', 'pending')
            ->latest()
            ->first();




       $schedule = teacher_schedule::findOrFail($appointment->schedule_id);

        if ($request->paymentStatus == 'serverError') {

            $appointment->update([
                'status' => 'accepted'
            ]);

            $schedule->update([
                'is_available' => 0
            ]);

            return redirect()->route('site.ourteachers')->with('msg', 'Your appointment has been booked successfully!')->with('type', 'success');
        }

        $appointment->update([
            'status' => 'cancelled'
        ]);


        return redirect()->route('site.ourteachers')->with('msg', 'Payment failed. Please try again.')->with('type', 'error');
    }

}










