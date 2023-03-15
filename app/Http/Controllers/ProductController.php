<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  
    public function index()
    {    
        $products = Product::with('variantPrices.variantOne', 'variantPrices.variantTwo', 'variantPrices.variantThree')->paginate(5);
        $variants = Variant::with('productVariants')->get();
     // dd($variants);
        return view('products.index',compact('products','variants'));
    }

 
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }


    public function store(Request $request)
    {

    }



    public function show($product)
    {

    }


    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }


    public function update(Request $request, Product $product)
    {
        //
    }

 
    public function destroy(Product $product)
    {
        //
    }
    public function search(Request $request)
{
    //dd($request);
    $selectedVariantIds = $request->input('variant_id');
    $minPrice = $request->input('price_from');
    $maxPrice = $request->input('price_to');
    $name = $request->input('title');
    $date = $request->input('date');


    $query = Product::query();

    if ($selectedVariantIds) {
        $query->whereHas('variantPrices', function ($subQuery) use ($selectedVariantIds) {
            $subQuery->whereIn('product_variant_one', $selectedVariantIds)
                ->orWhereIn('product_variant_two', $selectedVariantIds)
                ->orWhereIn('product_variant_three', $selectedVariantIds);
        });
    }

    if ($minPrice !== null && $maxPrice !== null) {
        $query->whereHas('variantPrices', function ($subQuery) use ($minPrice, $maxPrice) {
            $subQuery->whereBetween('price', [$minPrice, $maxPrice]);
        });
    }

    if ($name !== null) {
        $query->where('title', 'like', '%'.$name.'%');
    }

    if ($date !== null ) {
        $query->where('created_at', [$date]);
    }

    $products = $query->with('variantPrices.variantOne', 'variantPrices.variantTwo', 'variantPrices.variantThree')->get();
    // $selectedVariantIds = $request->input('variant_id');
    // $query = Product::query();
    // if ($selectedVariantIds) {
    //   $query->whereHas('variantPrices', function ($subQuery) use ($selectedVariantIds) {
    //     $subQuery->whereIn('product_variant_one', $selectedVariantIds)
    //       ->orWhereIn('product_variant_two', $selectedVariantIds)
    //       ->orWhereIn('product_variant_three', $selectedVariantIds);
    //   });
    // }
    // $products = $query->with('variantPrices.variantOne', 'variantPrices.variantTwo', 'variantPrices.variantThree')->get();

    $variants = Variant::with('productVariants')->get();
    return view('products.index', compact('products','variants','selectedVariantIds'));
}
}
