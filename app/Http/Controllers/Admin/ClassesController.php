<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
		$data['classes'] = ClassesModel::where(function ($q) use ($data) {
			$q->whereBetween('date_start', [$data['param']['date_start'], $data['param']['date_end']])->orWhereBetween('date_end', [$data['param']['date_start'], $data['param']['date_end']]);
			if ($data['param']['category']) {
				$q->where('category', $data['param']['category']);
			}
		})->get();

		//Additional
		$data['category'] = ClassesModel::select('category')->distinct('category')->pluck('category')->toArray();
		$data['instructor'] = InstructorModel::get();

		return view('backend/classes/classes', $data);
	}

	public function create(Request $r)
	{
		$data['category'] = ClassesModel::select('category')->distinct('category')->pluck('category')->toArray();
		$data['instructor'] = InstructorModel::get();

		return view('backend/classes/inputclasses', $data);
	}

	public function store(Request $r)
	{
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
		]);

		return redirect('/admin/classes')->with('success', 'Class Saved');
	}

	public function edit(Request $r, $id)
	{
		$data['id'] = $id;
		$data['classes'] = ClassesModel::where('id', $id)->first();
		$data['category'] = ClassesModel::select('category')->distinct('category')->pluck('category')->toArray();
		$data['instructor'] = InstructorModel::get();

		return view('backend/classes/editclasses', $data);
	}

	public function update(Request $r, $id)
	{
		$tobeins = [
			'title' => $r->txtClassesTitle,
			'instructor' => json_encode($r->txtClassesInstructor),
			'category' => $r->slcClassesCategory,
			'tags' => json_encode($r->slcClassesTags),
			'content' => $r->txaClassesContent,
			'unique_id' => uniqid(),
			'participant_limit' => $r->numClassesLimit,
			'date_start' => $r->datClassesDateStart,
			'date_end' => $r->datClassesDateEnd,
		];

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

		return redirect('/admin/classes')->with('success', 'Class Updated');
	}

	public function destroy($id)
	{
		ClassesModel::where('id', $id)->delete();
		return redirect('/admin/classes')->with('success', 'Class Deleted');
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
		return redirect('/admin/classes')->with('success', 'Price Updated');
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
		return redirect('/admin/classes')->with('success', 'Price Updated');
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

		return redirect('/admin/classes')->with('success', 'Certificate Updated');
	}

	public function previewcertificate(Request $r, $id)
	{
		$data['class'] = ClassesModel::where('id', $id)->first();
		$data['certs'] = ClassCertificateTemplate::where('class_id', $id)->first();
		$data['name'] = 'John Doe';
		$data['contents'] = str_replace("[[date_expired]]", $data['certs']->certificate_expired, str_replace("[[date_active]]", $data['certs']->certificate_created, str_replace("[[class]]", $data['class']->title, str_replace("[[name]]", $data['name'], $data['certs']->content))));
		if (!$data['certs']) {
			return Redirect::back()->with('error', 'Certificate belum dibuat');
		}

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
		$tobedel = $r->hdnEventTBDId;
		if ($tobedel) {
			ClassEventModel::whereIn('id', explode(',', $tobedel))->delete();
		}
		$tobeins = [];
		for ($i = 0; $i < count($r->slcClassEventType); $i++) {

			$tobeins[$i] = [
				'class_id' => $r->hdnClassesId,
				'type' => $r->slcClassEventType[$i],
				'link' => $r->txtClassEventLink[$i],
				'location' => $r->txtClassEventLocation[$i],
				'description' => $r->txaClassEventDescription[$i],
				'time_start' => $r->datClassesDateStart[$i],
				'time_end' => $r->datClassesDateEnd[$i],
			];
			ClassEventModel::UpdateOrCreate(['id' => $r->txtClassEventId[$i]], $tobeins[$i]);
		}
		return redirect('/admin/classes')->with('success', 'Price Updated');
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
	public function listClass($category)
	{
		$data['class'] = ClassesModel::where(function ($sql) use ($category) {
			if ($category !== 'Semua') {
				$str = str_replace('_', ' ', $category);
				return $sql->where('category', $str);
			}
		})->paginate(7)->toArray();

		return view('front.kelas.listclass', $data);
	}
}
