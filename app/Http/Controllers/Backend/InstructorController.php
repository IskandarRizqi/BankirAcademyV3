<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ClassesModel;
use App\Models\InstructorModel;
use App\Models\User;
use App\Models\UserProfileModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InstructorController extends Controller
{
    public function index()
    {
        $data['data'] = InstructorModel::get();
        // return $data;
        return view('backend.instructor.instructor', $data);
    }

    public function create()
    {
        //
    }

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
            'status' => 1,
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

        return redirect()->back()->with('success', 'Data Tersimpan');
    }

    public function show($id, Request $request)
    {
        // return $request->all();
        // Aktif atau non aktif Intructor
        $id_instructor_status = 1;
        if ($request->id_instructor_status == 1) {
            $id_instructor_status = 0;
        }
        $i = InstructorModel::where('id', $request->id_instructor_show)->update(['status' => $id_instructor_status]);
        if ($i) {
            return Redirect::back()->with('success', 'Data Berhasil Aktif');
        }
        return Redirect::back()->with('error', 'Data Gagal Aktif');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id, Request $request)
    {
        InstructorModel::where('id', $request->id_instructor)->delete();
        return Redirect::back()->with('success');
    }

    public function logininstructor(Request $request)
    {
        $data =  [
            'name' => $request->name,
            'email' => $request->email,
            'role' => 3,
        ];
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        $s = User::updateOrCreate([
            'id' => $request->idUser
        ], $data);
        if ($s) {
            InstructorModel::where('id', $request->idIntructor)->update(['user_id' => $s->id]);
            return Redirect::back()->with('success', 'Data Berhasil Tersimpan');
        }
        return Redirect::back()->with('error', 'Data Gagal Tersimpan');
    }

    public function profile()
    {
        $data = [];
        $data['data'] = InstructorModel::where('user_id', Auth::user()->id)->first();
        // return $data;
        return view('backend.instructor.profile', $data);
    }

    public function profileUpdate(Request $request)
    {
        // return $request->all();
        $valid = Validator::make($request->all(), [
            'nama' => [
                'required', 'max:255',
            ],
            'title' => 'required',
            'nohp' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
        ]);
        //response error validation
        if ($valid->fails()) {
            return Redirect::back()->withErrors($valid)->withInput($request->all());
        }

        $d = [
            'name' => $request->nama,
            'title' => $request->title,
            'desc' => $request->deskripsi,
            'alamat' => $request->alamat,
            'nohp' => $request->nohp,
            'status' => 1,
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
        if ($request->dokumen) {
            $dokumen = $request->file('dokumen')->getSize();
            if (($dokumen / 1024) > 1000) {
                return Redirect::back()->with('error', 'Size Maximum 1 Mb');
            }
            $d['dokumen'] = json_encode(['url' => $request->file('dokumen')->store('instructor/' . $request->nama . '/' . time()), 'size' => $dokumen]);
        }

        InstructorModel::updateOrCreate([
            'id' => $request->id
        ], $d);

        return redirect()->back()->with('success', 'Data Tersimpan');
    }

    public function classes(Request $r)
    {
        $data = [];
        $ins = InstructorModel::where('user_id', Auth::user()->id)->first();

        //Param
        $data['param'] = [];
        $data['param']['date_start'] = ($r->param_date_start) ? $r->param_date_start : Carbon::now()->format('Y-m-d');
        $data['param']['date_end'] = ($r->param_date_end) ? $r->param_date_end : Carbon::now()->addmonth()->format('Y-m-d');
        $data['param']['category'] = ($r->param_category) ? $r->param_category : null;

        //Classes
        $data['classes'] = ClassesModel::where(function ($q) use ($data) {
            $q->whereBetween('date_start', [$data['param']['date_start'], $data['param']['date_end']])->orWhereBetween('date_end', [$data['param']['date_start'], $data['param']['date_end']]);
            if ($data['param']['category']) {
                $q->where('category', $data['param']['category']);
            }
        })
            ->where('instructor', 'like', '%"' . $ins->id . '"%')
            ->get();

        //Additional
        $data['category'] = ClassesModel::select('category')->distinct('category')->pluck('category')->toArray();
        $data['instructor'] = InstructorModel::get();

        // return $data;
        return view('backend.instructor.class.classess', $data);
    }

    public function classesCreate($id)
    {
        $data = [];
        if ($id !== 'null') {
            $c = ClassesModel::where('id', $id)->first();
            $data['old']['id'] = $c->id;
            $data['old']['txtClassesTitle'] = $c->title;
            $data['old']['slcClassesCategory'] = $c->category;
            $data['old']['slcClassesType'] = $c->tipe;
            $data['old']['datClassesDateStart'] = $c->date_start;
            $data['old']['datClassesDateEnd'] = $c->date_end;
            $data['old']['tags'] = json_decode($c->tags);
            $data['old']['filClassesImage'] = $c->image;
            $data['old']['filClassesImageMobile'] = $c->image_mobile;
            $data['old']['numClassesLimit'] = $c->participant_limit;
            $data['old']['txaClassesContent'] = $c->content;
        }
        $data['category'] = ClassesModel::select('category')->distinct('category')->pluck('category')->toArray();
        $data['instructor'] = InstructorModel::where('user_id', Auth::user()->id)->get();
        $tags = ClassesModel::select('tags')->distinct('tags')->pluck('tags')->toArray();
        $data['tags'] = [];
        foreach ($tags as $key => $value) {
            if ($value) {
                $js = json_decode($value);
                if ($js) {
                    foreach ($js as $key => $v) {
                        if (!in_array($v, $data['tags'])) {
                            array_push($data['tags'], $v);
                        }
                    }
                }
            }
        }
        // return $data;
        return view('backend.instructor.class.classcreate', $data);
    }

    public function classesStore(Request $r)
    {
        // return $r->all();
        if (!$r->id && !$r->filClassesImage) {
            return Redirect::back()->with('error', 'Gambar Tidak Ditemukan')->withInput($r->all());
        }
        if (!$r->id && !$r->filClassesImageMobile) {
            return Redirect::back()->with('error', 'Gambar Tidak Ditemukan')->withInput($r->all());
        }

        $input = [
            'title' => $r->txtClassesTitle,
            'instructor' => json_encode($r->txtClassesInstructor),
            'category' => $r->slcClassesCategory,
            'tags' => json_encode($r->slcClassesTags),
            // 'image' => ('/image/classes/' . $filename),
            // 'image_mobile' => ('/image/classes/' . $filenameMobile),
            'content' => $r->txaClassesContent,
            'unique_id' => uniqid(),
            'participant_limit' => $r->numClassesLimit,
            'date_start' => $r->datClassesDateStart,
            'date_end' => $r->datClassesDateEnd,
            'tipe' => $r->slcClassesType,
            'level' => $r->slcClassesLevel,
        ];
        if ($r->filClassesImageMobile) {
            $nameMobile = $r->file('filClassesImageMobile')->getClientOriginalName();
            $sizeMobile = $r->file('filClassesImageMobile')->getSize();

            if ($sizeMobile >= 1048576) {
                return Redirect::back()->with('error', 'Ukuran File Mobile Melebihi 1 MB')->withInput($r->all());
            }

            $filenameMobile = time() . '-' . $nameMobile;
            $fileMobile = $r->file('filClassesImageMobile');
            $fileMobile->move(public_path('image/classes'), $filenameMobile);
            $input['image_mobile'] = '/image/classes/' . $filenameMobile;
        }
        if ($r->filClassesImage) {
            $name = $r->file('filClassesImage')->getClientOriginalName();
            $size = $r->file('filClassesImage')->getSize();

            if ($size >= 1048576) {
                return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB')->withInput($r->all());
            }

            $filename = time() . '-' . $name;
            $file = $r->file('filClassesImage');
            $file->move(public_path('image/classes'), $filename);
            $input['image'] = '/image/classes/' . $filename;
        }

        ClassesModel::updateOrCreate([
            'id' => $r->id
        ], $input);

        return Redirect::back()->with('success', 'Class Saved');
    }
}
