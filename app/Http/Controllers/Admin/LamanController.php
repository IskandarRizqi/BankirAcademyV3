<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassLamanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LamanController extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = ClassLamanModel::get();
        return view('backend.laman.laman', $data);
    }
    public function create()
    {
        return view('backend.laman.create');
    }
    public function store(Request $request)
    {
        // return $request->all();
        $valid = Validator::make($request->all(), [
            'tgl_tayang' => 'required',
            'tgl_expired' => 'required',
            'title' => 'required',
            'type' => 'required',
            'status' => 'required',
            'content' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_image' => 'required_if:id,null',
            'banner' => 'required_if:id,null',
        ]);
        //response error validation
        if ($valid->fails()) {
            return Redirect::back()->withErrors($valid)->withInput($request->all());
        }

        $slug = Str::slug($request->title);
        $data = [
            'title' => $request->title,
            // 'meta' => $request->,
            // 'og' => $request->,
            'content' => $request->content,
            'slug' => $slug,
            // 'tag' => $request->,
            'tgl_tayang' => $request->tgl_tayang,
            'tgl_expired' => $request->tgl_expired,
            'type' => $request->type,
            'status' => $request->status,
            // 'banner' => $request->,
        ];

        // Data Meta
        $meta = [];
        if ($request->meta_name) {
            if (count($request->meta_name) > 0) {
                for ($i = 0; $i < count($request->meta_name); $i++) {
                    if ($request->meta_name[$i]) {
                        $meta['name'][$i] = $request->meta_name[$i];
                    }
                }
            }
        }
        if ($request->meta_content) {
            if (count($request->meta_content) > 0) {
                for ($i = 0; $i < count($request->meta_content); $i++) {
                    if ($request->meta_content[$i]) {
                        $meta['content'][$i] = $request->meta_content[$i];
                    }
                }
            }
        }
        $data['meta'] = json_encode($meta);
        if ($request->oldsizebanner) {
            $data['banner'] = json_encode(['url' => $request->oldbanner, 'size' => $request->oldsizebanner]);
        }

        // Data Banner
        if ($request->banner) {
            $namebanner = $request->file('banner')->getClientOriginalName();
            $sizebanner = $request->file('banner')->getSize();
            if ($sizebanner >= 1048576) {
                return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB');
            }
            $filename1 = time() . '-' . $namebanner;
            $file = $request->file('banner');
            $file->move(public_path('image/laman/banner'), $filename1);
            $data['banner'] = json_encode(['url' => $filename1, 'size' => $sizebanner]);
        }

        $og = [
            'description' => $request->meta_description,
            'title' => $request->meta_title,
        ];
        if ($request->oldsizemetaimage) {
            $og['image'] = $request->oldmetaimage;
            $og['size'] = $request->oldsizemetaimage;
        }
        // Data Meta Image
        if ($request->meta_image) {
            $namemeta_image = $request->file('meta_image')->getClientOriginalName();
            $sizemeta_image = $request->file('meta_image')->getSize();
            if ($sizemeta_image >= 1048576) {
                return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB');
            }
            $filename2 = time() . '-' . $namemeta_image;
            $file = $request->file('meta_image');
            $file->move(public_path('image/laman/meta_image'), $filename2);
            $og['image'] = $filename2;
            $og['size'] = $sizemeta_image;
        }
        $data['og'] = json_encode($og);

        $l = ClassLamanModel::UpdateOrCreate([
            'id' => $request->id
        ], $data);
        if ($l) {
            return Redirect::to('/admin/laman')->with('message', 'Simpan Data Berhasil');
        }
        return Redirect::back()->with('message', 'Simpan Data Gagal');
    }

    public function edit($id)
    {
        $data = [];
        $l = ClassLamanModel::where('id', $id)->first();
        $data['id'] = $l->id;
        $data['title'] = $l->title;
        $m = json_decode($l->og);
        $me = json_decode($l->meta);
        // $data['meta'] = $l->meta;
        $data['meta_description'] = $m->description;
        $data['meta_title'] = $m->title;
        $data['meta_image'] = $m->image;
        $data['meta_size_image'] = $m->size;
        $data['meta_name'] = $me;
        if (is_object($me)) {
            if (property_exists($me, 'name')) {
                $data['meta_name'] = $me->name;
            }
            if (property_exists($me, 'content')) {
                $data['meta_content'] = $me->content;
            }
        }
        $data['content'] = $l->content;
        $data['slug'] = $l->slug;
        $data['tag'] = $l->tag;
        $data['tgl_tayang'] = $l->tgl_tayang;
        $data['tgl_expired'] = $l->tgl_expired;
        $data['type'] = $l->type;
        $data['status'] = $l->status;
        $b = json_decode($l->banner);
        $data['banner'] = $b->url;
        $data['oldsizebanner'] = $b->size;
        // return $data;
        return Redirect::to('/admin/laman/create')->withInput($data);
    }

    public function destroy($id)
    {
        $d = ClassLamanModel::where('id', $id)->delete();
        if ($d) {
            return Redirect::to('/admin/laman')->with('message', 'Hapus Data Berhasil');
        }
        return Redirect::back()->with('message', 'Hapus Data Gagal');
    }

    public function activated($id, $status)
    {
        $s = 0;
        if ($status == 0) {
            $s = 1;
        }
        $d = ClassLamanModel::where('id', $id)->update(['status' => $s]);
        if ($d) {
            return Redirect::to('/admin/laman')->with('message', 'Ubah Data Berhasil');
        }
        return Redirect::back()->with('message', 'Ubah Data Gagal');
    }
}
