<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use DataTables;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::orderBy('entry_date','desc')->get();
        if($request->ajax()){
            $allData = DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('picture', function($row){
                    if($row->picture!=null){
                        $image = '<img src="/image/'. $row->picture .'" width="100px">';
                    } else {
                        $image = '<img src="/images/watch-2.jpg" width="100px">';
                    }


                    return $image;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.
                        $row->id.'" data-original-title="Edit" " class="edit editProduct text-success mr-2"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.
                        $row->id.'" data-original-title="Delete" " class="delete deleteProduct text-danger mr-2"><i class="nav-icon i-Close-Window font-weight-bold"></i></a>';
                    return $btn;
                })
                ->rawColumns(['picture','action'])
                ->order(function ($query) {
                    if (request()->has('entry_date')) {
                        $query->orderBy('entry_date', 'desc');
                    }
                })
                ->toJson();
            return $allData;
        }

        return view('products.index')->with('products', $products);
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
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $input = $request->all();
        $path_picture = "";

        if ($image = $request->file('product_picture')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $path_picture = "$profileImage";
        }
        if($request->typeAction == "create"){
            $new_product = new Product();
            $new_product->code = $request->product_cod;
            $new_product->name = $request->product_name;
            $new_product->quantity = $request->product_quantity;
            $new_product->price = $request->product_price;
            $new_product->due_date = date('Y-m-d', strtotime($request->product_duedate));
            $new_product->entry_date = date('Y-m-d', strtotime($request->product_entrydate));
            $new_product->picture = $path_picture;
            $new_product->save();
        } else {
            $product = Product::find($request->product_id);
            $product->code = $request->product_cod;
            $product->name = $request->product_name;
            $product->quantity = $request->product_quantity;
            $product->price = $request->product_price;
            $product->due_date = date('Y-m-d', strtotime($request->product_duedate));
            $product->entry_date = date('Y-m-d', strtotime($request->product_entrydate));
            $product->picture = $path_picture;
            $product->update();
        }


        return response()->json(['success'=>'Product saved successfully. '.$path_picture]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();

        return response()->json(['success'=>'Product deleted successfully.']);
    }

    public function findByCode(Request $request){
        $same_code = Product::where('code', '=', $request->code)->count();
        return ($same_code > 0) ? "exists": "notexists";

    }

}
