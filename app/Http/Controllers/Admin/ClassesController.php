<?php

namespace App\Http\Controllers\Admin;

use App\Helper\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Models\BannerModel;
use App\Models\BiayaSertifikatModel;
use App\Models\ClassesModel;
use App\Models\ClassCertificateTemplate;
use App\Models\ClassPricingModel;
use App\Models\ClassParticipantModel;
use App\Models\ClassContentModel;
use App\Models\ClassEventModel;
use App\Models\InstructorModel;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use PDF;

class ClassesController extends Controller
{
	public function index(Request $r)
	{
		$data = [];

		//Param
		$data['param'] = [];
		$data['param']['date_start'] = ($r->param_date_start) ? $r->param_date_start : Carbon::now()->format('Y-m-d');
		$data['param']['date_end'] = ($r->param_date_end) ? $r->param_date_end : Carbon::now()->addmonth()->format('Y-m-d');
		$data['param']['category'] = ($r->param_category) ? $r->param_category : null;

		//Classes
		$data['classes'] = ClassesModel::select('classes.*', 'biaya_sertifikat.type as tipebs', 'biaya_sertifikat.nominal')
			->where(function ($q) use ($data) {
				$q->whereBetween('date_start', [$data['param']['date_start'], $data['param']['date_end']])->orWhereBetween('date_end', [$data['param']['date_start'], $data['param']['date_end']]);
				if ($data['param']['category']) {
					$q->where('category', $data['param']['category']);
				}
			})
			->leftJoin('biaya_sertifikat', 'biaya_sertifikat.class_id', 'classes.id')
			->get();

		//Additional
		$data['category'] = ClassesModel::select('category')->distinct('category')->pluck('category')->toArray();
		$data['instructor'] = InstructorModel::get();

		// return $data;
		return view('backend/classes/classes', $data);
	}

	public function create(Request $r)
	{
		$data['category'] = ClassesModel::select('category')->distinct('category')->pluck('category')->toArray();
		$data['instructor'] = InstructorModel::get();
		$subcategory = ClassesModel::select('sub_category')->distinct('sub_category')->pluck('sub_category')->toArray();
		$data['subcategory'] = [];
		foreach ($subcategory as $key => $value) {
			if ($value) {
				$js = json_decode($value);
				if ($js) {
					foreach ($js as $key => $v) {
						if (!in_array($v, $data['subcategory'])) {
							array_push($data['subcategory'], $v);
						}
					}
				}
			}
		}
		$tags = ClassesModel::select('tags')->distinct('tags')->pluck('tags')->toArray();
		$data['tags'] = [];
		foreach ($tags as $key => $value) {
			if ($value) {
				$js = json_decode($value);
				if ($js) {
					foreach ($js as $key => $va) {
						if (!in_array($va, $data['tags'])) {
							array_push($data['tags'], $va);
						}
					}
				}
			}
		}
		return view('backend/classes/inputclasses', $data);
	}

