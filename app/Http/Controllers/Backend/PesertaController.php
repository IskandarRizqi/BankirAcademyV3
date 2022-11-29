<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ClassParticipantModel;
use Illuminate\Http\Request;

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
}
