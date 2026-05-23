<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    // Chefs
    public function chefs()
    {
        $total_chefs = DB::table('chefs')->count();
        $fraction = $total_chefs % 3;
        $chefs = DB::table('chefs')->get();
        $fraction_chefs = DB::table('chefs')->latest()->get();

        return view('admin.pages.chefs', compact('chefs', 'fraction', 'total_chefs', 'fraction_chefs'));
    }

    public function add_chef()
    {
        return view('admin.pages.add_chef');
    }

    public function store_chef(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,jpg,png',
            'name' => 'required|unique:chefs,name',
            'job' => 'required',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        DB::table('chefs')->insert([
            'name' => $request->name,
            'job_title' => $request->job,
            'facebook_link' => $request->fb,
            'twitter_link' => $request->twitter,
            'instragram_link' => $request->instagram,
            'image' => $imagePath,
        ]);

        session()->flash('success', 'Chef added successfully!');
        return back();
    }

    public function edit_chef($id)
    {
        $chefs = DB::table('chefs')->where('id', $id)->get();
        return view('admin.pages.chef_edit', compact('chefs'));
    }

    public function update_chef(Request $request, $id)
    {
        $data = [
            'name' => $request->name,
            'job_title' => $request->job,
            'facebook_link' => $request->fb,
            'twitter_link' => $request->twitter,
            'instragram_link' => $request->instagram,
        ];

        if ($request->hasFile('image')) {
            $request->validate(['image' => 'mimes:jpeg,jpg,png']);
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image'] = $imagePath;
        }

        DB::table('chefs')->where('id', $id)->update($data);

        session()->flash('success', 'Chef updated successfully!');
        return back();
    }

    public function destroy_chef($id)
    {
        DB::table('chefs')->where('id', $id)->delete();
        session()->flash('success', 'Chef deleted successfully!');
        return back();
    }

    // Delivery Boys
    public function delivery_boy()
    {
        $delivery_boys = DB::table('users')->where('usertype', '2')->paginate(20);
        return view('admin.pages.delivery_boys', compact('delivery_boys'));
    }

    public function add_delivery_boy()
    {
        return view('admin.pages.add_delivery_boy');
    }

    public function store_delivery_boy(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'usertype' => '2',
        ]);

        session()->flash('success', 'Delivery Boy added successfully!');
        return back();
    }

    public function edit_delivery_boy($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        return view('admin.pages.edit_delivery_boy', compact('user'));
    }

    public function update_delivery_boy(Request $request, $id)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        DB::table('users')->where('id', $id)->update($data);

        session()->flash('success', 'Delivery Boy updated successfully!');
        return back();
    }

    public function destroy_delivery_boy($id)
    {
        DB::table('users')->where('id', $id)->delete();
        session()->flash('success', 'Delivery Boy deleted successfully!');
        return back();
    }

    public function user_show()
    {
        $users = DB::table('users')->where('usertype', '0')->paginate(20);
        return view('admin.pages.users', compact('users'));
    }

    public function admin_show()
    {
        $admins = DB::table('users')->where('usertype', '1')->orWhere('usertype', '3')->paginate(20);
        return view('admin.pages.admins', compact('admins'));
    }

    public function admin_add()
    {
        return view('admin.pages.add_admin');
    }

    public function admin_add_process(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'usertype' => 'required'
        ]);

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'usertype' => $request->usertype,
        ]);

        session()->flash('success', 'Admin added successfully!');
        return back();
    }

    public function admin_edit($id)
    {
        $admin = DB::table('users')->where('id', $id)->get();
        return view('admin.pages.edit_admin', compact('admin'));
    }

    public function admin_edit_process(Request $request, $id)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'salary' => $request->salary,
            'usertype' => $request->usertype,
        ];

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        DB::table('users')->where('id', $id)->update($data);

        session()->flash('success', 'Admin updated successfully!');
        return back();
    }

    public function admin_delete($id)
    {
        DB::table('users')->where('id', $id)->delete();
        session()->flash('success', 'Admin deleted successfully!');
        return back();
    }
}
