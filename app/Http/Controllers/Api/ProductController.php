<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    //
    function index(){
        $products = new Product;
        $draw   = $_GET['draw'];
        $start  = $_GET['start'];
        $length = $_GET['length'];
        $search = $_GET['search']['value'];
        $order  = $_GET['order'];

        $columns = [
            'id',
            'name',
            'price',
            'qty',
        ];

        if(!empty($search))
        {
            $products = $products->where('name','LIKE','%'.$search.'%');
            $products = $products->orwhere('price','LIKE','%'.$search.'%');
            $products = $products->orwhere('qty','LIKE','%'.$search.'%');
            $products = $products->orwhere('status','LIKE','%'.$search.'%');
        }

        $total = $products->count();
        $products = $products->orderby($columns[$order[0]['column']], $order[0]['dir']);
        $products = $products->skip($start)->take($length);
        $products = $products->get();

        $results  = [];
        foreach($products as $key => $product)
        {
            $results[$key][] = $key+1;
            $results[$key][] = $product->name;
            $results[$key][] = $product->price_format;
            $results[$key][] = $product->qty;
            // $action = '<a href="javascript:void(0)" onclick="editCat('.$product->id.')" class="btn btn-warning text-strong">Edit</a> ';
            $action = '<a href="javascript:void(0)" onclick="deleteCat('.$product->id.')" class="btn btn-danger text-strong btn-sm">Hapus</a>';
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
            'name'         => 'required|unique:products',
            'description'  => 'required',
            'price'        => 'required|integer',
            'qty'          => 'required|integer',
            'images.*'     => 'required',
            'categories.*' => 'required',
            'user'         => 'required',
        ]);
        $product = Product::create($request->except(['images','categories','user']));
        if($product)
        {
            $product->images()->attach($request->images);
            $product->categories()->attach($request->categories);
            // $product->user()->attach($request->user);
        }
        return response()->json($product,200);
    }

    function single(Product $product)
    {
        $product->categories;
        $product->images;
        $product->user;
        return response()->json($product,200);
    }

    function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|unique:products,id,' . $product->id,
            'description' => 'required',
            'price'       => 'required|integer',
            'qty'         => 'required|integer',
        ]);

        $product->update($request->all());

        return response()->json($product,200);
    }

    function delete(Product $product)
    {
        $product->delete();
        return response()->json($product,200);
    }
}
