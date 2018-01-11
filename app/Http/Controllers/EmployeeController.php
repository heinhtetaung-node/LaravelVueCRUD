<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = new Employee();
        if($request->name!=""){
            $employees = $employees->where('name', 'like', '%'.$request->name.'%');
        }
        if($request->email!=""){
            $employees = $employees->where('email', 'like', '%'.$request->email.'%');
        }
        $employees = $employees->latest()->paginate(5);

        $response = [
            'pagination' => [
                'total' => $employees->total(),
                'per_page' => $employees->perPage(),
                'current_page' => $employees->currentPage(),
                'last_page' => $employees->lastPage(),
                'from' => $employees->firstItem(),
                'to' => $employees->lastItem()
            ],
            'employees' => $employees
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
        // $validator = Validator::make($request->all(), [
        //     "name" => "required",
        //     "email" => "required"
        // ]);
        // if ($validator->fails()) {
        //     $messages = $validator->messages();
        //      $response = [
        //         'messages' => $messages
        //      ];

        //     return response()->json($response);
        // }
        // var_dump($request->all()); exit;
        if(!isset($request->id)){
            $employee = new Employee([
              'name' => $request->get('name'),
              'email' => $request->get('email'),
              'address'=>$request->get('address')
            ]);
        }else{
            $employee = Employee::find($request->id);
            $employee->name = $request->get('name');
            $employee->email = $request->get('email');
            $employee->address = $request->get('address');            

        }
        $employee->save();
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
        $employee = Employee::find($id);
        return response()->json($employee);
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
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $employee = Employee::find($id);
      $employee->delete();
      return response()->json('Successfully Deleted');
    }
}
