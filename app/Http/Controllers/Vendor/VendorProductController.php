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
    public function index()
    {
        $vendor = Auth::user();

        $products = Product::where('vendor_id', $vendor->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        return view('vendor.products.form', [
            'product' => new Product(),
            'formAction' => route('vendor.products.store'),
            'formMethod' => 'POST',
            'buttonText' => 'Create Product'
        ]);
    }

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

        // Upload image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();

        $validated['vendor_id'] = $vendor->id;
        $validated['rating'] = 0;

        // 🔥 NEW: store creator link
        $validated['creator_link'] = url('/p/' . $validated['slug'] . '?ref=creator_' . $vendor->id);

        $product = Product::create($validated);

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $vendor = Auth::user();

        $product = Product::where('vendor_id', $vendor->id)->findOrFail($id);

        return view('vendor.products.form', [
            'product' => $product,
            'formAction' => route('vendor.products.update', $product),
            'formMethod' => 'POST',
            'buttonText' => 'Update Product'
        ]);
    }

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

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // If name changes → regenerate slug + creator link
        if ($product->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();
            $validated['creator_link'] = url('/p/' . $validated['slug'] . '?ref=creator_' . $vendor->id);
        }

        $product->update($validated);

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $vendor = Auth::user();

        $product = Product::where('vendor_id', $vendor->id)->findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}