	public function store(Request $r)
	{
		$status = 0;
		if (Auth::user()->role == 0) {
			$status = 1;
		}
		// Data Meta
		$meta = [];
		if ($r->meta_name) {
			if (count($r->meta_name) > 0) {
				for ($i = 0; $i < count($r->meta_name); $i++) {
					if ($r->meta_name[$i]) {
						$meta['name'][$i] = $r->meta_name[$i];
					}
				}
			}
		}
		if ($r->meta_content) {
			if (count($r->meta_content) > 0) {
				for ($i = 0; $i < count($r->meta_content); $i++) {
					if ($r->meta_content[$i]) {
						$meta['content'][$i] = $r->meta_content[$i];
					}
				}
			}
		}
		// $data['meta'] = json_encode($meta);

		$og = [
			'description' => $r->meta_description,
			'title' => $r->meta_title,
		];
		// Data Meta Image
		if ($r->meta_image) {
			$namemeta_image = $r->file('meta_image')->getClientOriginalName();
			$sizemeta_image = $r->file('meta_image')->getSize();
			if ($sizemeta_image >= 1048576) {
				return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB');
			}
			$filename2 = time() . '-' . $namemeta_image;
			$file = $r->file('meta_image');
			$file->move(public_path('image/laman/meta_image'), $filename2);
			$og['image'] = $filename2;
			$og['size'] = $sizemeta_image;
		}
		// $data['og'] = json_encode($og);

		$nameMobile = $r->file('filClassesImageMobile')->getClientOriginalName();
		$sizeMobile = $r->file('filClassesImageMobile')->getSize();
		$name = $r->file('filClassesImage')->getClientOriginalName();
		$size = $r->file('filClassesImage')->getSize();

		if ($size >= 1048576) {
			return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB');
		}
		if ($sizeMobile >= 1048576) {
			return Redirect::back()->with('error', 'Ukuran File Mobile Melebihi 1 MB');
		}

		$filename = time() . '-' . $name;
		$file = $r->file('filClassesImage');
		$file->move(public_path('image/classes'), $filename);
		$filenameMobile = time() . '-' . $nameMobile;
		$fileMobile = $r->file('filClassesImageMobile');
		$fileMobile->move(public_path('image/classes'), $filenameMobile);


		ClassesModel::create([
			'title' => $r->txtClassesTitle,
			'instructor' => json_encode($r->txtClassesInstructor),
			'category' => $r->slcClassesCategory,
			'tags' => json_encode($r->slcClassesTags),
			'image' => ('/image/classes/' . $filename),
			'image_mobile' => ('/image/classes/' . $filenameMobile),
			'content' => $r->txaClassesContent,
			'unique_id' => uniqid(),
			'participant_limit' => $r->numClassesLimit,
			'date_start' => $r->datClassesDateStart,
			'date_end' => $r->datClassesDateEnd,
			'tipe' => json_encode($r->slcClassesType),
			'level' => $r->slcClassesLevel,
			'jenis' => json_encode($r->slcClassesJenis),
			'og' => json_encode($og),
			'meta' => json_encode($meta),
			'status' => $status,
			'sub_category' => json_encode($r->subCategory),
			'poin' => $r->numClassesPoin ? $r->numClassesPoin : 0,
		]);

		return redirect('/admin/classes')->with('success', 'Class Saved');
	}


	public function edit(Request $r, $id)
	{
		$data['id'] = $id;
		$data['classes'] = ClassesModel::where('id', $id)->first();
		$data['category'] = ClassesModel::select('category')->distinct('category')->pluck('category')->toArray();
		$subcategory = ClassesModel::select('sub_category')->distinct('sub_category')->pluck('sub_category')->toArray();
		$data['instructor'] = InstructorModel::get();
		$data['subcategory'] = [];
		foreach ($subcategory as $key => $value) {
			if ($value) {
				$js = json_decode($value);
				if ($js) {
					foreach ($js as $key => $v) {
						if (!in_array($v, $data['subcategory'])) {
							array_push($data['subcategory'], $v);
						}
					}
				}
			}
		}
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
		return view('backend/classes/editclasses', $data);
	}

