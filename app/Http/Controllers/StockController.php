<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\stocks_log;
use App\Models\drugs_list;
use App\Models\stocks_detail;
use Carbon\Carbon;

class StockController extends Controller
{
    public function stock()
    {
        $data['druglist'] = DB::table('drugs_lists')->get();
        return view('stock.showdata')->with('data', $data);
    }
    public function addStock(Request $request)
    {
        $stocks_log = new stocks_log();
        $stocks_log->stock_id = $request->stock_id;
        $stocks_log->status = 1;

        for ($i = 0; $i < count($request->drug_id); $i++) {

            $stocksDetail[] = [
                'stock_id' => $request->stock_id,
                'drug_id' => $request->drug_id[$i],
                'amount_old' => 0,
                'amount' => $request->drug_qty[$i],
                'amount_total' => 0,
                'created_at' => Carbon::now()
            ];

            $drug_qtyOld = drugs_list::where('drug_id', $request->drug_id[$i])->get('item_qty');
            foreach ($drug_qtyOld as $row) {
                $drug_qtyOld =  $row->toArray();
            }
            $data['drug_qtyOld'][$i] = $drug_qtyOld['item_qty'];
        }
        DB::beginTransaction();
        try {
            $stocks_log->save();
            stocks_detail::insert($stocksDetail);

            for ($i = 0; $i < count($request->drug_id); $i++) {
                drugs_list::where('drug_id', $request->drug_id[$i])->update([
                    'item_qty' => $data['drug_qtyOld'][$i] + $request->drug_qty[$i]
                ]);
                stocks_detail::where('drug_id', $request->drug_id[$i])->where('stock_id', $request->stock_id)->update([
                    'amount_old' => $data['drug_qtyOld'][$i],
                    'amount_total' => $data['drug_qtyOld'][$i] + $request->drug_qty[$i]
                ]);
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        return redirect()->route('stock')->with('success', "อัพเดทสต๊อกเรียบร้อยแล้ว");
    }
}
