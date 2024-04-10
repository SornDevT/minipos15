<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
USE App\Models\Store;

class StoreController extends Controller
{
    //

    public function index(){

        // $store = Store::orderBy('id','asc')->get();
        // return $store;

        $store = Store::orderBy('id','asc')
        ->paginate(3)
        ->toArray();
        return array_reverse($store);

    }

    public function add(Request $request){
        try {

            $store = new Store([
                'name' => $request->name,
                // 'image' => ,
                'amount' => $request->amount,
                'price_buy' => $request->price_buy,
                'price_sell' => $request->price_sell,
            ]); 
            $store->save();

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
            
            $store->update([
                'name' => $request->name,
                // 'image' => ,
                'amount' => $request->amount,
                'price_buy' => $request->price_buy,
                'price_sell' => $request->price_sell,
            ]);

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