	public function update(Request $r, $id)
	{
		$status = 0;
		if (Auth::user()->role == 0) {
			$status = 1;
		}
		$tobeins = [
			'title' => $r->txtClassesTitle,
			'instructor' => json_encode($r->txtClassesInstructor),
			'category' => $r->slcClassesCategory,
			'tags' => json_encode($r->slcClassesTags),
			'content' => $r->txaClassesContent,
			// 'unique_id' => uniqid(),
			'participant_limit' => $r->numClassesLimit,
			'date_start' => $r->datClassesDateStart,
			'date_end' => $r->datClassesDateEnd,
			'tipe' => json_encode($r->slcClassesType),
			'level' => $r->slcClassesLevel,
			'jenis' => json_encode($r->slcClassesJenis),
			'status' => $status,
			'sub_category' => json_encode($r->subCategory),
			'poin' => $r->numClassesPoin ? $r->numClassesPoin : 0,
		];

		// Data Meta
		$meta = [];
		if ($r->meta_name) {
			if (count($r->meta_name) > 0) {
				for ($i = 0; $i < count($r->meta_name); $i++) {
					if ($r->meta_name[$i]) {
						$meta['name'][$i] = $r->meta_name[$i];
					}
				}
			}
		}
		if ($r->meta_content) {
			if (count($r->meta_content) > 0) {
				for ($i = 0; $i < count($r->meta_content); $i++) {
					if ($r->meta_content[$i]) {
						$meta['content'][$i] = $r->meta_content[$i];
					}
				}
			}
		}
		$tobeins['meta'] = json_encode($meta);

		$og = [
			'description' => $r->meta_description,
			'title' => $r->meta_title,
		];
		if ($r->oldsizemetaimage) {
			$og['image'] = $r->oldmetaimage;
			$og['size'] = $r->oldsizemetaimage;
		}
		// Data Meta Image
		if ($r->meta_image) {
			$namemeta_image = $r->file('meta_image')->getClientOriginalName();
			$sizemeta_image = $r->file('meta_image')->getSize();
			if ($sizemeta_image >= 1048576) {
				return Redirect::back()->with('error', 'Ukuran File Melebihi 1 MB');
			}
			$filename2 = time() . '-' . $namemeta_image;
			$file = $r->file('meta_image');
			$file->move(public_path('image/laman/meta_image'), $filename2);
			$og['image'] = $filename2;
			$og['size'] = $sizemeta_image;
		}
		$tobeins['og'] = json_encode($og);

		if ($r->file('filClassesImage')) {
			$name = $r->file('filClassesImage')->getClientOriginalName();
			$size = $r->file('filClassesImage')->getSize();

			if ($size >= 1048576) {
				return Redirect::back()->with('error', 'Ukur, File Melebihi 1 MB');
			}

			$filename = time() . '-' . $name;
			$file = $r->file('filClassesImage');
			$file->move(public_path('image/classes'), $filename);

			$tobeins['image'] = ('/image/classes/' . $filename);
		}
		if ($r->file('filClassesImageMobile')) {
			$nameMobile = $r->file('filClassesImageMobile')->getClientOriginalName();
			$sizeMobile = $r->file('filClassesImageMobile')->getSize();

			if ($sizeMobile >= 1048576) {
				return Redirect::back()->with('error', 'Ukur, File Melebihi 1 MB');
			}

			$filenameMobile = time() . '-' . $nameMobile;
			$fileMobile = $r->file('filClassesImageMobile');
			$fileMobile->move(public_path('image/classes'), $filenameMobile);

			$tobeins['image_mobile'] = ('/image/classes/' . $filenameMobile);
		}


		ClassesModel::where('id', $id)->update($tobeins);

		return Redirect::back()->with('success', 'Class Updated');
		// return redirect('/admin/classes')->with('success', 'Class Updated');
	}

	public function destroy($id)
	{
		ClassesModel::where('id', $id)->delete();
		return redirect('/admin/classes')->with('success', 'Class Deleted');
	}

	public function activated($id, $status)
	{
		// $s = 0;
		// if ($status == 1) {
		// 	$s = 1;
		// }
		$s = $status == 1 ? 0 : 1;
		$c = ClassesModel::where('id', $id)->update([
			'status' => $s
		]);
		if ($c) {
			return Redirect::back()->with('success', 'Class is Changed');
		}
		return Redirect::back()->with('success', 'Class not Changed');
	}

