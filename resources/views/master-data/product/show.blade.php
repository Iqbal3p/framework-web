<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Detail Produk
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <h3 class="text-lg font-semibold">
                    {{ $product->name }}
                </h3>

                <p class="text-sm text-gray-500 mb-4">
                    {{ $product->code }} &middot;
                    {{ $product->category->name }}
                </p>

                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="bg-gray-50 rounded-md p-4 text-center">
                        <p class="text-xs text-gray-500">Harga</p>
                        <p class="text-lg font-semibold">
                            {{ $product->price }}
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-md p-4 text-center">
                        <p class="text-xs text-gray-500">Stok Saat Ini</p>
                        <p class="text-lg font-semibold">
                            {{ $product->stock }} {{ $product->unit }}
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-md p-4 text-center">
                        <p class="text-xs text-gray-500">Total Terjual</p>
                        <p class="text-lg font-semibold">
                            {{ $totalTerjual }} {{ $product->unit }}
                        </p>
                    </div>
                </div>

                <h4 class="font-medium mb-2">
                    Riwayat Penjualan Terakhir
                </h4>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left">No. Invoice</th>
                                <th class="px-3 py-2 text-left">Tanggal</th>
                                <th class="px-3 py-2 text-right">Qty</th>
                                <th class="px-3 py-2 text-right">Subtotal</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse ($riwayat as $item)
                                <tr>
                                    <td class="px-3 py-2">
                                        {{ $item->transaction->invoice_number }}
                                    </td>

                                    <td class="px-3 py-2">
                                        {{ $item->transaction->created_at->format('d M Y H:i') }}
                                    </td>

                                    <td class="px-3 py-2 text-right">
                                        {{ $item->qty }}
                                    </td>

                                    <td class="px-3 py-2 text-right">
                                        Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-4 text-center text-gray-500">
                                        Belum pernah terjual.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex gap-2">
                    <a href="{{ route('products.index') }}"
                       class="px-4 py-2 text-gray-500 hover:text-gray-700 text-sm">
                        Kembali
                    </a>

                    <a href="{{ route('products.edit', $product) }}"
                       class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">
                        Ubah Produk
                    </a>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
