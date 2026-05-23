<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use App\Mail\OrderShipped;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Auth;
use PDF;
use QrCode;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;




class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::all();
        return view('pages.cart', compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Cart::all();
 
        // Ship the order...
 
        Mail::to($request->user())->send(new OrderShipped($order));
    }
    public function place_order($total)
    {

        return view('pages.place_order',compact('total'));


    }


    public function send(Request $request,$total)
    {    
        // 50km Radius Validation
        if (!$this->checkDeliveryRadius($request->address)) {
            session()->flash('wrong', 'Sorry, we only deliver within a 50km radius of our restaurant. Your address appears to be outside our service area.');
            return back();
        }

        $data=array();

        $invoice = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 8);
        /*
        $order_list = DB::table('carts')->where('product_order','yes')->get();


        foreach($order_list as $order)
        {

            while($order->invoice_no != $invoice)
            {

                $invoice = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 8);


            }


        }
        */
        //return $invoice;
        
        
        $fullAddress = $request->address;
        if ($request->city) $fullAddress .= ", " . $request->city;
        if ($request->state) $fullAddress .= ", " . $request->state;
        if ($request->zip) $fullAddress .= " - " . $request->zip;

        $data['shipping_address'] = $fullAddress;
        $data['product_order']="yes";
        $data['invoice_no']=$invoice;
        $data['pay_method']="Cash On Delivery";
        $data['delivery_time']="3 hours";
        $data['purchase_date']=date("Y-m-d");


      


        $carts = DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->get();
        $total = $carts->sum('subtotal');
        
        $coupon_code = null;
        if ($carts->count() > 0) {
            $coupon_code = $carts->first()->coupon_id;
        }

        $discount_price = 0;
        if ($coupon_code != null) {
            $coupon_code_price = DB::table('coupons')->where('code', $coupon_code)->value('percentage');
            $coupon_code_price = floor($coupon_code_price);
            $discount_price = floor(($total * $coupon_code_price) / 100);
            $total = $total - $discount_price;
        }

        $extra_charge = DB::table('charges')->get();
        $total_extra_charge = DB::table('charges')->sum('price');
        $final_total = $total + $total_extra_charge;

        DB::beginTransaction();
        try {
            // 1. Create Order
            $order = \App\Models\Order::create([
                'user_id' => Auth::user()->id,
                'invoice_no' => $invoice,
                'total_amount' => $final_total,
                'status' => 'Pending',
                'pay_method' => 'Cash On Delivery',
                'shipping_address' => $fullAddress,
                'delivery_time' => '3 hours',
                'purchase_date' => date("Y-m-d"),
                'coupon_id' => $coupon_code,
            ]);

            // 2. Create Order Items
            foreach ($carts as $cartItem) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'price' => $cartItem->price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->subtotal,
                ]);
            }

            // 3. Clear Cart
            DB::table('carts')->where('user_id', Auth::user()->id)->where('product_order', 'no')->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('wrong', 'An error occurred while placing your order. Please try again.');
            return back();
        }

        Session::put('products', $carts);
        Session::put('invoice', $invoice);
        Session::put('total', $final_total);
        Session::put('extra_charge', $extra_charge);
        Session::put('discount_price', $discount_price);
        Session::put('without_discount_price', $total + $total_extra_charge);
        Session::put('date', date("Y-m-d"));

        if ($invoice == NULL) {
            $invoice = "RMS";
        }

        $qrcode = base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate('RMS Verified'));
        $pdf = PDF::loadView('mails.payment-mail', [
            'products' => $carts,
            'invoice' => $invoice,
            'total' => $final_total,
            'extra_charge' => $extra_charge,
            'discount_price' => $discount_price,
            'without_discount_price' => $total + $total_extra_charge,
            'date' => date("Y-m-d"),
            'qrcode' => $qrcode,
            'title' => "From RMS admin"
        ]);

        Session::put('qrcode', $qrcode);

        \Mail::send('mails.payment-mail', [
            'products' => $carts,
            'invoice' => $invoice,
            'total' => $final_total,
            'extra_charge' => $extra_charge,
            'discount_price' => $discount_price,
            'without_discount_price' => $total + $total_extra_charge,
            'date' => date("Y-m-d"),
            'qrcode' => $qrcode,
            'title' => "From RMS admin"
        ], function ($message) use ($pdf) {
            $message->to(Auth::user()->email, Auth::user()->email)
                ->subject("From RMS admin")
                ->attachData($pdf->output(), "Order Copy.pdf");
        });

        return redirect('/')->with('success', 'Order placed successfully! Invoice: ' . $invoice);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function my_order()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $orders = \App\Models\Order::where('user_id', Auth::id())->latest()->get();
        $total_price = $orders->sum('total_amount');
        return view('pages.my_order', compact('orders', 'total_price'));
    }

    public function trace()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $orders = \App\Models\Order::where('user_id', Auth::id())->where('status', 'Pending')->get();
        return view('pages.trace', compact('orders'));
    }

    public function trace_confirm(Request $req)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $order = \App\Models\Order::with('items.product')
            ->where('user_id', Auth::id())
            ->where('invoice_no', $req->invoice)
            ->first();

        if (!$order) {
            session()->flash('wrong', 'Invalid Invoice no !');
            return back();
        }

        if ($req->phone != Auth::user()->phone) {
            session()->flash('wrong', 'Wrong phone no !');
            return back();
        }

        $products = $order->items;
        $total_price = $order->total_amount;
        $without_discount_price = $products->sum('subtotal');
        
        $coupon_code = $order->coupon_id;
        $discount_price = 0;
        
        if ($coupon_code != NULL) {
            $coupon_code_price = DB::table('coupons')->where('code', $coupon_code)->value('percentage');
            $coupon_code_price = floor($coupon_code_price);
            $discount_price = floor(($without_discount_price * $coupon_code_price) / 100);
        }

        $extra_charge = DB::table('charges')->get();
        $total_extra_charge = DB::table('charges')->sum('price');
        $without_discount_price = $without_discount_price + $total_extra_charge;

        return view('pages.trace_confirm', compact('order', 'products', 'total_price', 'extra_charge', 'discount_price', 'without_discount_price'));
    }
    

    public function coupon_apply(Request $req)
    {


        $coupon_code=DB::table('coupons')->where('code',$req->code)->count();

        if($coupon_code == 0)
        {

            session()->flash('wrong','Wrong Coupon Code !');
            return back();

        }
        $validate=DB::table('coupons')->where('code',$req->code)->value('valid_until');

        $today=date("Y-m-d");

        if($validate < $today)
        {

            session()->flash('wrong','Expire Validation Date !');
            return back();



        }

        $data=array();

        $data['coupon_id']=$req->code;

        $update_coupon=DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->update($data);

        if($update_coupon)
        {



           return redirect('/cart');

        }
        else
        {

            session()->flash('wrong','Already applied this code !');
            return back();


        }
        

    }

    private function checkDeliveryRadius($address)
    {
        // In a real application, you would use a Geocoding API (like Google Maps)
        // to get coordinates from the address and calculate the distance from the restaurant.
        
        // Mocking distance logic for demonstration:
        // We simulate a distance check. In production, replace this with a Haversine formula calculation.
        $mockDistance = strlen($address ?? '') % 70; // Mock distance between 0-70km
        
        return $mockDistance <= 50;
    }
}