	public function setpricing(Request $r)
	{
		$p = 0;
		if ($r->bolClassPromo) {
			$p = 1;
		}
		ClassPricingModel::UpdateOrCreate(['class_id' => $r->hdnClassesId], [
			'class_id' => $r->hdnClassesId,
			'price' => $r->numClassPrice,
			'promo' => $p,
			'promo_price' => $r->numClassPromo,
			'promo_start' => $r->datPromoDateStart,
			'promo_end' => $r->datPromoDateEnd,
		]);
		return Redirect::back()->with('success', 'Price Updated');
	}

	public function setcontent(Request $r)
	{
		$tobedel = $r->hdnContentTBDId;
		if ($tobedel) {
			ClassContentModel::whereIn('id', explode(',', $tobedel))->delete();
		}
		$tobeins = [];
		for ($i = 0; $i < count($r->slcClassContentType); $i++) {
			$file = '-';
			if ($r->slcClassContentType[$i] == 1) {
				if ($r->file('txtClassContentDoc.' . $i)) {
					$file = $r->file('txtClassContentDoc.' . $i)->store('classes/content/' . time());
				}
			} else if ($r->slcClassContentType[$i] == 2) {
				if ($r->file('txtClassContentImg.' . $i)) {
					$file = $r->file('txtClassContentImg.' . $i)->store('classes/content/' . time());
				}
			} else if ($r->slcClassContentType[$i] == 3) {
				$file = $r->txtClassContentVid[$i];
			}
			$tobeins[$i] = [
				'class_id' => $r->hdnClassesId,
				'type' => $r->slcClassContentType[$i],
				'title' => $r->txtClassContentTitle[$i],
				'description' => '-',
				'url' => $file,
			];
			ClassContentModel::UpdateOrCreate(['id' => $r->txtClassContentId[$i]], $tobeins[$i]);
		}
		return Redirect::back()->with('success', 'File Updated');
	}

	public function createevent(Request $r, $id)
	{
		$data['class'] = ClassesModel::where('id', $id)->first();
		$data['event'] = ClassEventModel::where('class_id', $id)->get();

		return view('backend/classes/classevent', $data);
	}

	public function createcertificate(Request $r, $id)
	{
		$data['class'] = ClassesModel::where('id', $id)->first();
		$data['certs'] = ClassCertificateTemplate::where('class_id', $id)->first();

		return view('backend/classes/classcertificatetemplate', $data);
	}

	public function setcertificate(Request $r, $id)
	{
		$tobeins = [
			'content' => $r->txaContent,
			'page_size' => $r->slcPageSize,
			'layout' => 0,
			'certificate_created' => $r->datCertificateCreated,
			'certificate_expired' => $r->datCertificateExpired,
		];

		if ($r->file('filBackground')) {
			$name = $r->file('filBackground')->getClientOriginalName();
			$size = $r->file('filBackground')->getSize();

			if ($size >= 5548576) {
				return Redirect::back()->with('error', 'Ukuran File Melebihi 5 MB');
			}

			$filename = time() . '-' . $name;
			$file = $r->file('filBackground');
			$file->move(public_path('image/classes/cert'), $filename);

			$tobeins['background'] = ('image/classes/cert/' . $filename);
		}


		ClassCertificateTemplate::UpdateOrCreate(['class_id' => $id], $tobeins);

		return Redirect::back()->with('success', 'Certificate Updated');
	}

	public function previewcertificate(Request $r, $id)
	{
		$data['class'] = ClassesModel::where('id', $id)->first();
		if (!$data['class']) {
			return Redirect::back()->with('error', 'Kelas Tidak Ditemukan');
		}
		$data['certs'] = ClassCertificateTemplate::where('class_id', $id)->first();
		if (!$data['certs']) {
			return Redirect::back()->with('error', 'Sertifikat Tidak Ditemukan');
		}
		$data['name'] = 'John Doe';
		$data['contents'] = str_replace("[[date_expired]]", $data['certs']->certificate_expired, str_replace("[[date_active]]", $data['certs']->certificate_created, str_replace("[[class]]", $data['class']->title, str_replace("[[name]]", $data['name'], $data['certs']->content))));

		// return view('backend/certificate/certificate',$data);

		$pdf = PDF::loadView('backend/certificate/certificate', $data);
		return $pdf->setPaper($data['certs']->page_size, 'landscape')->stream('certificate.pdf');
	}

