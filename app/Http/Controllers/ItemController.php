<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all(); // Fetch all items from the database
        return view('item.index', compact('items')); // Pass the items to the view
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('item.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0.01', // Changed min value to 0.01
        ]);
    
        $item = new Item();
        $item->product_name = $validatedData['product_name'];
        $item->quantity = $validatedData['quantity'];
        $item->price = $validatedData['price'];
        $item->save(); // Save the item to the database.
    
        return redirect()->back()->with('success', 'Product added successfully.');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id); // Retrieve the item based on the given ID
        return view('item.update', compact('item')); // Pass the item to the view
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $items = Item::find($id);

        $items->product_name = $request->product_name ;
        $items->quantity = $request->quantity;
        $items->price = $request->price;
        $items->save();
        return redirect()->route('item.index')->with('success', 'Product data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id); // Retrieve the item based on the given ID
        $item->delete(); // Delete the item
        return redirect()->back()->with('success', 'Item deleted successfully.');
    }
    
}
