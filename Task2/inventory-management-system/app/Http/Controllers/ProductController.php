<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * ProductController
 *
 * Handles full CRUD operations for products:
 *   - index   : list all products
 *   - create  : show create form
 *   - store   : persist new product
 *   - edit    : show edit form with pre-filled data
 *   - update  : persist updated product
 *   - destroy : delete product (only if no sales exist)
 */
class ProductController extends Controller
{
    /**
     * Validation rules shared by store and update.
     */
    private function validationRules(): array
    {
        return [
            'name'           => 'required|string|max:255',
            'purchase_price' => 'required|numeric|gt:0',
            'sell_price'     => 'required|numeric|gt:0',
            'stock'          => 'required|integer|min:0',
        ];
    }

    /**
     * Display a listing of all products.
     */
    public function index()
    {
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Validate and store a newly created product.
     */
    public function store(Request $request)
    {
        // Validate input fields
        $validated = $request->validate($this->validationRules());

        Product::create($validated);

        return redirect()->route('products.index')
                         ->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing an existing product.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Validate and update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        // Validate input fields (same rules as create)
        $validated = $request->validate($this->validationRules());

        $product->update($validated);

        return redirect()->route('products.index')
                         ->with('success', 'Product updated successfully.');
    }

    /**
     * Delete the specified product.
     * Prevents deletion if the product has associated sales.
     */
    public function destroy(Product $product)
    {
        // Check if product has any related sales
        if ($product->sales()->exists()) {
            return redirect()->route('products.index')
                             ->with('error', 'Cannot delete this product because it has associated sales.');
        }

        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'Product deleted successfully.');
    }
}
