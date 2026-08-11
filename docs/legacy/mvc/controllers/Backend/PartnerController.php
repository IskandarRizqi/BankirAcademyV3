<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ClassPartnerModel;
use COM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PartnerController extends Controller
{
    public function index()
    {
        $data['data'] = ClassPartnerModel::get();
        return view('backend.partner.partner', $data);
    }

    public function input_partner(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'link' => 'required',
            'picture' => 'requiredIf:id,null',
        ]);
        //response error validation
        if ($valid->fails()) {
            return Redirect::back()->withErrors($valid)->withInput($request->all());
        }

        $d = [
            'link' => $request->link,
        ];

        if ($request->picture) {
            $name = $request->file('picture')->getClientOriginalName(); // Name File
            $size = $request->file('picture')->getSize(); // Size File

            if ($size >= 1048576) {
                return Redirect::back()->withErrors('error', 'Ukuran File Melebihi 1 MB');
            }

            $filename = time() . '-' . $name;
            $file = $request->file('picture');
            $file->move(public_path('Image/Partner/'), $filename);
            $d['image'] = json_encode(['url' => $filename, 'size' => $size]);
        }

        ClassPartnerModel::updateOrCreate([
            'id' => $request->id
        ], $d);

        return redirect()->back()->with('success');
    }

    public function delete_partner(Request $request)
    {
        if ($request->id_partner) {
            ClassPartnerModel::where('id', $request->id_partner)->delete();
            return redirect()->back()->with('success', 'Data Terhapus');
        }
        return redirect()->back()->with('error', 'Tidak Ditemukan');
    }
}
