<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request) {
        $product_search = $request->input('product_search');
        $company_search = $request->input('company_search');

        $query = Product::query();

        if(!empty($product_search)) {
            $query->where('product_name', 'LIKE', "%{$product_search}%");
        }

        if(!empty($company_search)) {
            $query->where('company_id', 'LIKE', $company_search);
        }

        $products = $query->paginate(10);
        $companies = Company::all();
        
        return view('products.index', compact('products', 'product_search', 'company_search', 'companies'));
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
            'img_path' => 'nullable|image|max:2048',
        ]);

        $product = new Product([
            'product_name' => $request->get('product_name'),
            'company_id' => $request->get('company_id'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'comment' => $request->get('comment'),
        ]);

        if($request->hasFile('img_path')){ 
            $filename = $request->img_path->getClientOriginalName();
            $filePath = $request->img_path->storeAs('products', $filename, 'public');
            $product->img_path = '/storage/' . $filePath;
        }

        $product->save();
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

        $product->product_name = $request->product_name;
        $product->company_id = $request->company_id;
        $product->price = $request->price;
        $product->stock = $request->stock;

        $product->save();

        return back();
    }

    public function destroy(Product $product) {
        $product->delete();
        return redirect('/products');
    }
}
