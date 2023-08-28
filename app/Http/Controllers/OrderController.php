<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\OrderFormRequest;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Item;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('user')->get();
        return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::get();
        $items = Item::get();
        return view('order.create', compact('users', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(OrderStoreRequest $request)
    {
        if ($request->newUser == 'on') {
            $user = new User();
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->save();
        } else {
            $user = User::find($request->user);
        }
        $sub_total = array_sum($request->total_price);
        if ($request->discountSelect == 'fixed') {
            $discounted_amount = $request->discountedAmount;
            $final_price = $sub_total - $discounted_amount;
        } else {
            $discounted_amount = ($request->discountedAmount / 100) * $sub_total;
            $final_price = $sub_total - $discounted_amount;
        }

        $order = new Order();
        $order->user_id = $user->id;
        $order->sub_total = $sub_total;
        $order->discount_type = $request->discountSelect;
        $order->discounted_amount = $discounted_amount;
        $order->final_price = $final_price;
        $order->save();

        $products = $request->product_name;
        $quantity = $request->quantity;
        $total_price = $request->total_price;

        for ($index = 0; $index < count($products); $index++) {
            $item = Item::find($products[$index]);
            // Do not use attach() here
            $order->items()->attach($item, [
                'quantity' => $quantity[$index],
                'total_price' => $total_price[$index],
                'total_quantity' => $item->quantity
            ]);
            $item->quantity = ($item->quantity - $quantity[$index]);
            $item->update();
        }

        $orderData = [
            'id' => $order->id,
            // Add other attributes you want to include
        ];

        return response()->json(['order' => $orderData, 'message' => 'Order created successfully.']);
    }






    /**
     * Display the specified resource.
     */
    public function show(Order $Order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $users = User::all();
        $items = Item::all();
        return view('order.update', compact('order', 'users', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if ($request->newUser == 'on') {
            $user = new User();
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->save();
        } else {
            $user = User::find($request->user);
        }

        $sub_total = array_sum($request->total_price);
        if ($request->discountSelect == 'fixed') {
            $discounted_amount = $request->discountedAmount;
        } else {
            $discounted_amount = ($request->discountedAmount / 100) * $sub_total;
        }

        $final_price = $sub_total - $discounted_amount;

        $order->user_id = $user->id;
        $order->sub_total = $sub_total;
        $order->discount_type = $request->discountSelect;
        $order->discounted_amount = $discounted_amount;
        $order->final_price = $final_price;
        $order->save();

        $order->items()->detach(); // Detach all items from the order

        $products = $request->product_name;
        $quantity = $request->quantity;
        $total_price = $request->total_price;

        for ($index = 0; $index < count($products); $index++) {
            $item = Item::find($products[$index]);
            // Do not use attach() here
            $order->items()->attach($item, [
                'quantity' => $quantity[$index],
                'total_price' => $total_price[$index],
                'total_quantity' => $item->quantity
            ]);
            $item->quantity = ($item->quantity - $quantity[$index]);
            $item->update();
        }

        $orderData = [
            'id' => $order->id,
            // Add other attributes you want to include
        ];
        return redirect()->route('order.index');
        // Return JSON response and redirect after updating
        // return response()->json(['order' => $orderData, 'message' => 'Order updated successfully.']);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Delete the order and related items (assuming you have proper relationships set up)
        $order->items()->detach(); // Detach items from the order
        $order->delete(); // Delete the order        
        return redirect()->back()
            ->with('success', 'Order deleted successfully');
    }
}
