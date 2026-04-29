<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CmsController extends Controller
{
    // Banners
    public function banners()
    {
        $banners = DB::table('banners')->get();
        return view('admin.pages.banners', compact('banners'));
    }

    public function add_banner()
    {
        return view('admin.pages.add_banner');
    }

    public function store_banner(Request $request)
    {
        $request->validate(['image' => 'required|mimes:jpeg,jpg,png']);
        $imagePath = $request->file('image')->store('images', 'public');

        DB::table('banners')->insert(['banner' => $imagePath]);
        session()->flash('success', 'Banner added successfully!');
        return back();
    }

    public function destroy_banner($id)
    {
        DB::table('banners')->where('id', $id)->delete();
        session()->flash('success', 'Banner deleted successfully!');
        return back();
    }

    // Coupons
    public function coupons()
    {
        $coupons = DB::table('coupons')->get();
        return view('admin.pages.coupons', compact('coupons'));
    }

    public function add_coupon()
    {
        return view('admin.pages.add_coupon');
    }

    public function store_coupon(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'code' => 'required|string|max:50|unique:coupons',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'vaildation_date' => 'nullable|date',
        ]);

        DB::table('coupons')->insert([
            'name' => $request->name,
            'details' => $request->details,
            'code' => $request->code,
            'percentage' => $request->discount_percentage,
            'valid_until' => $request->vaildation_date,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        session()->flash('success', 'Coupon added successfully!');
        return back();
    }

    // Charges
    public function charges()
    {
        $charges = DB::table('charges')->get();
        return view('admin.pages.charges', compact('charges'));
    }

    public function add_charge()
    {
        return view('admin.pages.add_charge');
    }

    public function store_charge(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
        DB::table('charges')->insert([
            'name' => $request->name,
            'price' => $request->price,
        ]);
        session()->flash('success', 'Charge added successfully!');
        return back();
    }

    // Customization (About Us)
    public function customize()
    {
        $customize = DB::table('about_us')->get();
        return view('admin.pages.customize', compact('customize'));
    }

    public function edit_customize()
    {
        $customize = DB::table('about_us')->where('id', 1)->first();
        return view('admin.pages.customize_edit', compact('customize'));
    }

    public function update_customize(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);
        DB::table('about_us')->where('id', 1)->update([
            'description' => $request->description,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);
        session()->flash('success', 'Customization updated successfully!');
        return back();
    }

    public function reservations()
    {
        $reservations = DB::table('reservations')->get();
        return view('admin.pages.reservations', compact('reservations'));
    }

    // Missing Coupon CRUD
    public function edit_coupon($id)
    {
        $coupon = DB::table('coupons')->where('id', $id)->get();
        return view('admin.pages.edit_coupon', compact('coupon'));
    }

    public function update_coupon(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'code' => 'required|string|max:50',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'vaildation_date' => 'nullable|date',
        ]);

        DB::table('coupons')->where('id', $id)->update([
            'name' => $request->name,
            'details' => $request->details,
            'code' => $request->code,
            'percentage' => $request->discount_percentage,
            'valid_until' => $request->vaildation_date,
            'updated_at' => now(),
        ]);

        session()->flash('success', 'Coupon updated successfully!');
        return redirect()->route('admin.coupon');
    }

    public function destroy_coupon($id)
    {
        DB::table('coupons')->where('id', $id)->delete();
        session()->flash('success', 'Coupon deleted successfully!');
        return back();
    }

    // Missing Charge CRUD
    public function edit_charge($id)
    {
        $charge = DB::table('charges')->where('id', $id)->get();
        return view('admin.pages.edit_charge', compact('charge'));
    }

    public function update_charge(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        DB::table('charges')->where('id', $id)->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        session()->flash('success', 'Charge updated successfully!');
        return redirect()->route('admin.charge');
    }

    public function destroy_charge($id)
    {
        DB::table('charges')->where('id', $id)->delete();
        session()->flash('success', 'Charge deleted successfully!');
        return back();
    }
}
