<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Staf - BAWASLU Management Asset</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-blue-600 p-6 text-center">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo Bawaslu" class="h-16 mx-auto mb-3 drop-shadow-md">
            <h1 class="text-2xl font-bold text-white">BAWASLU Management Asset</h1>
            <p class="text-blue-100 text-sm mt-1">Portal Laporan Lapangan Staf</p>
        </div>

        <div class="p-6">
            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="email@bawaslu.go.id">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="password">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="mr-2"> Ingat Saya
                    </label>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                    Masuk
                </button>
            </form>
        </div>
        
        <div class="bg-gray-50 p-4 border-t text-center text-xs text-gray-500">
            Hanya untuk staf internal Bawaslu.
        </div>
    </div>

</body>
</html>
