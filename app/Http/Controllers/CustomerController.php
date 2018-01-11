<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {    

         $customers = new Customer();
         if($request->name!=""){
             $customers = $customers->where('name', 'like', '%'.$request->name.'%');
         }
         if($request->email!=""){
             $customers = $customers->where('email', 'like', '%'.$request->email.'%');
         }
         $customers = $customers->latest()->paginate(5);


         $response = [
             'pagination' => [
                'total' => $customers->total(),
                'per_page' => $customers->perPage(),
                'current_page' => $customers->currentPage(),
                'last_page' => $customers->lastPage(),
                'from' => $customers->firstItem(),
                'to' => $customers->lastItem()
            ],
             'customers' => $customers
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
         if(!isset($request->id)){
             $customer = new Customer([
               'name' => $request->get('name'),
               'email' => $request->get('email'),
               'address' => $request->get('address'),
               'phone' => $request->get('phone')
             ]);
         }else{
             $customer = Customer::find($request->id);
             $customer->name = $request->get('name');
             $customer->email = $request->get('email');
             $customer->address = $request->get('address');
             $customer->phone = $request->get('phone');
         }
         $customer->save();
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
         $customer = Customer::find($id);
         return response()->json($customer);
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
         $customer = Customer::find($id);
         $customer->name = $request->get('name');
         $customer->price = $request->get('price');
         $customer->save();
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
       $customer = Customer::find($id);
       $customer->delete();
       return response()->json('Successfully Deleted');
     }

}
