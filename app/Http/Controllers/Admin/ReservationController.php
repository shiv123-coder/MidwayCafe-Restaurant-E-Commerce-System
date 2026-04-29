<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    /**
     * Display a listing of reservations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = DB::table('reservations')
            ->orderBy('id', 'desc')
            ->get();
            
        return view('admin.pages.reservations', compact('reservations'));
    }

    /**
     * Delete a reservation.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('reservations')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Reservation deleted successfully!');
    }
}
