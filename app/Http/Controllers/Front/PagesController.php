<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ClassLamanModel;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
	public function index()
	{
		$page = [];
		$page['data'] = Pages::get();
		return view('backend.page.page', $page);
	}
	public function edit($id)
	{
		$page = [];
		if ($id) {
			$page['page'] = Pages::where('id', $id)->first();
		}
		// return $page;
		return view('backend.page.edit', $page);
	}
	public function update(Request $r)
	{
		// return $r->all();
		if ($r->type > 0) {
			$validator = Validator::make($r->all(), [
				'type' => 'required|unique:pages,type',
			]);
			if ($validator->fails()) {
				return Redirect::back()->withErrors($validator)->with('error', 'Data Sudah Ada')->withInput($r->all());
			}
		}
		$tobeins = [
			'title' => $r->txtTitle,
			'content' => $r->txaPageAbout,
			'type' => $r->type,
			'description' => $r->description,
			'date_start' => $r->date_start,
			'date_end' => $r->date_end,
		];
		if ($r->file('txtThumbnail')) {
			$name = $r->file('txtThumbnail')->getClientOriginalName();
			$size = $r->file('txtThumbnail')->getSize();

			$filename = time() . '-' . $name;
			$file = $r->file('txtThumbnail');
			$file->move(public_path('image/pages'), $filename);

			$tobeins['thumbnail'] = ('/image/pages/' . $filename);
		}

		Pages::UpdateOrCreate(['id' => $r->id], $tobeins);
		return Redirect::to('admin/pages');
	}
	public function delete(Request $r, $id)
	{
		$p = Pages::where('id', $id)->delete();
		if ($p) {
			return Redirect::back()->with('success', 'Berhasil Hapus');
		}
		return Redirect::back()->with('error', 'Gagal Hapus');
	}
	public function getAbout(Request $r)
	{
		$data['about'] = Pages::where('type', 7)->first();

		return view('pages/aboutinput', $data);
	}

	public function setAbout(Request $r)
	{
		// return $r;
		$tobeins = [
			'title' => $r->txtTitle,
			'content' => $r->txaPageAbout,
		];
		if ($r->file('txtThumbnail')) {
			$name = $r->file('txtThumbnail')->getClientOriginalName();
			$size = $r->file('txtThumbnail')->getSize();

			$filename = time() . '-' . $name;
			$file = $r->file('txtThumbnail');
			$file->move(public_path('image/pages'), $filename);

			$tobeins['thumbnail'] = ('/image/pages/' . $filename);
		}

		$contents = [];
		if ($r->judul) {
			array_push($contents, $r->judul);
		}
		if ($r->content) {
			array_push($contents, $r->content);
		}

		if ($r->judul && $r->content) {
			$tobeins['content'] = json_encode($contents);
		}

		// return $tobeins;
		Pages::UpdateOrCreate(['type' => 7], $tobeins);
		return Redirect::back();
	}

	public function showAbout(Request $r)
	{
		$data['about'] = Pages::where('type', 7)->first();

		return view('pages/about', $data);
	}

	public function getContact(Request $r)
	{
		$data['contact'] = Pages::where('type', 2)->first();

		return view('pages/contactinput', $data);
	}

	public function setContact(Request $r)
	{
		$tobeins = [
			'title' => $r->txtTitle,
			'content' => $r->txaPageContact,
		];
		if ($r->file('txtThumbnail')) {
			$name = $r->file('txtThumbnail')->getClientOriginalName();
			$size = $r->file('txtThumbnail')->getSize();

			$filename = time() . '-' . $name;
			$file = $r->file('txtThumbnail');
			$file->move(public_path('image/pages'), $filename);

			$tobeins['thumbnail'] = ('/image/pages/' . $filename);
		}

		Pages::UpdateOrCreate(['type' => 2], $tobeins);
		return Redirect::back();
	}

	public function showContact(Request $r)
	{
		$data['contact'] = Pages::where('type', 2)->first();

		return view('pages/contact', $data);
	}

	public function getListBlog(Request $r)
	{
		$data['param']['date_start'] = ($r->param_date_start) ? $r->param_date_start : Carbon::now()->submonth(1)->format('Y-m-d');
		$data['param']['date_end'] = ($r->param_date_end) ? $r->param_date_end : Carbon::now()->format('Y-m-d');

		$data['blog'] = Pages::where('type', 0)->whereDate('created_at', '>=', $data['param']['date_start'])->whereDate('created_at', '<=', $data['param']['date_end'])->get();

		return view('pages/bloglistget', $data);
	}

	public function getBlog(Request $r, $id)
	{
		$data['blog'] = Pages::where('id', $id)->first();
		$data['id'] = $id;

		return view('pages/bloginput', $data);
	}

	public function delBlog(Request $r, $id)
	{
		$data['blog'] = Pages::where('id', $id)->delete();
		$data['id'] = $id;

		return Redirect::back();
	}

	public function setBlog(Request $r, $id)
	{
		$tobeins = [
			'title' => $r->txtTitle,
			'content' => $r->txaPageBlog,
			'description' => $r->txtdescription,
			'date_start' => $r->DateStart,
			'date_end' => $r->DateEnd,
		];
		if ($r->file('txtThumbnail')) {
			$name = $r->file('txtThumbnail')->getClientOriginalName();
			$size = $r->file('txtThumbnail')->getSize();

			$filename = time() . '-' . $name;
			$file = $r->file('txtThumbnail');
			$file->move(public_path('image/pages'), $filename);

			$tobeins['thumbnail'] = ('/image/pages/' . $filename);
		}

		Pages::UpdateOrCreate(['id' => $id], $tobeins);
		return Redirect::to('/admin/pages/getbloglist')->with('success', 'Data Tersimpan');
	}

	public function showBlog(Request $r, $id)
	{
		$data['blog'] = Pages::where('id', $id)->first();

		return view('pages/blog', $data);
	}

	public function showListBlog(Request $r)
	{
		$now = Carbon::now();
		$data['blog'] = Pages::select()->where('type', 0)->whereDate('date_start', '<=', $now->format('Y-m-d'))->whereDate('date_end', '>=', $now->format('Y-m-d'))->orderBy('created_at', 'desc')->paginate(7)->toArray();
		return view('pages/bloglist', $data);
	}

	public function getsdank()
	{
		$data['sdank'] = Pages::where('type', 3)->first();

		return view('pages/sdank', $data);
	}

	public function setsdank(Request $r)
	{
		$tobeins = [
			'title' => $r->txtTitle,
			'content' => $r->txaPageSdanK,
		];
		if ($r->file('txtThumbnail')) {
			$name = $r->file('txtThumbnail')->getClientOriginalName();
			$size = $r->file('txtThumbnail')->getSize();

			$filename = time() . '-' . $name;
			$file = $r->file('txtThumbnail');
			$file->move(public_path('image/pages'), $filename);

			$tobeins['thumbnail'] = ('/image/pages/' . $filename);
		}

		Pages::UpdateOrCreate(['type' => 3], $tobeins);
		return Redirect::back();
	}

	public function showsdank()
	{
		$data = [];
		$data['sdank'] = Pages::where('type', 3)->first();
		return view('front.syaratnketentuan', $data);
	}
	public function getPageKelas($id)
	{
		$data['data'] = Pages::where('type', $id)->first();
		$data['tipe'] = $id;

		return view('pages.customkelas', $data);
	}

	public function setPageKelas($tipe, Request $r)
	{
		$tobeins = [
			'title' => $r->txtTitle,
			'content' => $r->txaPageSdanK,
		];
		if ($r->file('txtThumbnail')) {
			$name = $r->file('txtThumbnail')->getClientOriginalName();
			$size = $r->file('txtThumbnail')->getSize();

			$filename = time() . '-' . $name;
			$file = $r->file('txtThumbnail');
			$file->move(public_path('image/pages'), $filename);

			$tobeins['thumbnail'] = ('/image/pages/' . $filename);
		}

		Pages::UpdateOrCreate(['type' => $tipe], $tobeins);
		return Redirect::back();
	}

	public function showKelas($id)
	{
		$data = [];
		$data['data'] = Pages::where('type', $id)->first();
		return view('front.customKelas', $data);
	}
}
