<?php

namespace App\Http\Controllers;
use App\Models\patient_log;
use App\Models\patient_list;
use App\Models\sexes;
use App\Models\stocks_log;
use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data['countusers'] = User::get()->count();
        $data['countpatient'] = patient_log::get()->count();
        $data['countpatientnow'] = patient_log::wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->get()->count();
        $data['stocklog'] = stocks_log::orderBy('created_at','desc')->get();
        return view('dashboard')->with('data', $data);
    }
    public function adminHome()
    {
        $data['countusers'] = User::get()->count();
        $data['countpatient'] = patient_log::get()->count();
        $data['countpatientnow'] = patient_log::wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->get()->count();
        $data['stocklog'] = stocks_log::orderBy('created_at','desc')->get();
        return view('adminHome')->with('data', $data);
    }
    public function UserHome()
    {
        $data['patientlist'] = patient_list::where('type', "1")->get();
        $data['sex'] = sexes::get();
        return view('sendpatientbone.showdata')->with('data', $data);
    }
    public function DoctorBonehome()
    {
        // หน้า Login DoctorBone
        $data['patientlog'] = patient_log::where('type', "1")->where('status', "1")->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();
        $data['sex'] = sexes::get();
        return view('patientcheckbone.showdata')->with('data', $data);
        // return view('Doctorbonehome');
    }

    public function DoctorChildhome()
    {
        // หน้า Login DoctorChild
        $data['patientlog'] = patient_log::where('type', "2")->where('status', "1")->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();
        $data['sex'] = sexes::get();
        return view('patientcheckchild.showdata')->with('data', $data);
        // return view('Doctorbonehome');
    }
}
