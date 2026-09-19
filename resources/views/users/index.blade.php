<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Akun Kasir</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-sm">
        <h1 class="text-2xl font-semibold mb-6">
            Kelola Akun Kasir
        </h1>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 p-2 text-left">Nama</th>
                    <th class="border border-gray-300 p-2 text-left">Email</th>
                    <th class="border border-gray-300 p-2 text-left">Role</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="border border-gray-300 p-2">
                            {{ $user->name }}
                        </td>
                        <td class="border border-gray-300 p-2">
                            {{ $user->email }}
                        </td>
                        <td class="border border-gray-300 p-2">
                            {{ $user->role }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="border border-gray-300 p-4 text-center">
                            Belum ada akun kasir.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>