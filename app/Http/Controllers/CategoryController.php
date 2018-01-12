<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Category;
class CategoryController extends Controller
{

    public function index()
    {
         $categories = new Category();
        $categories = $categories->first()->paginate(5);
        $response = [
            'pagination' => [
                'total' => $categories->total(),
                'per_page' => $categories->perPage(),
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'from' => $categories->firstItem(),
                'to' => $categories->lastItem()
            ],
            'categories' => $categories
        ];

        return response()->json($response);
    }

    public function store(Request $request)
    {   
        if(!isset($request->id)){
        $category = new Category([
              'name' => $request->get('name'),
              'description' =>  $request->get('description')
        ]);
        }else{
            $category = Category::find($request->id);
            $category->name = $request->get('name');
            $category->description = $request->get('description');          
        }      
        $category->save();
        return response()->json('Successfully saved');
    }

    public function destroy($id)
    {
      $category = Category::find($id);
      $category->delete();
      return response()->json('Successfully Deleted');
    }
    
}