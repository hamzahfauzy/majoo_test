<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //
    function index(){
        $categories = new Category;
        $draw   = $_GET['draw'];
        $start  = $_GET['start'];
        $length = $_GET['length'];
        $search = $_GET['search']['value'];
        $order  = $_GET['order'];

        $columns = [
            'id',
            'name',
        ];

        if(!empty($search))
        {
            $categories = $categories->where('name','LIKE','%'.$search.'%');
        }

        $total = $categories->count();
        $categories = $categories->orderby($columns[$order[0]['column']], $order[0]['dir']);
        $categories = $categories->skip($start)->take($length);
        $categories = $categories->get();

        $results  = [];
        foreach($categories as $key => $category)
        {
            $results[$key][] = $key+1;
            $results[$key][] = $category->name;
            $action = '<a href="javascript:void(0)" onclick="editCat('.$category->id.')" class="btn btn-warning text-strong">Edit</a> ';
            $action .= '<a href="javascript:void(0)" onclick="deleteCat('.$category->id.')" class="btn btn-danger text-strong">Hapus</a>';
            $results[$key][] = $action;
        }

        return [
            "draw" => $draw,
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $results
        ];
    }

    function create(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $cat = Category::create($request->all());
        return response()->json($cat,200);
    }

    function single(Category $category)
    {
        return response()->json($category,200);
    }

    function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $category->update($request->all());

        return response()->json($category,200);
    }

    function delete(Category $category)
    {
        $category->delete();
        return response()->json($category,200);
    }
}
