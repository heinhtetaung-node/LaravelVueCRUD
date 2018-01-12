<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
     {    

         $suppliers = new Supplier();
         if($request->name!=""){
             $suppliers = $suppliers->where('name', 'like', '%'.$request->name.'%');
         }
         if($request->email!=""){
             $suppliers = $suppliers->where('email', 'like', '%'.$request->email.'%');
         }
         $suppliers = $suppliers->latest()->paginate(5);


         $response = [
             'pagination' => [
                'total' => $suppliers->total(),
                'per_page' => $suppliers->perPage(),
                'current_page' => $suppliers->currentPage(),
                'last_page' => $suppliers->lastPage(),
                'from' => $suppliers->firstItem(),
                'to' => $suppliers->lastItem()
            ],
             'suppliers' => $suppliers
         ];

         return response()->json($response);
     }
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
         //
     }
     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {
         $rules = array(
                   'name' =>'required',
                   'email' => 'required|email',
                   'address' => 'required',
                   'phone' => 'required|numeric',
                 );

          $validator = Validator::make($request->all(), $rules);
        
          if ($validator->fails()) 
          {
              return response()->json(array('errors' => $validator->messages(), 'result' => false, 'message' => 'validation error'));
          }
        
         if(!isset($request->id)){
             $supplier = new Supplier([
               'name' => $request->get('name'),
               'email' => $request->get('email'),
               'address' => $request->get('address'),
               'phone' => $request->get('phone')
             ]);
         }else{
             $supplier = supplier::find($request->id);
             $supplier->name = $request->get('name');
             $supplier->email = $request->get('email');
             $supplier->address = $request->get('address');
             $supplier->phone = $request->get('phone');
         }
         $supplier->save();
         return response()->json('Successfully saved');
     }
     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function show($id)
     {
         //
     }
     /**
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit($id)
     {
         $supplier = Supplier::find($id);
         return response()->json($supplier);
     }
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request, $id)
     {
         $supplier = Supplier::find($id);
         $supplier->name = $request->get('name');
         $supplier->price = $request->get('price');
         $supplier->save();
         return response()->json('Successfully Updated');
     }
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy($id)
     {
       $supplier = Supplier::find($id);
       $supplier->delete();
       return response()->json('Successfully Deleted');
     }
}
