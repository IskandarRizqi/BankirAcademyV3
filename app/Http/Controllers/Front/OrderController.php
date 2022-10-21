<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ClassesModel;
use App\Models\ClassPaymentModel;
use App\Models\ClassPricingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $auth = Auth::user()->id;
        $data['payment'] = ClassPaymentModel::where('user_id', $auth)->get();
        $data['class_id'] = ClassPaymentModel::where('user_id', $auth)->pluck('class_id')->toArray();
        $data['class'] = ClassesModel::whereIn('id', $data['class_id'])->get();
        return view('front.kelas.order', $data);
    }
    public function order_class(Request $request)
    {
        $auth = Auth::user()->id;
        if (!$request->class_id) {
            Redirect::back();
        }
        if (!$auth) {
            Redirect::back();
        }
        $cpm = ClassPaymentModel::where('user_id', $auth)->where('class_id', $request->class_id)->get();
        if (count($cpm) > 0) {
            $data['data'] = ClassPaymentModel::where('user_id', $request->class_id)->get();
            return $this->index();
        }
        $number = ClassPaymentModel::select('unique_code')->where('expired', '>', now())->pluck('unique_code')->toArray();
        do {
            $randomNumber = rand(0, 999);
        } while (in_array($randomNumber, $number));

        $price = 0;
        $price_final = 0;
        $cp = ClassPricingModel::where('class_id', $request->class_id)->first();
        if ($cp) {
            $price = $cp->price - $cp->promo_price;
            $price_final = $price + $randomNumber;
        }

        ClassPaymentModel::create([
            'status' => 0,
            'user_id' => $auth,
            'class_id' => $request->class_id,
            'unique_code' => $randomNumber,
            'price' => $price,
            'price_final' => $price_final,
            'expired' => date('Y-m-d') . ' 23:59:59',
        ]);
        return $this->index();
    }
}
