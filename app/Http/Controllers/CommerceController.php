<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Commerce;
use App\Models\Trainees;
use App\Models\Challenge;
use Illuminate\Http\Request;
use App\Models\Commerce_Trainer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommerceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function insertproduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name'=>'required',
            'type'=>'required',
            'price'=>'required',
            'url'=>'required',
            'amount'=>'required'
            ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $product = Commerce::create([
            'product_name'=>$request->product_name,
            'type'=>$request->type,
            'price'=>$request->price,
            'url'=>$request->url,
            'amount'=>$request->amount
        ]);
        return response()->json('successfull', 200);
    }

    public function updatename(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'product_name'=>'required',
            ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $product = Commerce::find($id);

        if ($product) {
            $product->product_name = $request->product_name;
            $product->save();
        }

        return response()->json('successfull', 200);
    }


    public function updateprice(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'price'=>'required',
            ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $product = Commerce::find($id);

        if ($product) {
            $product->price = $request->price;
            $product->save();
        }

        return response()->json('successfull', 200);
    }


    public function updateamount(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'amount'=>'required',
            ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $product = Commerce::find($id);

        if ($product) {
            $product->amount = $request->amount;
            $product->save();
        }

        return response()->json('successfull', 200);
    }

    public function isdiscount()
    {
        $user = User::find(Auth::id());
        $traineer = $user->trainee;
        if($traineer) {
            if($traineer->has_sale != 0) {
                return response()->json(true, 200);
            } else {
                return response()->json(false, 400);
            }
        } else {
            return response()->json('Not Found', 400);
        }
    }

    public function buyproduct(Request $request, $id)
    {

        $user = User::find(Auth::id());
        $acount = $user->wallet;

        $trainee = $user->trainee;

        $product = Commerce::find($id);
        if(!$product) {
            return response()->json('Not Found', 400);
        }

        if($request->discount == 0) {
            if($acount->account<$product->price) {
                return response()->json('you dont have enough balance', 400);
            }
            $acount->account = $acount->account-$product->price;
            $product->amount = $product->amount-1;
            $acount->save();
            $product->save();
            $dis = 0;
        } else {
            if($trainee->has_sale == 0) {
                return response()->json('Sorry, take advantage of the discount only once. You can get new discounts when you win the next competitions');
            }
            $price = $product->price- ($product->price * 0.2);
            if($acount->account<$price) {
                return response()->json('you dont have enough balance', 400);
            }
            $acount->account = $acount->account-$price;
            $product->amount = $product->amount-1;
            $trainee->has_sale=$trainee->has_sale-1;
            $acount->save();
            $product->save();
            $trainee->save();
            $dis = 1;
        }

        $buy = Commerce_Trainer::create([
            'discount'=>$dis,
            'trainees_id'=>$trainee->id,
            'commerce_id'=>$id
        ]);

        if($product->amount == 0) {
            $product->delete();
        }

        return response()->json('successfully', 200);


    }

    public function category($type)
    {

        if(!$type) {
            return response()->json('Not Found');
        }
        $products = Commerce::where('type', $type)->get();
        if(!$products) {
            return response()->json('Not Found');
        }
        return response()->json($products, 200);

    }
}
