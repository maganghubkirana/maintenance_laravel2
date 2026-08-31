<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Maintenance X</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Brand Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-blue-600 shadow-lg shadow-blue-500/30 text-white font-black text-2xl mb-3">
                MX
            </div>
            <h1 class="text-2xl font-bold text-white tracking-wide">Maintenance <span class="text-blue-500">X</span></h1>
            <p class="text-xs text-slate-400 mt-1">Masuk ke sistem kelola peralatan & maintenance</p>
        </div>

        <!-- Form Card -->
        <div class="bg-slate-800 border border-slate-700/80 rounded-2xl p-6 sm:p-8 shadow-2xl">
            <h2 class="text-lg font-semibold text-white mb-6 border-b border-slate-700 pb-3">Sign In</h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email / Username -->
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1.5">Email / Username</label>
                    <input 
                        type="text" 
                        name="login" 
                        required 
                        placeholder="Masukkan email atau username" 
                        class="w-full px-4 py-2.5 bg-slate-900/80 border border-slate-700 rounded-xl text-slate-100 text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1.5">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        required 
                        placeholder="Masukkan password" 
                        class="w-full px-4 py-2.5 bg-slate-900/80 border border-slate-700 rounded-xl text-slate-100 text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                    >
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full mt-2 py-3 px-4 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-600/30 transition duration-150"
                >
                    Login
                </button>
            </form>

            <!-- Footer Link -->
            <p class="text-center text-xs text-slate-400 mt-6 pt-4 border-t border-slate-700/60">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-medium">Buat akun</a>
            </p>
        </div>
    </div>

</body>
</html>