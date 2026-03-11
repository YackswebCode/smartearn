<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with('vendor')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $vendors = User::where('vendor_status', 'Active')->get(['id', 'name', 'business_name']);
        return view('admin.products.form', [
            'product' => new Product(),
            'vendors' => $vendors,
            'formAction' => route('admin.products.store'),
            'formMethod' => 'POST',
            'buttonText' => 'Create Product'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'vendor_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|in:NGN,USD,GHS,XAF,KES',
            'commission_percent' => 'required|integer|min:0|max:100',
            'category' => 'nullable|string|max:255',
            'type' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate slugs
        $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();
        $validated['affiliate_slug'] = Str::slug($validated['name']) . '-' . Str::random(6);

        // Handle image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $vendors = User::where('vendor_status', 'Active')->get(['id', 'name', 'business_name']);
        return view('admin.products.form', [
            'product' => $product,
            'vendors' => $vendors,
            'formAction' => route('admin.products.update', $product),
            'formMethod' => 'POST', // spoofed to PUT
            'buttonText' => 'Update Product'
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'vendor_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|in:NGN,USD,GHS,XAF,KES',
            'commission_percent' => 'required|integer|min:0|max:100',
            'category' => 'nullable|string|max:255',
            'type' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update slugs only if name changed
        if ($product->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();
            $validated['affiliate_slug'] = Str::slug($validated['name']) . '-' . Str::random(6);
        }

        // Handle image
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}