<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function index(Request $request) {
        $product_search = $request->input('product_search');
        $company_search = $request->input('company_search');
        $search = $request->input('search');
        $sortColumn = $request->input('sort', 'id');
        $sortOrder = $request->input('order', 'desc');

        $query = Product::query();

        if(!empty($product_search)) {
            $query->where('product_name', 'LIKE', "%{$product_search}%");
        }

        if(!empty($company_search)) {
            $query->where('company_id', 'LIKE', $company_search);
        }

        // 最小価格が指定されている場合、その価格以上の商品をクエリに追加
        if($min_price = $request->min_price){
            $query->where('price', '>=', $min_price);
        }

        // 最大価格が指定されている場合、その価格以下の商品をクエリに追加
        if($max_price = $request->max_price){
            $query->where('price', '<=', $max_price);
        }

        // 最小在庫数が指定されている場合、その在庫数以上の商品をクエリに追加
        if($min_stock = $request->min_stock){
            $query->where('stock', '>=', $min_stock);
        }

        // 最大在庫数が指定されている場合、その在庫数以下の商品をクエリに追加
        if($max_stock = $request->max_stock){
            $query->where('stock', '<=', $max_stock);
        }

        $query->orderBy($sortColumn, $sortOrder);

        $products = $query->paginate(10);
        $companies = Company::all();

        return view('products.index', compact('products', 'product_search', 'company_search', 'companies', 'sortColumn', 'sortOrder'));
    }

    public function search(Request $request) {
        $productName = $request->input('product_search');
        $companyId = $request->input('company_search');
    
        $products = Product::query();
    
        if ($productName) {
            $products->where('product_name', 'LIKE', "%{$productName}%");
        }
    
        if ($companyId) {
            $products->where('company_id','LIKE', $companyId);
        }
    
        $searchResults = $products->get();
        $companies = Company::all();
    
        return view('search_results', compact('searchResults', 'companies'));
    }

    public function create() {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    public function store(Request $request) {
        $request->validate([
            'product_name' => 'required', 
            'company_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'nullable', 
            'img_path' => 'nullable', 
        ]);

        $product = new Product([
            'product_name' => $request->get('product_name'),
            'company_id' => $request->get('company_id'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'comment' => $request->get('comment'),
            'img_path' => $request->get('img_path'),
        ]);

        try {
            DB::beginTransaction();

            $product->product_name = $request->product_name;
            $product->company_id = $request->company_id;
            $product->price= $request->price;
            $product->stock = $request->stock;
            $product->comment = $request->comment;

            if($request->hasFile('img_path')){ 
                $filename = $request->img_path->getClientOriginalName();
                $filePath = $request->img_path->storeAs('products', $filename, 'public');
                $product->img_path = '/storage/' . $filePath;
            }

            $product->save();
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        return back();
    }

    public function show(Product $product) {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product) {
        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    public function update(Request $request, Product $product) {
        $request->validate([
            'product_name' => 'required',
            'company_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $product->product_name = $request->product_name;
            $product->company_id = $request->company_id;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->comment = $request->comment;

            if($request->hasFile('img_path')){ 
                $filename = $request->img_path->getClientOriginalName();
                $filePath = $request->img_path->storeAs('products', $filename, 'public');
                $product->img_path = '/storage/' . $filePath;
            }

            $product->save();
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        return back();
    }
    
    public function destroy(Request $request, Product $product) {
        try {
            DB::beginTransaction();
            $product = Product::findOrFail($request->id);
            $product->delete();
            DB::commit();
            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Failed to delete product'], 500);
        }
    }
}
