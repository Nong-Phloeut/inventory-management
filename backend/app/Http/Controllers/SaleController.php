<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Sale::with('items.product')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'sale_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($data) {
            // total = sum of items
            $total = collect($data['items'])->sum(fn($i) => $i['quantity'] * $i['price']);

            $sale = Sale::create([
                'sale_date' => $data['sale_date'],
                'total_amount' => $total,
            ]);

            foreach ($data['items'] as $item) {
                $sale->items()->create($item);

                // reduce stock
                DB::table('stocks')
                    ->where('product_id', $item['product_id'])
                    ->decrement('quantity', $item['quantity']);
            }

            return response()->json($sale->load('items.product'), 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Sale::with('items.product')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
