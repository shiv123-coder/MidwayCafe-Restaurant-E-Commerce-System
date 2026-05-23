<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class FoodController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = DB::table('products')
            ->leftJoin('rates', 'products.id', '=', 'rates.product_id')
            ->select('products.*', DB::raw('AVG(rates.star_value) as avg_rating'));
            
        if ($search) {
            $query->where('products.name', 'ILIKE', "%{$search}%")
                  ->orWhere('products.description', 'ILIKE', "%{$search}%");
        }
            
        $products = $query->groupBy('products.id')->get();

        $total_products = $products->count();
        $fraction = $total_products % 3;

        return view('admin.pages.menu', compact('products', 'fraction', 'total_products'));
    }

    public function create()
    {
        return view('admin.pages.add_menu');
    }

    public function store(Request $request)
    {
        if ($request->price < 0) {
            session()->flash('wrong', 'Negative Price value not accepted!');
            return back();
        }

        $request->validate([
            'image' => 'required|mimes:jpeg,jpg,png',
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        DB::table('products')->insert([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'session' => $request->session,
            'available' => $request->available,
            'image' => $imagePath,
        ]);

        Cache::forget('home_menu');
        Cache::forget('home_breakfast');
        Cache::forget('home_lunch');
        Cache::forget('home_dinner');

        session()->flash('success', 'Menu added successfully!');
        return back();
    }

    public function edit($id)
    {
        $products = DB::table('products')->where('id', $id)->get();
        return view('admin.pages.menu_edit', compact('products'));
    }

    public function update(Request $request, $id)
    {
        if ($request->price < 0) {
            session()->flash('wrong', 'Negative Price value not accepted!');
            return back();
        }

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'session' => $request->session,
            'available' => $request->available,
        ];

        if ($request->hasFile('image')) {
            $request->validate(['image' => 'mimes:jpeg,jpg,png']);
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image'] = $imagePath;
        }

        DB::table('products')->where('id', $id)->update($data);

        Cache::forget('home_menu');
        Cache::forget('home_breakfast');
        Cache::forget('home_lunch');
        Cache::forget('home_dinner');

        session()->flash('success', 'Menu updated successfully!');
        return back();
    }

    public function destroy($id)
    {
        DB::table('products')->where('id', $id)->delete();
        
        Cache::forget('home_menu');
        Cache::forget('home_breakfast');
        Cache::forget('home_lunch');
        Cache::forget('home_dinner');
        
        session()->flash('success', 'Menu deleted successfully!');
        return back();
    }
}
