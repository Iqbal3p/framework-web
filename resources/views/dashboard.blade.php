<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Dashboard</h2>
    </x-slot>

    <div class="py-8 space-y-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-4 gap-4">

            <x-card>
                <p class="text-xs text-gray-500">Omzet Hari Ini</p>
                <p class="text-xl font-semibold">
                    Rp{{ number_format($omzetHariIni, 0, ',', '.') }}
                </p>
            </x-card>

            <x-card>
                <p class="text-xs text-gray-500">Omzet Kemarin</p>
                <p class="text-xl font-semibold">
                    Rp{{ number_format($omzetKemarin, 0, ',', '.') }}
                </p>
            </x-card>

            <x-card>
                <p class="text-xs text-gray-500">Transaksi Hari Ini</p>
                <p class="text-xl font-semibold">
                    {{ $transaksiHariIni }}
                </p>
            </x-card>

            <x-card>
                <p class="text-xs text-gray-500">Produk Stok Menipis</p>
                <p class="text-xl font-semibold text-yellow-600">
                    {{ $produkMenipis }}
                </p>
            </x-card>

        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-3 gap-6">

            <x-card class="col-span-2">
                <h3 class="font-semibold mb-3">
                    Tren Penjualan 7 Hari Terakhir
                </h3>

                <div style="height: 300px;">
                    <canvas id="chartTren"></canvas>
                </div>
            </x-card>

            <x-card>
                <h3 class="font-semibold mb-3">
                    Produk Terlaris
                </h3>

                <ol class="list-decimal list-inside space-y-1 text-sm">
                    @forelse ($produkTerlaris as $produk)
                        <li>
                            {{ $produk->name }}
                            <span class="text-gray-500">
                                ({{ $produk->total_qty }} terjual)
                            </span>
                        </li>
                    @empty
                        <li>Belum ada data penjualan.</li>
                    @endforelse
                </ol>
            </x-card>

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const canvas = document.getElementById('chartTren');

                new window.Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: @json($labelTren),
                        datasets: [{
                            label: 'Penjualan (Rp)',
                            data: @json($dataTren),
                            borderColor: '#4f46e5',
                            tension: 0.3,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    }
                });
            });
        </script>
    @endpush

</x-app-layout>
