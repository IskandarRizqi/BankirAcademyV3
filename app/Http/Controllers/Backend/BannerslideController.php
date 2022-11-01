<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BannerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BannerslideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['banner'] = BannerModel::get();
        return view('backend.bannerslide.slide', $data);
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
        $validator = Validator::make($request->all(), [
            'banner' => 'image|mimes:jpeg,png,jpg|max:2048|required',
            'judul' => 'required',
            'jenis' => 'required',
            'mulai_aktif' => 'required',
            'akhir_aktif' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        $name = $request->file('banner')->getClientOriginalName();
        $filename = time() . '-' . $name;
        $file = $request->file('banner');
        $file->move(public_path('Image'), $filename);


        BannerModel::create([
            'nama' => $request->judul,
            'jenis' => $request->jenis,
            'mulai' => $request->mulai_aktif,
            'selesai' => $request->akhir_aktif,
            'image' => $filename,
        ]);

        return redirect('/admin/banner')->with('success', 'Created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return BannerModel::where('id', $id)->first();
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
    public function destroy($id)
    {
        BannerModel::where('id', $id)->delete();
        return redirect('/admin/banner');
    }


    public function updatebanner(Request $request)
    {
        if ($request->hasFile('banner')) {
            $validator = Validator::make($request->all(), [
                'banner' => 'image|mimes:jpeg,png,jpg|max:2048|required',
                'judul' => 'required',
                'jenis' => 'required',
                'mulai_aktif' => 'required',
                'akhir_aktif' => 'required',
            ]);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            }

            // $data = Avatar::find($id);
            // $image_path = public_path().'/'.$data->filename;
            // unlink($image_path);

            $img = BannerModel::where('id', $request->id)->first();
            $image_path = public_path() . '/Image/' . $img['image'];
            unlink($image_path);
            // return $image_path;
            $name = $request->file('banner')->getClientOriginalName();
            $filename = time() . '-' . $name;
            $file = $request->file('banner');
            $file->move(public_path('Image'), $filename);

            // $cdl = GlobalHelper::cloudinarys();
            // $cdl->uploadApi()->destroy($request->urlbanner);

            // $image  = $request->file('banner')->getPathname();
            // $cloudinary = $cdl->uploadApi()->upload($image, ['folder' => 'PROJECT ORDER/' . 'banner/']);
            // $logo_url = $cloudinary['secure_url'];

            BannerModel::where('id', $request->id)->update([
                'nama' => $request->judul,
                'jenis' => $request->jenis,
                'mulai' => $request->mulai_aktif,
                'selesai' => $request->akhir_aktif,
                'image' => $filename,

            ]);
            return redirect('/admin/banner')->with('success', 'Update successfully!');
        } else {
            $validator = Validator::make($request->all(), [
                'judul' => 'required',
                'jenis' => 'required',
                'mulai_aktif' => 'required',
                'akhir_aktif' => 'required',
            ]);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            }
            BannerModel::where('id', $request->id)->update([
                'nama' => $request->judul,
                'jenis' => $request->jenis,
                'mulai' => $request->mulai_aktif,
                'selesai' => $request->akhir_aktif,
            ]);

            return redirect('/admin/banner')->with('success', 'Update successfully!');
        }
    }
}
