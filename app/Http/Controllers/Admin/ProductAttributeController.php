<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Http\Controllers\Controller;

class ProductAttributeController extends Controller
{
    
    public function loadAttributes()
    {
        $attributes = Attribute::all();

        return response()->json($attributes);
    }

   
    public function productAttributes(Request $request)
    {
        $product = Product::findOrFail($request->id);

        return response()->json($product->attributes);
    }

    
    public function loadValues(Request $request)
    {
        $attribute = Attribute::findOrFail($request->id);

        return response()->json($attribute->values);
    }

    
    public function addAttribute(Request $request)
    {
        $productAttribute = ProductAttribute::create($request->data);

        if ($productAttribute) {
            return response()->json(['message' => 'Product attribute added successfully.']);
        } else {
            return response()->json(['message' => 'Something went wrong while submitting product attribute.']);
        }
    }

   
    public function deleteAttribute(Request $request)
    {
        $productAttribute = ProductAttribute::findOrFail($request->id);
        $productAttribute->delete();

        return response()->json(['status' => 'success', 'message' => 'Product attribute deleted successfully.']);
    }
}