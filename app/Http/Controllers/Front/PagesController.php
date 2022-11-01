<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    public function getAbout(Request $r)
	{
		$data['about'] = Pages::where('type',1)->first();

		return view('pages/aboutinput',$data);
	}

	public function setAbout(Request $r)
	{
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

		Pages::UpdateOrCreate(['type'=>1],$tobeins);
		return Redirect::back();
	}

	public function showAbout(Request $r)
	{
		$data['about'] = Pages::where('type',1)->first();

		return view('pages/about',$data);
	}
	
    public function getContact(Request $r)
	{
		$data['contact'] = Pages::where('type',2)->first();

		return view('pages/contactinput',$data);
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

		Pages::UpdateOrCreate(['type'=>2],$tobeins);
		return Redirect::back();
	}

	public function showContact(Request $r)
	{
		$data['contact'] = Pages::where('type',2)->first();

		return view('pages/contact',$data);
	}
	
    public function getListBlog(Request $r)
	{
		$data['param']['date_start'] = ($r->param_date_start) ? $r->param_date_start : Carbon::now()->submonth(1)->format('Y-m-d');
		$data['param']['date_end'] = ($r->param_date_end) ? $r->param_date_end : Carbon::now()->format('Y-m-d');

		$data['blog'] = Pages::where('type',0)->whereDate('created_at','>=',$data['param']['date_start'])->whereDate('created_at','<=',$data['param']['date_end'])->get();

		return view('pages/bloglistget',$data);
	}
	
    public function getBlog(Request $r,$id)
	{
		$data['blog'] = Pages::where('id',$id)->first();
		$data['id'] = $id;

		return view('pages/bloginput',$data);
	}
	
    public function delBlog(Request $r,$id)
	{
		$data['blog'] = Pages::where('id',$id)->delete();
		$data['id'] = $id;

		return Redirect::back();
	}

	public function setBlog(Request $r,$id)
	{
		$tobeins = [
			'title' => $r->txtTitle,
			'content' => $r->txaPageBlog,
		];
		if ($r->file('txtThumbnail')) {
			$name = $r->file('txtThumbnail')->getClientOriginalName();
			$size = $r->file('txtThumbnail')->getSize();

			$filename = time() . '-' . $name;
			$file = $r->file('txtThumbnail');
			$file->move(public_path('image/pages'), $filename);

			$tobeins['thumbnail'] = ('/image/pages/' . $filename);
		}

		Pages::UpdateOrCreate(['id'=>$id],$tobeins);
		return Redirect::to('/admin/pages/getbloglist')->with('success','Data Deleted');
	}

	public function showBlog(Request $r,$id)
	{
		$data['blog'] = Pages::where('id',$id)->first();

		return view('pages/blog',$data);
	}

	public function showListBlog(Request $r)
	{
		$data['blog'] = Pages::select('id','title','thumbnail','created_at')->where('type',0)->orderBy('created_at','desc')->paginate(7)->toArray();

		return view('pages/bloglist',$data);
	}
}
