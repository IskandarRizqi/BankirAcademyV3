<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ClassesModel;
use App\Models\ClassParticipantModel;
use App\Models\ClassPaymentModel;
use App\Models\ClassPricingModel;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        // $auth = Auth::user()->id;
        // $data['pfl'] = UserProfileModel::where('user_id', Auth::user()->id)->first();
        // $data['payment'] = ClassPaymentModel::where('user_id', $auth)->get();
        // $data['class_id'] = ClassPaymentModel::where('user_id', $auth)->pluck('class_id')->toArray();
        // $data['class'] = ClassesModel::whereIn('id', $data['class_id'])->get();
        // return view('front.profile.profile', $data);
    }
    public function bayar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input2' => 'required',
            'class_id' => 'required',
            'payment_id' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        }
        foreach ($request->input2 as $key => $value) {
            $size = $request->file('input2')[$key]->getSize();
            if (($size / 1024) > 100) {
                return Redirect::back()->withErrors(['input2' => 'Size Maximum 100kb']);
            }
            $gambar = $value->store('order/' . Auth::user()->email . '/' . time());
        }
        $update = ClassPaymentModel::where('id', $request->payment_id)->update(
            [
                'file' => $gambar
            ]
        );
        if ($update) {
            ClassParticipantModel::updateOrCreate(
                [
                    'payment_id' => $request->payment_id,
                    'user_id' => Auth::user()->id
                ],
                [
                    'class_id' => $request->class_id,
                    'user_id' => Auth::user()->id
                ]
            );
            return Redirect::back();
        }
        return Redirect::back();
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
            return Redirect::to('profile');
        }

        // Unique Code
        $number = ClassPaymentModel::select('unique_code')->where('expired', '<', now())->pluck('unique_code')->toArray();
        do {
            $randomNumber = rand(0, 999);
        } while (in_array($randomNumber, $number));
        // No Invoice
        $numbers = ClassPaymentModel::select('no_invoice')->pluck('no_invoice')->toArray();
        do {
            $no_invoice = uniqid();
        } while (in_array($no_invoice, $numbers));

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
            'no_invoice' => $no_invoice,
        ]);
        return Redirect::to('profile');
    }
}
