<?php

namespace App\Http\Controllers;

use App\Models\drugs_list;
use App\Models\orders;
use App\Models\orders_detail;
use App\Models\patient_history;
use App\Models\patient_list;
use App\Models\patient_log;
use App\Models\stocks_log;
use App\Models\stocks_detail;
use App\Models\sexes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class patientlistController extends Controller
{
    public function patientbone()
    {
        $data['patientlist'] = patient_list::where('type', "1")->get();
        $data['sex'] = sexes::get();
        return view('patient_bone.showdata')->with('data', $data);
    }

    public function patientcheckbone()
    {
        $data['patientlog'] = patient_log::where('type', "1")->where('status', "1")->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();
        $data['sex'] = sexes::get();
        return view('patientcheckbone.showdata')->with('data', $data);
    }

    public function patientcheckchild()
    {
        $data['patientlog'] = patient_log::where('type', "2")->where('status', "1")->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();
        $data['sex'] = sexes::get();
        return view('patientcheckchild.showdata')->with('data', $data);
    }

    public function patientBoneDetail($id)
    {
        $data['patient_list'] = patient_list::where('patient_id', $id)->get();
        $data['druglist'] = drugs_list::get();
        $data['sex'] = sexes::get();
        $data['patient_hitsories'] = patient_history::where('patient_id', $id)->get();
        return view('patientcheckbone.patient_bone_detail')->with('data', $data);
    }

    public function patientChildDetail($id)
    {
        $data['patient_list'] = patient_list::where('patient_id', $id)->get();
        $data['druglist'] = drugs_list::get();
        $data['sex'] = sexes::get();
        $data['patient_hitsories'] = patient_history::where('patient_id', $id)->get();
        return view('patientcheckchild.patient_child_detail')->with('data', $data);
    }

    public function fetchBoneDrugDetail(Request $request)
    {
        $data['orders_detail'] = orders_detail::where('order_id', $request->orderId)->with('dname')->get();
        echo json_encode(array("data" => $data));
    }

    public function fetchBoneDrugdoneDetail(Request $request)
    {
        $patient_name = patient_list::where('patient_id', $request->patientid)->get('name');
        foreach ($patient_name as $row) {
            $patient_name =  $row->toArray();
        }
        $data['name'] = $patient_name['name'];
        $orderId = orders::where('patient_id', $request->patientid)->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->get('order_id');
        foreach ($orderId as $row) {
            $orderId =  $row->toArray();
        }
        $data['orders_detail'] = orders_detail::where('order_id', $orderId['order_id'])->with('dname')->get();
        $next_check = patient_history::where('patient_id', $request->patientid)->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->get('next_check');
        foreach ($next_check as $row) {
            $next_check =  $row->toArray();
        }
        $data['next_check'] = $next_check['next_check'];
        $grandtotal = orders::where('patient_id', $request->patientid)->where('order_id', $orderId)->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->get('grandtotal');
        foreach ($grandtotal as $row) {
            $grandtotal =  $row->toArray();
        }
        $data['grandtotal'] = $grandtotal['grandtotal'];
        // dd($data['grandtotal']);
        echo json_encode(array("data" => $data));
    }

    public function fetchChildDrugDetail(Request $request)
    {
        $data['orders_detail'] = orders_detail::where('order_id', $request->orderId)->with('dname')->get();
        echo json_encode(array("data" => $data));
    }
    public function fetchChildDrugdoneDetail(Request $request)
    {
        $patient_name = patient_list::where('patient_id', $request->patientid)->get('name');
        foreach ($patient_name as $row) {
            $patient_name =  $row->toArray();
        }
        $data['name'] = $patient_name['name'];
        $orderId = orders::where('patient_id', $request->patientid)->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->get('order_id');
        foreach ($orderId as $row) {
            $orderId =  $row->toArray();
        }
        $data['orders_detail'] = orders_detail::where('order_id', $orderId['order_id'])->with('dname')->get();
        $next_check = patient_history::where('patient_id', $request->patientid)->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->get('next_check');
        foreach ($next_check as $row) {
            $next_check =  $row->toArray();
        }
        $data['next_check'] = $next_check['next_check'];
        $grandtotal = orders::where('patient_id', $request->patientid)->where('order_id', $orderId)->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->get('grandtotal');
        foreach ($grandtotal as $row) {
            $grandtotal =  $row->toArray();
        }
        $data['grandtotal'] = $grandtotal['grandtotal'];
        // dd($data['grandtotal']);
        echo json_encode(array("data" => $data));
    }

    public function fetchStockDetail(Request $request)
    {
        $data['order'] = orders::where('stock_id', $request->stockid)->with('pname')->get();
        $data['stocks_detail'] = stocks_detail::where('stock_id', $request->stockid)->get();
        echo json_encode(array("data" => $data));
    }

    public function dispenseBone(Request $request)
    {
        // dd($request);
        //Orders
        orders::where('order_id', $request->order_id)->update([
            'stock_id' => $request->stock_id
        ]);

        //Stock
        $stocks_log = new stocks_log();
        $stocks_log->stock_id = $request->stock_id;
        $stocks_log->status = 2;

        $idDrug = explode(',', $request->drug_id);
        $amountDrug = explode(',', $request->drug_qty);
        $data['drug_qtyOld'] = [];

        for ($i = 0; $i < count($idDrug); $i++) {

            $stocksDetail[] = [
                'stock_id' => $request->stock_id,
                'drug_id' => $idDrug[$i],
                'amount_old' => 0,
                'amount' => $amountDrug[$i],
                'amount_total' => 0,
                'created_at' => Carbon::now()
            ];

            $drug_qtyOld = drugs_list::where('drug_id', $idDrug[$i])->get('item_qty');
            foreach ($drug_qtyOld as $row) {
                $drug_qtyOld =  $row->toArray();
            }
            $data['drug_qtyOld'][$i] = $drug_qtyOld['item_qty'];
        }

        DB::beginTransaction();
        try {

            patient_log::where('patient_id', $request->patientid)->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->update([
                'status' => 3
            ]);

            $stocks_log->save();
            stocks_detail::insert($stocksDetail);

            for ($i = 0; $i < count($idDrug); $i++) {
                drugs_list::where('drug_id', $idDrug[$i])->update([
                    'item_qty' => $data['drug_qtyOld'][$i] - $amountDrug[$i]
                ]);
                stocks_detail::where('drug_id', $idDrug[$i])->where('stock_id', $request->stock_id)->update([
                    'amount_old' => $data['drug_qtyOld'][$i],
                    'amount_total' => $data['drug_qtyOld'][$i] - $amountDrug[$i]
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        return redirect()->route('donepatientbone')->with('success','จ่ายยาเรียบร้อยแล้ว');
    }

    public function dispenseChild(Request $request)
    {
        // dd($request);
        //Stock
        $stocks_log = new stocks_log();
        $stocks_log->stock_id = $request->stock_id;
        $stocks_log->status = 2;

        $idDrug = explode(',', $request->drug_id);
        $amountDrug = explode(',', $request->drug_qty);
        $data['drug_qtyOld'] = [];
        // dd($idDrug);
        for ($i = 0; $i < count($idDrug); $i++) {

            $stocksDetail[] = [
                'stock_id' => $request->stock_id,
                'drug_id' => $idDrug[$i],
                'amount_old' => 0,
                'amount' => $amountDrug[$i],
                'amount_total' => 0,
                'created_at' => Carbon::now()
            ];

            $drug_qtyOld = drugs_list::where('drug_id', $idDrug[$i])->get('item_qty');
            foreach ($drug_qtyOld as $row) {
                $drug_qtyOld =  $row->toArray();
            }
            $data['drug_qtyOld'][$i] = $drug_qtyOld['item_qty'];
        }

        DB::beginTransaction();
        try {

            patient_log::where('patient_id', $request->patientid)->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->update([
                'status' => 3
            ]);

            $stocks_log->save();
            stocks_detail::insert($stocksDetail);
            // dd(count($idDrug));
            for ($i = 0; $i < count($idDrug); $i++) {
                drugs_list::where('drug_id', $idDrug[$i])->update([
                    'item_qty' => $data['drug_qtyOld'][$i] - $amountDrug[$i]
                ]);
                stocks_detail::where('drug_id', $idDrug[$i])->where('stock_id', $request->stock_id)->update([
                    'amount_old' => $data['drug_qtyOld'][$i],
                    'amount_total' => $data['drug_qtyOld'][$i] - $amountDrug[$i]
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        return redirect()->route('donepatientchild')->with('success','จ่ายยาเรียบร้อยแล้ว');
    }


    public function patientBoneTreatment($id)
    {
        $data['patient_list'] = patient_list::where('patient_id', $id)->get();
        $data['druglist'] = drugs_list::get();
        return view('patientcheckbone.patientBoneTreatment')->with('data', $data);
    }

    public function patientChildTreatment($id)
    {
        $data['patient_list'] = patient_list::where('patient_id', $id)->get();
        $data['druglist'] = drugs_list::get();
        return view('patientcheckchild.patientChildTreatment')->with('data', $data);
    }

    public function addPatientBoneTreatment(Request $request)
    {
        $patient_history = new patient_history();
        $patient_history->patient_id = $request->patient_id;
        $patient_history->order_id = $request->order_id;
        $patient_history->patient_symptoms = $request->patientSymptoms;
        $patient_history->date_history = $request->dateHitsory;
        $patient_history->next_check = $request->nextDate;

        // $patient_logs = new patient_log();
        // $patient_logs->patient_id = $request->patient_id;
        // $patient_logs->type = 1;
        // $patient_logs->status = 2;

        $orders = new orders();
        $orders->patient_id = $request->patient_id;
        $orders->order_id = $request->order_id;
        $orders->date_order = $request->dateHitsory;
        $orders->discount =  is_null($request->discount_price) ? 0 : $request->discount_price;
        $orders->grandtotal = $request->grandtotal;

        for ($i = 0; $i < count($request->drug_id); $i++) {
            //Start a PurchaseDetail
            $orderDetail[] = [
                'order_id' => $request->order_id,
                'drug_id' => $request->drug_id[$i],
                'amount' => is_null($request->drug_qty[$i]) ?  1 : $request->drug_qty[$i],
                'price' => $request->drug_total_price[$i]
            ];
        }

        DB::beginTransaction();
        try {
            $patient_history->save();
            //$patient_logs->save();
            $orders->save();

            orders_detail::insert($orderDetail);
            patient_log::where('patient_id', $request->patient_id)->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->update([
                'status' => 2
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        // $data = [
        //     'patientlog'  => patient_log::where('type', "1")->where('status', "1")->get(),
        //     'sex'   => sexes::get(),
        //     'complete' => 'เพิ่มข้อมูลสำเร็จ'
        // ];
        // return view('patientcheckbone.showdata')->with('data', $data);
        return redirect()->route('patientcheckbone')->with('complete', "เพิ่มข้อมูลสำเร็จ");
    }

    public function addPatientChildTreatment(Request $request)
    {
        $patient_history = new patient_history();
        $patient_history->patient_id = $request->patient_id;
        $patient_history->order_id = $request->order_id;
        $patient_history->patient_symptoms = $request->patientSymptoms;
        $patient_history->date_history = $request->dateHitsory;
        $patient_history->next_check = $request->nextDate;

        // $patient_logs = new patient_log();
        // $patient_logs->patient_id = $request->patient_id;
        // $patient_logs->type = 1;
        // $patient_logs->status = 2;

        $orders = new orders();
        $orders->patient_id = $request->patient_id;
        $orders->order_id = $request->order_id;
        $orders->date_order = $request->dateHitsory;
        $orders->discount =  is_null($request->discount_price) ? 0 : $request->discount_price;
        $orders->grandtotal = $request->grandtotal;

        for ($i = 0; $i < count($request->drug_id); $i++) {
            //Start a PurchaseDetail
            $orderDetail[] = [
                'order_id' => $request->order_id,
                'drug_id' => $request->drug_id[$i],
                'amount' => is_null($request->drug_qty[$i]) ?  1 : $request->drug_qty[$i],
                'price' => $request->drug_total_price[$i]
            ];
        }

        DB::beginTransaction();
        try {
            $patient_history->save();
            //$patient_logs->save();
            $orders->save();

            orders_detail::insert($orderDetail);
            patient_log::where('patient_id', $request->patient_id)->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->update([
                'status' => 2
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        // $data = [
        //     'patientlog'  => patient_log::where('type', "2")->where('status', "1")->get(),
        //     'sex'   => sexes::get(),
        //     'complete' => 'เพิ่มข้อมูลสำเร็จ'
        // ];
        // return view('patientcheckchild.showdata')->with('data', $data);
        return redirect()->route('patientcheckchild')->with('complete', "เพิ่มข้อมูลสำเร็จ");
    }

    public function sendpatientbone()
    {
        $data['patientlist'] = patient_list::where('type', "1")->get();
        $data['sex'] = sexes::get();
        return view('sendpatientbone.showdata')->with('data', $data);
    }

    public function sendpatientchild()
    {
        $data['patientlist'] = patient_list::where('type', "2")->get();
        $data['sex'] = sexes::get();
        return view('sendpatientchild.showdata')->with('data', $data);
    }

    public function donepatientbone()
    {
        $data['patientlog'] = patient_log::where('type', "1")->where('status', "2")->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();
        $data['sex'] = sexes::get();
        return view('donepatientbone.showdata')->with('data', $data);
    }

    public function donepatientchild()
    {
        $data['patientlog'] = patient_log::where('type', "2")->where('status', "2")->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();
        $data['sex'] = sexes::get();
        return view('donepatientchild.showdata')->with('data', $data);
    }

    public function startPatientBoneLog(Request $request)
    {
        $patient_log = new patient_log();
        $patient_log->patient_id = $request->patient_id;
        $patient_log->type = 1;
        $patient_log->status = 1;
        $patient_log->save();

        // return redirect()->route('sendpatientbone');
        return response([
            'success' => true,
            'message' => "ส่งรายชื่อคนไข้เรียบร้อยแล้ว"
        ]);
    }

    public function CheckDataBone(Request $request)
    {
        $count_data = patient_log::where('type', "1")->where('patient_id', $request->patient_id)->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->count();
        echo json_encode(array("count_data" => $count_data));
    }

    public function CheckDataChild(Request $request)
    {
        $count_data = patient_log::where('type', "2")->where('patient_id', $request->patient_id)->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->count();
        echo json_encode(array("count_data" => $count_data));
    }

    public function startPatientChildLog(Request $request)
    {
        $patient_log = new patient_log();
        $patient_log->patient_id = $request->patient_id;
        $patient_log->type = 2;
        $patient_log->status = 1;
        $patient_log->save();

        // return redirect()->route('sendpatientchild');
        return response([
            'success' => true,
            'message' => "ส่งรายชื่อคนไข้เรียบร้อยแล้ว"
        ]);
    }

    public function addpatientbone(Request $request)
    {
        // dd($request->file('users_image'));

        $patient_list = new patient_list();
        $patient_list->patient_id = $request->patient_id;
        $patient_list->name = $request->name;
        $patient_list->nickname = $request->nickname;
        $patient_list->tel = $request->tel;
        $patient_list->address = $request->address;
        $patient_list->sex = $request->sex;
        $patient_list->birthdate = $request->birthdate;
        $patient_list->drug_allergy = $request->drug_allergy;

        $patient_list->line_id = $request->line_id;
        $patient_list->type = $request->type;

        //Encode Image Name
        if ($request->file('users_image') != null) {
            $users_image = $request->file('users_image');
            // $users_image = is_null($request->file('users_image')) ? 0 : $request->file('users_image');
            //Generate Image Name
            $name_gen = hexdec(uniqid());
            //Get Image Extension
            $users_image_ext = strtolower($users_image->getClientOriginalExtension());
            $users_image_name = $name_gen . '.' . $users_image_ext;
            $fullpathusers_image = env('UPLOAD_IMG_PATIENT_MASTER_PATH') . $users_image_name;

            $patient_list->users_image = $fullpathusers_image;

            //upload image
            $users_image->move(env('UPLOAD_IMG_PATIENT_MASTER_PATH'), $users_image_name);
        } else {
            $patient_list->users_image = 0;
        }

        $patient_list->save();

        return redirect()->back()->with('success', "เพิ่มข้อมูลสำเร็จ");
        // return redirect()->back()->with('success', "เพิ่มข้อมูลสำเร็จ");
    }

    public function editpatientbone($id)
    {
        $data['patient_list'] = patient_list::where('patient_id', $id)->get();
        $data['sex'] = sexes::get();
        return view('patient_bone.edit')->with('data', $data);
    }

    public function updatepatientbone(Request $request)
    {
        // dd($request);
        $id = $request->patient_id;
        $users_image = $request->file('users_image');
        if ($users_image != null) {
            //Generate Image Name
            $name_gen = hexdec(uniqid());
            //Get Image Extension
            $image_ext = strtolower($users_image->getClientOriginalExtension());
            $users_image_name = $name_gen . '.' . $image_ext;
            $fullpathusers_image = env('UPLOAD_IMG_PATIENT_MASTER_PATH') . $users_image_name;
            patient_list::where('patient_id', $id)->update([
                'users_image' => $fullpathusers_image,
                'name' => $request->patient_name,
                'nickname' => $request->patient_nickname,
                'tel' => $request->patient_tel,
                'address' => $request->patient_address,
                'sex' => $request->patient_sex,
                'birthdate' => $request->patient_birthdate,
                'drug_allergy' => $request->patient_drug_allergy,
                'line_id' => $request->patient_line_id
            ]);
            $users_image->move(env('UPLOAD_IMG_PATIENT_MASTER_PATH'), $users_image_name);
        } else {
            patient_list::where('patient_id', $id)->update([
                'name' => $request->patient_name,
                'nickname' => $request->patient_nickname,
                'tel' => $request->patient_tel,
                'address' => $request->patient_address,
                'sex' => $request->patient_sex,
                'birthdate' => $request->patient_birthdate,
                'drug_allergy' => $request->patient_drug_allergy,
                'line_id' => $request->patient_line_id
            ]);
        }
        return redirect()->route('patientbone')->with('edit', "แก้ไขข้อมูลคนไข้สำเร็จ");
    }



    //---------------------------------------------------------------------------------------------------------------------
    public function patientchild()
    {
        $data['patientlist'] = patient_list::where('type', "2")->get();
        $data['sex'] = sexes::get();
        return view('patient_child.showdata')->with('data', $data);
    }

    public function addpatientchild(Request $request)
    {
        // dd($request->file('users_image'));

        $patient_list = new patient_list();
        $patient_list->patient_id = $request->patient_id;
        $patient_list->name = $request->name;
        $patient_list->nickname = $request->nickname;
        $patient_list->tel = $request->tel;
        $patient_list->address = $request->address;
        $patient_list->sex = $request->sex;
        $patient_list->birthdate = $request->birthdate;
        $patient_list->drug_allergy = $request->drug_allergy;

        $patient_list->line_id = $request->line_id;
        $patient_list->type = $request->type;

        //Encode Image Name
        if ($request->file('users_image') != null) {
            $users_image = $request->file('users_image');
            // $users_image = is_null($request->file('users_image')) ? 0 : $request->file('users_image');
            //Generate Image Name
            $name_gen = hexdec(uniqid());
            //Get Image Extension
            $users_image_ext = strtolower($users_image->getClientOriginalExtension());
            $users_image_name = $name_gen . '.' . $users_image_ext;
            $fullpathusers_image = env('UPLOAD_IMG_PATIENT_MASTER_PATH') . $users_image_name;

            $patient_list->users_image = $fullpathusers_image;

            //upload image
            $users_image->move(env('UPLOAD_IMG_PATIENT_MASTER_PATH'), $users_image_name);
        } else {
            $patient_list->users_image = 0;
        }

        $patient_list->save();

        return redirect()->back()->with('success', "เพิ่มข้อมูลสำเร็จ");
        // return redirect()->back()->with('success', "เพิ่มข้อมูลสำเร็จ");
    }

    public function editpatientchild($id)
    {
        $data['patient_list'] = patient_list::where('patient_id', $id)->get();
        $data['sex'] = sexes::get();
        return view('patient_child.edit')->with('data', $data);
    }

    public function updatepatientchild(Request $request)
    {
        // dd($request);
        $id = $request->patient_id;
        $users_image = $request->file('users_image');
        if ($users_image != null) {
            //Generate Image Name
            $name_gen = hexdec(uniqid());
            //Get Image Extension
            $image_ext = strtolower($users_image->getClientOriginalExtension());
            $users_image_name = $name_gen . '.' . $image_ext;
            $fullpathusers_image = env('UPLOAD_IMG_PATIENT_MASTER_PATH') . $users_image_name;
            patient_list::where('patient_id', $id)->update([
                'users_image' => $fullpathusers_image,
                'name' => $request->patient_name,
                'nickname' => $request->patient_nickname,
                'tel' => $request->patient_tel,
                'address' => $request->patient_address,
                'sex' => $request->patient_sex,
                'birthdate' => $request->patient_birthdate,
                'drug_allergy' => $request->patient_drug_allergy,
                'line_id' => $request->patient_line_id
            ]);
            $users_image->move(env('UPLOAD_IMG_PATIENT_MASTER_PATH'), $users_image_name);
        } else {
            patient_list::where('patient_id', $id)->update([
                'name' => $request->patient_name,
                'nickname' => $request->patient_nickname,
                'tel' => $request->patient_tel,
                'address' => $request->patient_address,
                'sex' => $request->patient_sex,
                'birthdate' => $request->patient_birthdate,
                'drug_allergy' => $request->patient_drug_allergy,
                'line_id' => $request->patient_line_id
            ]);
        }
        return redirect()->route('patientchild')->with('edit', "แก้ไขข้อมูลคนไข้สำเร็จ");
    }

    public function countLog(Request $request){
        $type = $request->type;
        $status = $request->status;
        $count_data = patient_log::where('type', $type)->where('status', $status)->wheredate('created_at', '=', Carbon::now()->format('Y-m-d'))->get()->count();
        // dd($count_data);
        echo json_encode(array("count_data" => $count_data));
    }
}