	public function getCertificate(Request $r, $id)
	{
		$data['class'] = ClassesModel::where('id', $id)->first();
		$data['certs'] = ClassCertificateTemplate::where('class_id', $id)->first();
		$profile = UserProfileModel::where('user_id', Auth::user()->id)->first();
		if (!ClassParticipantModel::where('user_id', Auth::user()->id)->where('class_id', $id)->where('certificate', 1)->exists()) {
			return Redirect::back()->with('error', 'Certificate belum diberikan');
		}
		if (!$data['certs']) {
			return Redirect::back()->with('error', 'Certificate belum dibuat');
		}
		if (!$profile) {
			return Redirect::back()->with('error', 'Lengkapi Profile User');
		}
		$data['name'] = $profile->name;
		$data['contents'] = str_replace("[[date_expired]]", $data['certs']->certificate_expired, str_replace("[[date_active]]", $data['certs']->certificate_created, str_replace("[[class]]", $data['class']->title, str_replace("[[name]]", $data['name'], $data['certs']->content))));

		// return view('backend/certificate/certificate',$data);

		$pdf = PDF::loadView('backend/certificate/certificate', $data);
		return $pdf->setPaper($data['certs']->page_size, 'landscape')->stream('certificate.pdf');
	}

	public function setevent(Request $r)
	{
		$valid = Validator::make($r->all(), [
			'hdnClassesId' => 'required',
			'slcClassEventType' => 'required',
			'slcClassEventType.*' => 'required',
			// 'txtClassEventLink.*' => 'required',
			// 'txtClassEventLocation.*' => 'required',
			'txaClassEventDescription.*' => 'required',
			'datClassesDateStart.*' => 'required',
			'datClassesDateEnd.*' => 'required',
		]);
		//response error validation
		if ($valid->fails()) {
			return Redirect::back()->withErrors($valid)->withInput($r->all())->with('info', 'Data Tidak Sesuai');
		}
		$tobedel = $r->hdnEventTBDId;
		if ($tobedel) {
			ClassEventModel::whereIn('id', explode(',', $tobedel))->delete();
		}
		$tobeins = [];
		for ($i = 0; $i < count($r->slcClassEventType); $i++) {
			$tobeins = [
				'class_id' => $r->hdnClassesId,
				'type' => $r->slcClassEventType[$i],
				'link' => $r->txtClassEventLink[$i],
				'location' => $r->txtClassEventLocation[$i],
				'description' => $r->txaClassEventDescription[$i],
				'time_start' => $r->datClassesDateStart[$i],
				'time_end' => $r->datClassesDateEnd[$i],
				'password_link' => $r->txtClassEventPassword[$i],
			];
			ClassEventModel::UpdateOrCreate(['id' => $r->txtClassEventId[$i]], $tobeins);
		}
		return Redirect::back()->with('success', 'Event Updated');
	}

	public function setreview($id, $active)
	{
		$act = 1;
		if ($active == 1) {
			$act = 0;
		}
		$d = ClassParticipantModel::where('id', $id)->update(
			[
				'review_active' => $act,
			]
		);
		if ($d) {
			return Redirect::back()->with('success', 'Review Tersimpan');
		}
		return Redirect::back()->with('error', 'Review Tidak Tersimpan');
	}

	public function getreview($class_id)
	{
		$data['class'] = ClassesModel::where('id', $class_id)->first();
		$data['review'] = ClassParticipantModel::where('class_id', $class_id)->get();
		// return $data;
		return view('backend.classes.reviewclass', $data);
	}

