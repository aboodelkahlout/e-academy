<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Mime\Message;

class AuthController extends Controller
{
    //
    function login(Request $request){

    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

      $user=User::where('email' , $request->email)->first();

      if ($user) {
        if (Hash::check($request->password , $user->password)) {

            $token = $user->createToken('login');
                return response()->json([
                    'status' => true,
                    'message' => 'log in successfully',
                    'token'=>$token->plainTextToken,
                    'data'=> [
                        'id'=>$user->id,
                        'email'=>$user->email,
                        'name' => $user->name,
                     ]
            ],200);

        }else{
            return response([
                'msg' => 'password incorrect',
            ],401);
        }
      }else{
            return response([
                'msg' => 'email is not valid',
            ],401);
      }

    }

    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'status' => true,
            'data' => $user
        ]);
    }


    public function addtocart(Request $request , $id){

        $user = $request->user();

        if ($user) {

            $cart = cart::where('product_id' , $id)->where('user_id', $user->id)->first();

        if ($cart) {
                $cart->increment('quantity');

                return response()->json([
                    'status'  => true,
                    'message' => 'added successfully in cart plus one',
                    'data' => $cart,
                ]);

            }else{
                $addedcart = cart::create([
                    'product_id' => $id,
                    'user_id' => $user->id,
                    'quantity' =>  1 ,
                ]);

                return response()->json([
                    'status'  => true,
                    'message' => 'added successfully in cart',
                    'data' => $addedcart,
                ]);
            }

        }else{

            return response()->json([
                'status' => false,
                'message' => 'the user is not valid'
            ],401);
        }


    }
}
