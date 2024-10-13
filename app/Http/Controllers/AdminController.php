<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Auth routes

    public function login()
    {
        return view('Admin.login');
    }

    public function login_check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => "Please enter email",
            'password.required' => "Please enter password"
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return response()->json([
                'success' => 'Login successful!'
            ]);
        } else {
            return response()->json(['error' => ['cred_err' => 'Invalid credentials']]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }

    // dashboard
    public function dashboard()
    {
        return view('Admin.dashboard');
    }

    // product
    public function view_product($id)
    {
        try {
            $product = Product::findOrFail($id);

            return response()->json(['product' => $product]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch product details.'], 500);
        }
    }

    public function getProducts(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('amount', 'like', '%' . $search . '%');
        }

        $products = $query->orderBy('updated_at', 'desc')->get();

        return response()->json([
            'products' => $products
        ]);
    }

    public function store_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = new Product();
        $product->name = $request->name;
        $product->amount = $request->amount;
        $product->description = $request->description;
        $product->image = $imagePath;
        $product->save();

        return response()->json(['success' => 'Product added successfully!']);
    }

    public function get_product($id)
    {
        $product = Product::find($id);

        if ($product) {
            return response()->json([
                'product' => $product
            ]);
        } else {
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }
    }

    // update of the product
    public function edit_product(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'amount' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }

        $product->name = $request->name;
        $product->amount = $request->amount;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return response()->json([
            'success' => 'Product updated successfully!'
        ]);
    }

    public function delete_product($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            $filePath = 'storage/'. $product->image;
            unlink($filePath);
        }
        $product->delete();

        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
