<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Maintenance X</title>
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
            <p class="text-xs text-slate-400 mt-1">Buat akun baru untuk sistem maintenance</p>
        </div>

        <!-- Form Card -->
        <div class="bg-slate-800 border border-slate-700/80 rounded-2xl p-6 sm:p-8 shadow-2xl">
            <h2 class="text-lg font-semibold text-white mb-6 border-b border-slate-700 pb-3">Create Account</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Username -->
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1.5">Username</label>
                    <input 
                        type="text" 
                        name="username" 
                        value="{{ old('username') }}"
                        required 
                        placeholder="Enter username" 
                        class="w-full px-4 py-2.5 bg-slate-900/80 border border-slate-700 rounded-xl text-slate-100 text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                    >
                    @error('username')
                        <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1.5">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required 
                        placeholder="Enter email" 
                        class="w-full px-4 py-2.5 bg-slate-900/80 border border-slate-700 rounded-xl text-slate-100 text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                    >
                    @error('email')
                        <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1.5">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        required 
                        placeholder="Minimum 6 characters" 
                        class="w-full px-4 py-2.5 bg-slate-900/80 border border-slate-700 rounded-xl text-slate-100 text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                    >
                    @error('password')
                        <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1.5">Confirm Password</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        placeholder="Confirm password" 
                        class="w-full px-4 py-2.5 bg-slate-900/80 border border-slate-700 rounded-xl text-slate-100 text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                    >
                </div>

                                <!-- Pilih Role -->
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1.5">Role User</label>
                    <select 
                        name="role" 
                        required 
                        class="w-full px-4 py-2.5 bg-slate-900/80 border border-slate-700 rounded-xl text-slate-100 text-sm focus:outline-none focus:border-blue-500 transition"
                    >
                        <option value="ENGINEER">ENGINEER</option>
                        <option value="SUPERVISOR">SUPERVISOR</option>
                        <option value="MANAGER">MANAGER</option>
                        <option value="ADMIN">ADMIN</option>
                        <option value="SUPERADMIN">SUPERADMIN</option>
                    </select>
                </div>

                <!-- Pilih Hak Akses Modul (Opsional) -->
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-2">Hak Akses Modul Awal</label>
                    <div class="grid grid-cols-2 gap-2 bg-slate-900/50 p-3 rounded-xl border border-slate-700/60">
                        <label class="flex items-center gap-2 text-xs text-slate-300 cursor-pointer">
                            <input type="checkbox" name="permissions[]" value="dashboard" checked class="rounded bg-slate-800 border-slate-600 text-blue-600 focus:ring-0">
                            Dashboard
                        </label>
                        <label class="flex items-center gap-2 text-xs text-slate-300 cursor-pointer">
                            <input type="checkbox" name="permissions[]" value="maintenance" class="rounded bg-slate-800 border-slate-600 text-blue-600 focus:ring-0">
                            Maintenance
                        </label>
                        <label class="flex items-center gap-2 text-xs text-slate-300 cursor-pointer">
                            <input type="checkbox" name="permissions[]" value="history" class="rounded bg-slate-800 border-slate-600 text-blue-600 focus:ring-0">
                            History
                        </label>
                        <label class="flex items-center gap-2 text-xs text-slate-300 cursor-pointer">
                            <input type="checkbox" name="permissions[]" value="equipment" class="rounded bg-slate-800 border-slate-600 text-blue-600 focus:ring-0">
                            Equipment
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full mt-2 py-3 px-4 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-600/30 transition duration-150"
                >
                    Register
                </button>
            </form>

            <!-- Footer Link -->
            <p class="text-center text-xs text-slate-400 mt-6 pt-4 border-t border-slate-700/60">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-medium">Login</a>
            </p>
        </div>
    </div>

</body>
</html>