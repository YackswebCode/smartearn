<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class VendorProductController extends Controller
{
    /**
     * Display a listing of the vendor's products.
     */
    public function index()
    {
        $vendor = Auth::user();
        $products = Product::where('vendor_id', $vendor->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('vendor.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('vendor.products.form', [
            'product' => new Product(),
            'formAction' => route('vendor.products.store'),
            'formMethod' => 'POST',
            'buttonText' => 'Create Product'
        ]);
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $vendor = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|in:NGN,USD,GHS,XAF,KES',
            'category' => 'nullable|string|max:255',
            'type' => 'required|string|max:255',
            'commission_percent' => 'required|integer|min:0|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        // Generate slug from name (ensure uniqueness)
        $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();

        // Set vendor_id
        $validated['vendor_id'] = $vendor->id;

        // Default rating
        $validated['rating'] = 0;

        Product::create($validated);

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $vendor = Auth::user();
        $product = Product::where('vendor_id', $vendor->id)->findOrFail($id);

        return view('vendor.products.form', [
            'product' => $product,
            'formAction' => route('vendor.products.update', $product),
            'formMethod' => 'POST', // We'll use method spoofing for PUT
            'buttonText' => 'Update Product'
        ]);
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, $id)
    {
        $vendor = Auth::user();
        $product = Product::where('vendor_id', $vendor->id)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|in:NGN,USD,GHS,XAF,KES',
            'category' => 'nullable|string|max:255',
            'type' => 'required|string|max:255',
            'commission_percent' => 'required|integer|min:0|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload: delete old if new uploaded
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        // Update slug only if name changed (optional)
        if ($product->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();
        }

        $product->update($validated);

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product.
     */
    public function destroy($id)
    {
        $vendor = Auth::user();
        $product = Product::where('vendor_id', $vendor->id)->findOrFail($id);

        // Delete associated image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}