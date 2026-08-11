<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstructorModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class InstructorController extends Controller
{
    public function index()
    {
        return view('backend.instructor.instructor', [
            'data' => InstructorModel::get(),
        ]);
    }

    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'nama' => ['required', 'max:255'],
            'title' => 'required',
            'picture' => 'requiredIf:id,null',
            'desc' => 'required',
        ]);

        if ($valid->fails()) {
            return Redirect::back()->withErrors($valid)->withInput($request->all());
        }

        $data = [
            'name' => $request->nama,
            'title' => $request->title,
            'desc' => $request->desc,
            'status' => 1,
        ];

        if ($request->picture) {
            $name = $request->file('picture')->getClientOriginalName();
            $size = $request->file('picture')->getSize();
            if ($size >= 1048576) {
                return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB');
            }

            $filename = time().'-'.$name;
            $request->file('picture')->move(public_path('Image'), $filename);
            $data['picture'] = json_encode(['url' => $filename, 'size' => $size]);
        }

        InstructorModel::updateOrCreate(['id' => $request->id], $data);

        return redirect()->back()->with('success', 'Data Tersimpan');
    }

    public function show($id, Request $request)
    {
        $status = $request->id_instructor_status == 1 ? 0 : 1;
        $updated = InstructorModel::where('id', $request->id_instructor_show)
            ->update(['status' => $status]);

        if ($updated) {
            return Redirect::back()->with('success', 'Data Berhasil Aktif');
        }

        return Redirect::back()->with('error', 'Data Gagal Aktif');
    }

    public function destroy($id, Request $request)
    {
        InstructorModel::where('id', $request->id_instructor)->delete();

        return Redirect::back()->with('success');
    }

    public function logininstructor(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => 3,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user = User::updateOrCreate(['id' => $request->idUser], $data);
        if ($user) {
            InstructorModel::where('id', $request->idIntructor)
                ->update(['user_id' => $user->id]);

            return Redirect::back()->with('success', 'Data Berhasil Tersimpan');
        }

        return Redirect::back()->with('error', 'Data Gagal Tersimpan');
    }
}
