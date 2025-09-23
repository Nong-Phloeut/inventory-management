<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Purchase::with('items.product', 'supplier')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $total = collect($data['items'])->sum(fn($i) => $i['quantity'] * $i['price']);

        $purchase = Purchase::create([
            'supplier_id' => $data['supplier_id'],
            'purchase_date' => $data['purchase_date'],
            'total_amount' => $total,
        ]);

        foreach ($data['items'] as $item) {
            $purchase->items()->create($item);
        }

        return response()->json($purchase->load('items.product'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Purchase::with('items.product', 'supplier')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $purchase = Purchase::findOrFail($id);

        $data = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $total = collect($data['items'])->sum(fn($i) => $i['quantity'] * $i['price']);

        $purchase->update([
            'supplier_id' => $data['supplier_id'],
            'purchase_date' => $data['purchase_date'],
            'total_amount' => $total,
        ]);

        // Delete old items and insert new
        $purchase->items()->delete();
        foreach ($data['items'] as $item) {
            $purchase->items()->create($item);
        }

        return response()->json($purchase->load('items.product'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->delete();
        return response()->json(null, 204);
    }
}
