<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
USE App\Models\Store;
use App\Models\Transection;

class StoreController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:api');
    }

    public function index(){

        // $store = Store::orderBy('id','asc')->get();
        // return $store;
        // asc ລຽງແຕ່ນ້ອຍຫາໃຫຍ່
        // desc ລຽງແຕ່ໃຫຍ່ຫານ້ອຍ

        $sort = \Request::get('sort');
        $perpage = \Request::get('perpage');
        $search = \Request::get('search');

        $store = Store::orderBy('id',$sort)
        // ->where('name','LIKE',"%{$search}%")
        // ->where('price_sell','LIKE',"%{$search}%")
        ->where(
            function($query) use ($search){
                $query->where('name','LIKE',"%{$search}%")
                ->orWhere('price_buy','LIKE',"%{$search}%");
            }
        )
        ->paginate($perpage)
        ->toArray();

        return array_reverse($store);

    }

    public function add(Request $request){
        try {

            // ເສັ້ນທາງບັນທຶກຮູບພາບ
            $upload_path = "assets/img";

            if($request->file('image')){
                // ສ້າງຊື່ຮູບພາບໃໝ່
                $new_name_img = time().".".$request->image->getClientOriginalExtension();

                // ອັບໂຫຼດ
                $request->image->move(public_path($upload_path),$new_name_img);
            } else {
                $new_name_img = '';
            }


            $store = new Store([
                'name' => $request->name,
                'image' => $new_name_img,
                'amount' => $request->amount,
                'price_buy' => $request->price_buy,
                'price_sell' => $request->price_sell,
            ]); 
            $store->save();
            $product_id = $store->id;


            /// ບັນທຶກ ລາຍຈ່າຍສັ່ງຊື້

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
                "tran_id" => "EXP".$number,
                "tran_type" => "expense",
                "product_id" => $product_id,
                "amount" => $request->amount,
                "price" => $request->amount*$request->price_buy,
                "tran_detail" => " ຊື້ສິນຄ້າເຂົ້າໃໝ່: ".$request->name
            ]);
            $tran->save();

            $success = true;
            $message = 'ບັນທຶກຂໍ້ມູນສຳເລັດ!';

        } catch (\Illuminate\Database\QueryException $ex) {

            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);


    }

    public function edit($id){

        $store = Store::find($id);
        return $store;

    }

    public function update($id,Request $request){

        try {

            $store = Store::find($id);
            
            // ເສັ້ນທາງບັນທຶກຮູບພາບ
            $upload_path = "assets/img";

            if($request->file('image')){

                // ລຶຶບຂໍ້ມູນເກົ້າອອກ
                if($store->img){
                    if(file_exists($upload_path."/".$store->img)){
                        unlink($upload_path."/".$store->img);
                    }
                }

                

                // ສ້າງຊື່ຮູບພາບໃໝ່
                $new_name_img = time().".".$request->image->getClientOriginalExtension();

                // ອັບໂຫຼດ
                $request->image->move(public_path($upload_path),$new_name_img);

                $store->update([
                    'name' => $request->name,
                    'image' => $new_name_img ,
                    'amount' => $request->amount,
                    'price_buy' => $request->price_buy,
                    'price_sell' => $request->price_sell,
                ]);

            } else {

                if($request->image){
                    $store->update([
                        'name' => $request->name,
                        // 'image' => ,
                        'amount' => $request->amount,
                        'price_buy' => $request->price_buy,
                        'price_sell' => $request->price_sell,
                    ]);
                } else {

                    // ລຶຶບຂໍ້ມູນເກົ້າອອກ
                if($store->image){
                            if(file_exists($upload_path."/".$store->image)){
                                unlink($upload_path."/".$store->image);
                            }
                        }

                        $store->update([
                            'name' => $request->name,
                            'image' => '',
                            'amount' => $request->amount,
                            'price_buy' => $request->price_buy,
                            'price_sell' => $request->price_sell,
                        ]);

                }

              
            }
 


            

            $success = true;
            $message = 'ອັບເດດຂໍ້ມູນ ສຳເລັດ!';

        } catch (\Illuminate\Database\QueryException $ex) {

            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);

    }

    public function delete($id){

        try {

            $store = Store::find($id);
            $store->delete();

            $success = true;
            $message = 'ລຶບຂໍ້ມູນ ສຳເລັດ!';

        } catch (\Illuminate\Database\QueryException $ex) {

            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);

    }
}
