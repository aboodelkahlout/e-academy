<?php

namespace App\Http\Controllers;

use App\Models\cart_item;
use App\Models\category;
use App\Models\course;
use App\Models\order;
use App\Models\order_item;
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
use Termwind\Components\Dd;

class SiteController extends Controller
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


        $avilabletime=teacher_schedule::where('teacher_id',$id)->get();


      $events  =  $avilabletime->map(function($data){
      return [
                'title' =>  $data->start_time .'-' . $data->end_time ,
                'start' => $data->date,
                'url' => url('/'),
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

       $cart_item = cart_item::where('user_id' , $user_id)->where('course_id',$course->id)->exists();

      $count = cart_item::where('user_id', $user_id)->count();



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



     function paymentaction(){

      $user_id     = Auth::user()->id ;

      $cart_items  = cart_item::with('course')->where('user_id', $user_id)->get();


      $order       = order::where('user_id',$user_id)->where('status','pending')->first();

      $total_amount = 0 ;

       foreach ($cart_items as $cart_item) {
            $total_amount += $cart_item->course->price;
        }

      if (!$order) {

        $order = order::create([
            'user_id' => $user_id,
            'total_amount' => $total_amount,
            'status' => 'pending'
        ]);


      }else{

      $order->update([
        'total_amount' => $total_amount,
      ]);

      foreach ($order->order_item as $order_items) {
        $order_items->delete();
      }

      }

        foreach ($cart_items as $cart_item) {
            order_item::create([
                'order_id'  => $order->id,
                'course_id' => $cart_item->course->id,
                'price'     => $cart_item->course->price
            ]);
        }




      return redirect()->route('site.payment');
    }



    function  payment(){

        $user_id = Auth::user()->id;

        $user_order = order::where('user_id',$user_id)->first();

        $order_items = order_item::where('order_id' , $user_order->id)->get();

        $url = "https://eu-test.oppwa.com/v1/checkouts";
	$data = "entityId=8a8294174d0595bb014d05d829cb01cd" .
                "&amount=". $user_order->price .
                "&currency=USD" .
                "&paymentType=DB" ;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                   'Authorization: Bearer OGE4Mjk0MTc0ZDA1OTViYjAxNGQwNWQ4MjllNzAxZDF8OVRuSlBjMm45aA=='));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$responseData = curl_exec($ch);
	if(curl_errno($ch)) {
		return curl_error($ch);
	}
	curl_close($ch);

    $responseData = json_decode($responseData, true);

    $id = $responseData['id'];

     return view('site.payment' ,compact('id'));
    }


    function payaction(Request $request){

    $id = $request->id;


   $url = "https://eu-test.oppwa.com/v1/checkouts/{$id}/payment";
	$url .= "?entityId=8a8294174d0595bb014d05d829cb01cd";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                   'Authorization: Bearer OGE4Mjk0MTc0ZDA1OTViYjAxNGQwNWQ4MjllNzAxZDF8OVRuSlBjMm45aA=='));
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$responseData = curl_exec($ch);
	if(curl_errno($ch)) {
		return curl_error($ch);
	}
	curl_close($ch);

    $responseData = json_decode($responseData ,true);

    dd($responseData);


    }


}
