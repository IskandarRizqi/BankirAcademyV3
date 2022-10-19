<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassesModel;
use App\Models\InstructorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class ClassesController extends Controller
{
    public function index(Request $r)
	{
		$data = [];

		//Param
		$data['param'] = [];
		$data['param']['date_start'] = ($r->param_date_start)?$r->param_date_start:Carbon::now()->submonth()->format('Y-m-d');
		$data['param']['date_end'] = ($r->param_date_end)?$r->param_date_end:Carbon::now()->format('Y-m-d');
		$data['param']['category'] = ($r->param_category)?$r->param_category:null;

		//Classes
		$data['classes'] = ClassesModel::where(function ($q) use ($data){
			$q->whereBetween('date_start',[$data['param']['date_start'],$data['param']['date_end']])->orWhereBetween('date_end',[$data['param']['date_start'],$data['param']['date_end']]);
			if ($data['param']['category']) {
				$q->where('category',$data['param']['category']);
			}
		})->get();

		//Additional
		$data['category'] = ClassesModel::select('category')->distinct('category')->pluck('category')->toArray();
		$data['instructor'] = InstructorModel::get();
		
		return view('backend/classes/classes', $data);
	}

	public function store(Request $r)
	{
		$name = $r->file('filClassesImage')->getClientOriginalName();
        $size = $r->file('filClassesImage')->getSize();

        if ($size >= 1048576) {
            return Redirect::back()->withErrors(['error' => 'Ukuran File Melebihi 1 MB']);
        }

        $filename = time() . '-' . $name;
        $file = $r->file('filClassesImage');
        $file->move(public_path('image/classes'), $filename);


		ClassesModel::create([
			'title'=>$r->txtClassesTitle,
			'instructor' => json_encode($r->txtClassesInstructor),
			'category' => $r->slcClassesCategory,
			'tags' => json_encode($r->slcClassesTags),
			'image' => ('/image/classes/' . $filename),
			'content' => $r->txaClassesContent,
			'unique_id' => uniqid(),
			'participant_limit' => $r->numClassesLimit,
			'date_start' => $r->datClassesDateStart,
			'date_end' => $r->datClassesDateEnd,
		]);

		return redirect('/admin/classes')->with('success','Class Saved');
	}

	public function update(Request $r,$id)
	{
		$tobeins = [
			'title'=>$r->txtClassesTitle,
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
				return Redirect::back()->withErrors(['error' => 'Ukuran File Melebihi 1 MB']);
			}
	
			$filename = time() . '-' . $name;
			$file = $r->file('filClassesImage');
			$file->move(public_path('image/classes'), $filename);

			$tobeins['image'] = ('/image/classes/' . $filename);
		}


		ClassesModel::where('id', $id)->update($tobeins);

		return redirect('/admin/classes')->with('success','Class Updated');
	}
	
	public function destroy($id)
	{
		ClassesModel::where('id', $id)->delete();
		return redirect('/admin/classes')->with('success','Class Deleted');
	}
}
