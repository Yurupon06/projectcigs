<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::with('productcat')->get();
        $user = Auth::user();
        $customer = $user ? Customer::where('user_id', $user->id)->first() : null;
        return view('landing.index', compact('products', 'user', 'customer'));
    }

    public function profile(){
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        return view('landing.profile', compact('user', 'customer'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'born' => 'required|date',
            'gender' => 'required|in:men,women',
        ]);

        $user = Auth::user();
        $customer = Customer::updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $request->phone,
                'born' => $request->born,
                'gender' => $request->gender,
            ]
        );

        return redirect()->route('landing.profile')->with('success', 'Profile updated successfully.');
    }



    public function order()
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
    
        $orders = $customer ? Order::where('customer_id', $customer->id)->get() : collect([]);
    
        return view('landing.order', compact('orders', 'customer'));
    }

    public function orderStore(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        $qrToken = Str::random(60);


        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        if (!$customer || !$customer->phone || !$customer->born || !$customer->gender) {
            return redirect()->route('landing.profile')->with('warning', 'Please complete your profile before Join The Gym.');
        }

        $order = Order::create([
            'customer_id' => $customer->id,
            'product_id' => $request->product_id,
            'order_date' => Carbon::now('Asia/Jakarta'),
            'total_amount' => $request->total_amount,
            'status' => 'unpaid',
            'qr_token' => $qrToken,

        ]);

        return redirect()->route('checkout', ['id' => $order->id])->with('success', 'Order created successfully.');
    }

    public function orderDelete($id){
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('yourorder.index')->with('success', 'Successfully Cancel The Order.');
    }




    public function checkout($id){
        $order = Order::with('customer', 'product')->find($id);
        return view('landing.checkout', compact('order'));
    }
}
