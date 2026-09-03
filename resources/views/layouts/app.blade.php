<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Maintenance X')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full font-sans antialiased text-slate-800">
    @auth
        <div class="flex min-h-screen bg-slate-100">
            <!-- Sidebar -->
            <aside class="w-64 bg-[#0B132B] text-white flex flex-col justify-between p-4 shrink-0 shadow-xl">
                <div>
                    <!-- Logo / Brand -->
                    <div class="flex items-center gap-3 pb-6 border-b border-slate-800">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center font-bold text-lg text-white shadow-md shadow-blue-500/30">
                            MX
                        </div>
                        <div>
                            <b class="block leading-tight text-white tracking-wide">Maintenance X</b>
                            <small class="text-xs text-slate-400">Equipment System</small>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="mt-6 flex flex-col gap-1.5">
                        @if(auth()->user()->hasPermission('dashboard'))
                            <a class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/60 hover:text-white' }}" href="{{ route('dashboard') }}">
                                Dashboard
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('tickets'))
                            <a class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('tickets.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/60 hover:text-white' }}" href="{{ route('tickets.index') }}">
                                Tickets
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('maintenance'))
                            <a class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('maintenance.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/60 hover:text-white' }}" href="{{ route('maintenance.index') }}">
                                Maintenance
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('history'))
                            <a class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('history') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/60 hover:text-white' }}" href="{{ route('history') }}">
                                History
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('equipment'))
                            <a class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('equipment.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/60 hover:text-white' }}" href="{{ route('equipment.index') }}">
                                Equipment
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('users'))
                            <a class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/60 hover:text-white' }}" href="{{ route('users.index') }}">
                                User Management
                            </a>
                        @endif
                    </nav>
                </div>

                <!-- Profile bottom -->
                <div class="pt-4 border-t border-slate-800">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center font-bold text-sm text-slate-300 border border-slate-700">
                            {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                        </div>
                        <div class="overflow-hidden">
                            <b class="block text-sm truncate text-slate-200">{{ auth()->user()->username }}</b>
                            <small class="text-xs text-slate-400 block capitalize">{{ auth()->user()->role }}</small>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-center py-2 px-3 rounded-xl border border-slate-800 text-xs font-semibold text-slate-300 hover:bg-red-500/10 hover:text-red-400 hover:border-red-500/30 transition-all">
                            Logout
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main area -->
            <main class="flex-1 flex flex-col min-w-0">
                <header class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">EQUIPMENT MAINTENANCE</span>
                        <h1 class="text-2xl font-bold text-slate-900">@yield('page_title', 'Dashboard')</h1>
                    </div>
                    <div class="text-right">
                        <span class="font-semibold text-slate-700 block text-sm">{{ auth()->user()->username }}</span>
                        <span class="inline-block px-2.5 py-0.5 text-[10px] font-extrabold uppercase rounded-md bg-blue-100 text-blue-700 tracking-wider">{{ auth()->user()->role }}</span>
                    </div>
                </header>

                <section class="p-8 flex-1">
                    @if(session('success'))
                        <div class="alert mb-6 p-4 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-sm font-medium flex items-center justify-between">
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif 
                    @if(session('error'))
                        <div class="alert mb-6 p-4 rounded-xl bg-red-50 text-red-700 border border-red-200 text-sm font-medium flex items-center justify-between">
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif 

                    @yield('content')
                </section>
            </main>
        </div>
    @else 
        @yield('content') 
    @endauth

    <script>
        document.querySelectorAll('.alert').forEach(e => setTimeout(() => e.remove(), 4500));
    </script>
</body>
</html>