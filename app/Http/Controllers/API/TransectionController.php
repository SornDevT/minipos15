<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transection;
use App\Models\Store;
use App\Models\Bill;
use App\Models\Bill_List;

class TransectionController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:api');
    }

    public function add(Request $request){


        try {

            // ບັນທຶກຂໍ້ມູນ ໃບບິນ

            $bill_id='';
            $read_tran = Bill::all()->sortByDesc('id')->take(1)->toArray();
            foreach($read_tran as $new){
                $bill_id = $new['bill_id'];
            }

            if($bill_id!=''){
                $bill_id = (int)$bill_id+1; // 1+1 = 2
                $length = 5;
                $bill_id = substr(str_repeat(0,$length).$bill_id, - $length); //00002
            } else {
                $bill_id = 1;
                $length = 5;
                $bill_id = substr(str_repeat(0,$length).$bill_id, - $length); //00001
            }



            $bill = new Bill([
                'bill_id' => $bill_id,
                'customer_name' => $request->customer_name,
                'customer_tel' => $request->customer_tel
            ]);
            $bill->save();


            
            /// ບັນທຶກລາຍການ ເຄືອນໄຫວ
            foreach($request->listorder as $item){

                // gen id transection 
    
                $number='';
                $read_tran = Transection::all()->sortByDesc('id')->take(1)->toArray();
                foreach($read_tran as $new){
                    $number = $new['tran_id'];
                }
    
                if($number!=''){
                    $number1 = str_replace("INC","",$number); // INC00001 = 00001
                    $number2 = str_replace("EXP","",$number1);
                    $number3 = (int)$number2+1; // 1+1 = 2
                    $length = 5;
                    $number = substr(str_repeat(0,$length).$number3, - $length); //00002
                } else {
                    $number3 = 1;
                    $length = 5;
                    $number = substr(str_repeat(0,$length).$number3, - $length); //00001
                }
    
                $tran = new Transection([
                    "tran_id" => "INC".$number,
                    "tran_type" => "income",
                    "product_id" => $item["id"],
                    "amount" => $item["order_amount"],
                    "price" => $item["order_amount"]*$item["price_sell"],
                    "tran_detail" => $item["name"]
                ]);
                $tran->save();

                /// ບັນທຶກ ລາຍການ ໃບບິນ
                $bill_list = new Bill_List([
                    "bill_id" => $bill_id,
                    "name" => $item["name"],
                    "amount" => $item["order_amount"],
                    "price" => $item["price_sell"]
                ]);
                $bill_list->save();



                /// ຕັດສະຕ໋ອກສິນຄ້າ
                $store = Store::find($item["id"]);
                $store_update = Store::find($item["id"]);

                $store_update->update([
                    "amount" => $store->amount - $item["order_amount"]
                ]);

            }

           

            $success = true;
            $message = 'ບັນທຶກ ຂໍ້ມູນສຳເລັດ!';

        } catch (\Illuminate\Database\QueryException $ex) {

            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message,
            'bill_id' => $bill_id
        ];

        return response()->json($response);





     

    }
}
