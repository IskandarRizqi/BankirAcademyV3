<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\InstructorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['data'] = InstructorModel::get();
        return view('backend.instructor.instructor', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'nama' => [
                'required', 'max:255',
            ],
            'title' => 'required',
            'picture' => 'requiredIf:id,null',
            'desc' => 'required',
        ]);
        //response error validation
        if ($valid->fails()) {
            return Redirect::back()->withErrors($valid)->withInput($request->all());
        }

        $d = [
            'name' => $request->nama,
            'title' => $request->title,
            'desc' => $request->desc,
            'user_id' => Auth::user()->id,
        ];

        if ($request->picture) {
            $name = $request->file('picture')->getClientOriginalName(); // Name File
            $size = $request->file('picture')->getSize(); // Size File

            if ($size >= 1048576) {
                return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB');
            }

            $filename = time() . '-' . $name;
            $file = $request->file('picture');
            $file->move(public_path('Image'), $filename);
            $d['picture'] = json_encode(['url' => $filename, 'size' => $size]);
        }

        InstructorModel::updateOrCreate([
            'id' => $request->id
        ], $d);

        return redirect()->back()->with('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        InstructorModel::where('id', $request->id_instructor)->delete();
        return Redirect::back()->with('success');
    }
}
