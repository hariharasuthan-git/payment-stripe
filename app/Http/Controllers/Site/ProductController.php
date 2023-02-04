<?php

namespace App\Http\Controllers\Site;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Product;
use Auth;
use App\Models\Order;
class ProductController extends Controller
{

    public function show()
    {
        $products = Product::where('status', config('services.defaultActive'))->paginate(3);
        return view('site.pages.product', compact('products'));
    }

    public function productDetail($id)
    {
         
        $product = Product::where('status', config('services.defaultActive'))->find($id);
        $intent = auth()->user()->createSetupIntent();
        $price = $product->price;
        $user = auth()->user();
        return view('site.pages.product-detail', compact('product', 'intent', 'price', 'user'));

    }

    public function processPayment(Request $request, String $product, $price)
{
    $user = Auth::user();
    $paymentMethod = $request->input('payment_method');
    $user->createOrGetStripeCustomer();
    $user->addPaymentMethod($paymentMethod);
    try
    {
    $user->charge($price*100, $paymentMethod);
    $transcationDetails = $user->charge($price*100, $paymentMethod);
            $result['transcation_id'] = $transcationDetails->id;
            $result['amount'] = $transcationDetails->amount;
            $result['created_on'] = Carbon::now()->toDateTimeString();
            $result['status'] = $transcationDetails->status;
            Order::Create($result);
    }
    catch (\Exception $e)
    {
    return back()->withErrors(['message' => 'Error creating subscription. ' . $e->getMessage()]);
    }
    return redirect()->route('products.orders', ['message', 'Product purchased successfully!']);
}

    public function myOrders()
    {

        $orders = Order::paginate(3);
        return view('site.pages.order', compact('orders'));

    }
}