	public function sendreview(Request $request)
	{
		$valid = Validator::make($request->all(), [
			'nilai' => 'required',
			'review' => 'required',
		]);
		//response error validation
		if ($valid->fails()) {
			return Redirect::back()->withErrors($valid)->withInput($request->all())->with('error', 'Data Tidak Lengkap');
		}

		$c = ClassParticipantModel::where('id', $request->participant_id)->update([
			'review_active' => 0,
			'review_time' => Carbon::now(),
			'review_point' => $request->nilai,
			'review' => $request->review,
		]);
		if ($c) {
			return Redirect::back()->with('success', 'Review Tersimpan');
		}
		return Redirect::back()->withInput($request->all())->with('error', 'Review Tidak Tersimpan');
	}
	public function pencarian()
	{
		$data['instructor'] = InstructorModel::select('id', 'name')->where('status', 1)->distinct('id')->pluck('id', 'name')->toArray();
		$data['category'] = ClassesModel::select('category')->distinct('category')->pluck('category')->toArray();
		// Tags
		$tags = ClassesModel::select('tags')->distinct('tags')->pluck('tags')->toArray();
		$data['tags'] = [];
		foreach ($tags as $key => $value) {
			if ($value) {
				foreach (json_decode($value) as $key => $v) {
					// $data['tag'] = $v;
					if (array_search($v, $data['tags'])) {
						// 
					} else {
						array_push($data['tags'], $v);
					}
				}
			}
		}
		// Jenis
		$jenis = ClassesModel::select('jenis')->distinct('jenis')->pluck('jenis')->toArray();
		$data['jenis'] = [];
		foreach ($jenis as $key => $value) {
			if ($value) {
				foreach (json_decode($value) as $key => $v) {
					// $data['tag'] = $v;
					if (array_search($v, $data['jenis'])) {
						// 
					} else {
						array_push($data['jenis'], $v);
					}
				}
			}
		}
		// Type
		$tipe = ClassesModel::select('tipe')->distinct('tipe')->pluck('tipe')->toArray();
		$data['tipe'] = [];
		foreach ($tipe as $key => $value) {
			if ($value) {
				foreach (json_decode($value) as $key => $v) {
					// $data['tag'] = $v;
					if (array_search($v, $data['tipe'])) {
						// 
					} else {
						array_push($data['tipe'], $v);
					}
				}
			}
		}
		return $data;
	}
	public function bannerClass($judul)
	{
		$now = Carbon::now();
		$j = 'Bg-register-01-Copy.jpg';
		$banner = BannerModel::where('jenis', 7)->where('mulai', '<=', $now->format('Y-m-d'))->where('selesai', '>=', $now->format('Y-m-d'))->first();
		if ($judul == 'calon bankir') {
			$banner = BannerModel::where('jenis', 4)->where('mulai', '<=', $now->format('Y-m-d'))->where('selesai', '>=', $now->format('Y-m-d'))->first();
		}
		if ($judul == 'bankir') {
			$banner = BannerModel::where('jenis', 5)->where('mulai', '<=', $now->format('Y-m-d'))->where('selesai', '>=', $now->format('Y-m-d'))->first();
		}
		if ($judul == 'bootcamp bankir') {
			$banner = BannerModel::where('jenis', 6)->where('mulai', '<=', $now->format('Y-m-d'))->where('selesai', '>=', $now->format('Y-m-d'))->first();
		}
		if ($judul == 'management trainer') {
			$banner = BannerModel::where('jenis', 8)->where('mulai', '<=', $now->format('Y-m-d'))->where('selesai', '>=', $now->format('Y-m-d'))->first();
		}
		if ($banner) {
			$j = '/Image/' . $banner->image;
		}
		return $j;
	}
	public function listClass(Request $request)
	{
		$limit = 99;
		// $auth = Auth::user();
		// if ($auth) {
		// 	if ($auth->profile) {
		// 		if ($auth->profile->membership) {
		// 			$limit = $auth->profile->membership->limit;
		// 		}
		// 	}
		// }
		// $limit = 99;
		$data['judul'] = 'Kelas';
		if ($request->jenis) {
			$data['judul'] = str_replace('_', ' ', $request->jenis);
		}
		$data['banner'] = $this->bannerClass($data['judul']);
		$class_id = [];
		$class = ClassesModel::select('id')->limit($limit)->get();
		foreach ($class as $key => $value) {
			array_push($class_id, $value->id);
		}
		$data['class'] = ClassesModel::select()
			->whereIn('id', $class_id)
			->where(function ($sql) use ($request) {
				if ($request->jenis) {
					return $sql->where('jenis', 'like', '%"' . strtoupper($request->jenis) . '"%');
				}
			})
			->where('date_end', '>=', Carbon::now()->format('Y-m-d'))
			->where('status', 1)
			->orderBy('date_end', 'asc')
			->paginate(9)
			->toArray();
		if ($request->ajax()) {
			return $data['class'];
		}
		$data['pencarian'] = $this->pencarian();
		// return $data;
		return view('front.kelas.listclass', $data);
	}
	public function findClass(Request $request)
	{
		$checbox = [];
		if ($request->checkbox) {
			$checbox = array_keys((array)$request->checkbox);
		}
		$tipe = [];
		if ($request->tipe) {
			$tipe = array_keys((array)$request->tipe);
		}
		$jeniss = [];
		if ($request->jeniss) {
			$jeniss = array_keys((array)$request->jeniss);
		}

		$data['judul'] = 'Kelas';
		if ($request->jenis) {
			$data['judul'] = str_replace('_', ' ', $request->jenis);
		}
		$data['banner'] = $this->bannerClass($data['judul']);
		$data['class'] = ClassesModel::select()
			->where('date_end', '>=', Carbon::now()->format('Y-m-d'))
			->where(function ($sql) use ($checbox) {
				if (count($checbox) > 0) {
					for ($i = 0; $i < count($checbox); $i++) {
						$sql->orWhere('tags', 'like', '%"' . $checbox[$i] . '"%');
					}
				}
			})
			->where(function ($sql) use ($tipe) {
				if (count($tipe) > 0) {
					for ($i = 0; $i < count($tipe); $i++) {
						$sql->orWhere('tipe', 'like', '%"' . $tipe[$i] . '"%');
					}
				}
			})
			->where(function ($sql) use ($jeniss) {
				if (count($jeniss) > 0) {
					for ($i = 0; $i < count($jeniss); $i++) {
						$sql->orWhere('jenis', 'like', '%"' . $jeniss[$i] . '"%');
					}
				}
			})
			->where(function ($sql) use ($request) {
				if ($request->title) {
					$sql->where('title', 'like', '%' . $request->title . '%');
				}
				if ($request->instructor) {
					$sql->where('instructor', 'like', '%' . $request->instructor . '%');
				}
				if ($request->slcClassesCategory) {
					$sql->where('category', 'like', '%' . $request->slcClassesCategory . '%');
				}
			})
			->paginate(8)->toArray();

		$data['pencarian'] = $this->pencarian();
		$data['slcClassesCategory'] = $request->slcClassesCategory;
		$data['title'] = $request->title;
		$data['instructor'] = $request->instructor;
		$data['tags'] = $request->checkbox;
		$data['tipe'] = $request->tipe;
		$data['jeniss'] = $request->jeniss;
		return view('front.kelas.listclass', $data);
	}

	public function biayacertificate(Request $request)
	{
		$b = BiayaSertifikatModel::updateOrCreate([
			'class_id' => $request->id_kelas
		], [
			'tipe' => $request->tipe,
			'nominal' => $request->nominal,
		]);
		if ($b) {
			return Redirect::back()->with('success', 'Biaya Sertifikat Tesimpan');
		}
		return Redirect::back()->with('info', 'Biaya Sertifikat Tidak Tesimpan');
	}
}
