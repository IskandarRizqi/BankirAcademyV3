<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ClassesModel;
use App\Models\ClassParticipantModel;
use App\Models\InstructorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesertaController extends Controller
{
    public function index()
    {
        $data = [];
        $data['peserta'] = ClassParticipantModel::select('class_participant.*', 'users.name', 'classes.title', 'user_profile.phone')
            ->join('users', 'users.id', 'class_participant.user_id')
            ->join('classes', 'classes.id', 'class_participant.class_id')
            ->leftJoin('user_profile', 'user_profile.user_id', 'class_participant.user_id')
            ->get();
        // return $data;
        return view('backend.peserta.peserta', $data);
    }

    public function instructor()
    {
        $data = [];
        $ins = InstructorModel::where('user_id', Auth::user()->id)->first();
        $data['peserta'] = ClassParticipantModel::select('class_participant.*', 'users.name', 'users.email', 'classes.title', 'user_profile.phone', 'user_profile.name as name_profile')
            ->join('users', 'users.id', 'class_participant.user_id')
            ->join('classes', 'classes.id', 'class_participant.class_id')
            ->join('user_profile', 'user_profile.user_id', 'class_participant.user_id')
            // ->leftJoin('user_profile', 'user_profile.user_id', 'class_participant.user_id')
            ->where('classes.instructor', 'like', '%"' . $ins->id . '"%')
            ->get();
        // $p = [];
        // $data['peserta'] = ClassesModel::select()
        //     ->where('instructor', 'like', '%"' . $ins->id . '"%')
        //     ->get();
        // foreach ($data['peserta'] as $key => $value) {
        //     if (count($value->peserta_list['all']) > 0) {
        //         array_push($p, $value->peserta_list['all']);
        //     }
        // }
        // return $data;
        return view('backend.instructor.peserta.peserta', $data);
    }
}
