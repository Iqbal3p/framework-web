<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Http\Requests\StorePosRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)
            ->orderBy('name')
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'code' => $product->code,
                    'name' => $product->name,
                    'price' => $product->getRawOriginal('price'),
                    'stock' => $product->stock,
                    'unit' => $product->unit,
                ];
            });

        return view('pos.index', compact('products'));
    }

    public function store(StorePosRequest $request)
    {
        $transaction = DB::transaction(function () use ($request) {
            $total = 0;
            $details = [];

            foreach ($request->validated()['items'] as $item) {
                $product = Product::lockForUpdate()
                    ->findOrFail($item['product_id']);

                if ($product->stock < $item['qty']) {
                    throw ValidationException::withMessages([
                        'items' => "Stok {$product->name} tidak mencukupi.",
                    ]);
                }

                // Ambil harga numerik asli dari database.
                $price = $product->getRawOriginal('price');

                $subtotal = $price * $item['qty'];
                $total += $subtotal;

                $details[] = [
                    'product_id' => $product->id,
                    'qty' => $item['qty'],
                    'price' => $price,
                    'subtotal' => $subtotal,
                ];

                $product->decrement('stock', $item['qty']);
            }

            if ($request->pay < $total) {
                throw ValidationException::withMessages([
                    'pay' => 'Nominal bayar kurang dari total belanja.',
                ]);
            }

            $trx = Transaction::create([
                'invoice_number' => 'INV-' . now()->format('Ymd') . '-' .
                    str_pad(
                        Transaction::whereDate('created_at', today())->count() + 1,
                        4,
                        '0',
                        STR_PAD_LEFT
                    ),
                'user_id' => auth()->id(),
                'total' => $total,
                'pay' => $request->pay,
                'change' => $request->pay - $total,
            ]);

            $trx->details()->createMany($details);

            return $trx;
        });

        return redirect()
            ->route('pos.struk', $transaction)
            ->with('success', 'Transaksi berhasil disimpan.');
    }

    public function struk(Transaction $transaction)
    {
        $transaction->load('details.product', 'user');

        return view('pos.struk', compact('transaction'));
    }

}
