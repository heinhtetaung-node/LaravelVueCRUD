<?php
namespace App\Http\Controllers\Invoices;

use Illuminate\Http\Request;
use App\Model\Invoices\Category;

use Validator;

class InvCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categorys = new Category();
        if($request->name!=""){
            $categorys = $categorys->where('name', 'like', '%'.$request->name.'%');
        }
        if($request->price!=""){
            $categorys = $categorys->where('price', 'like', '%'.$request->price.'%');
        }
        $categorys = $categorys->latest()->paginate(5);

        $response = [
            'pagination' => [
                'total' => $categorys->total(),
                'per_page' => $categorys->perPage(),
                'current_page' => $categorys->currentPage(),
                'last_page' => $categorys->lastPage(),
                'from' => $categorys->firstcategory(),
                'to' => $categorys->lastcategory()
            ],
            'categorys' => $categorys
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
                'name' => 'required',
                'parent_id'=>'required'       
            );
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) 
        {
            return response()->json(array('errors' => $validator->messages(), 'result' => false, 'message' => 'validation error'));
        }
        
        if(!isset($request->id)){
            $category = new Category([
              'name' => $request->get('name'),
              'parent_id' => $request->get('parent_id')
            ]);
        }else{
            $category = Category::find($request->id);
            $category->name = $request->get('name');
            $category->parent_id = $request->get('parent_id');            
        }
        $category->save();
        return response()->json(['result' => true, 'message' => 'Successfully saved']);
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
        $category = Category::find($id);
        return response()->json($category);
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
        $category = Category::find($id);
        $category->name = $request->get('name');
        $category->price = $request->get('price');
        $category->save();
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
      $category = Category::find($id);
      $category->delete();
      return response()->json('Successfully Deleted');
    }
}