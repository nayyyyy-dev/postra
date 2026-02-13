<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Postra') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-slate-800">
    <!-- Background Gradient -->
    <div class="fixed inset-0 -z-10 bg-gradient-to-br from-blue-50 via-white to-sky-100"></div>

    <!-- Top Bar -->
    <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-gradient-to-r from-blue-600 to-sky-500 text-white flex items-center justify-center font-bold shadow-md">
                    P
                </div>
                <div class="leading-tight">
                    <div class="font-semibold text-slate-900">Postra</div>
                    <div class="text-xs text-slate-500">Surat digital berbasis PDF</div>
                </div>
            </div>

            <nav class="flex items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-sky-500 text-white font-semibold shadow-md hover:from-blue-700 hover:to-sky-600 transition">
                        Ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 transition">
                        Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-sky-500 text-white font-semibold shadow-md hover:from-blue-700 hover:to-sky-600 transition">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    <!-- Hero -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

            <!-- Left -->
            <div class="float-in">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold">
                    ✉️ Sistem Surat Menyurat Internal
                </div>

                <h1 class="mt-5 text-4xl sm:text-5xl font-bold text-slate-900 leading-tight">
                    Selamat datang di
                    <span class="bg-gradient-to-r from-blue-600 to-sky-500 bg-clip-text text-transparent">Postra</span>
                </h1>

                <p class="mt-4 text-slate-600 text-lg leading-relaxed">
                    Kirim dan terima surat antar user dengan format <span class="font-semibold text-slate-800">PDF</span>,
                    lengkap dengan role akses <span class="font-semibold text-slate-800">super-admin, admin, supervisor</span>.
                    Modern, rapi, dan siap dipakai untuk kebutuhan surat menyurat internal.
                </p>

                <div class="mt-7 flex flex-col sm:flex-row gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="px-5 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-sky-500 text-white font-semibold shadow-md hover:from-blue-700 hover:to-sky-600 transition">
                            Masuk Dashboard
                        </a>
                        <a href="{{ route('letters.create') }}"
                           class="px-5 py-3 rounded-2xl bg-white border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 transition">
                            Kirim Surat
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-5 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-sky-500 text-white font-semibold shadow-md hover:from-blue-700 hover:to-sky-600 transition">
                            Login untuk Mulai
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="px-5 py-3 rounded-2xl bg-white border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 transition">
                                Buat Akun
                            </a>
                        @endif
                    @endauth
                </div>

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4">
                        <div class="text-sm font-semibold text-slate-900">PDF Ready</div>
                        <div class="text-xs text-slate-500 mt-1">Upload / generate PDF</div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4">
                        <div class="text-sm font-semibold text-slate-900">Role Based</div>
                        <div class="text-xs text-slate-500 mt-1">Akses sesuai hak</div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4">
                        <div class="text-sm font-semibold text-slate-900">Rapi & Cepat</div>
                        <div class="text-xs text-slate-500 mt-1">Navigasi terstruktur</div>
                    </div>
                </div>
            </div>

            <!-- Right: REAL DATA only (no dummy) -->
            <div class="float-in">
                @auth
                    @php
                        $u = auth()->user();

                        $totalInbox = \App\Models\Letter::where('recipient_id', $u->id)->count();
                        $totalSent  = \App\Models\Letter::where('sender_id', $u->id)->count();
                        $unread     = \App\Models\Letter::where('recipient_id', $u->id)->whereNull('read_at')->count();

                        $latest = \App\Models\Letter::with(['sender','recipient'])
                            ->where(function($q) use ($u) {
                                $q->where('sender_id', $u->id)->orWhere('recipient_id', $u->id);
                            })
                            ->latest()
                            ->limit(3)
                            ->get();
                    @endphp

                    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <div class="p-4 bg-gradient-to-r from-blue-600 to-sky-500 text-white">
                            <div class="flex items-center justify-between">
                                <div class="font-semibold">Ringkasan Surat (Data Asli)</div>
                                <div class="text-xs opacity-90">Akun: {{ $u->email }}</div>
                            </div>
                        </div>

                        <div class="p-5 space-y-4">
                            <div class="grid grid-cols-3 gap-3">
                                <div class="rounded-2xl border border-slate-200 p-4">
                                    <div class="text-xs text-slate-500">Inbox</div>
                                    <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalInbox }}</div>
                                </div>
                                <div class="rounded-2xl border border-slate-200 p-4">
                                    <div class="text-xs text-slate-500">Terkirim</div>
                                    <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalSent }}</div>
                                </div>
                                <div class="rounded-2xl border border-slate-200 p-4">
                                    <div class="text-xs text-slate-500">Belum Dibaca</div>
                                    <div class="text-2xl font-bold text-slate-900 mt-1">{{ $unread }}</div>
                                </div>
                            </div>

                            <div>
                                <div class="text-sm font-semibold text-slate-900 mb-2">Surat Terbaru</div>

                                @if($latest->isEmpty())
                                    <div class="rounded-2xl border border-slate-200 p-4 text-sm text-slate-600">
                                        Belum ada surat untuk akun ini.
                                    </div>
                                @else
                                    <div class="space-y-2">
                                        @foreach($latest as $letter)
                                            <a href="{{ route('letters.show', $letter) }}"
                                               class="block rounded-2xl border border-slate-200 p-4 hover:bg-slate-50 transition">
                                                <div class="text-sm font-semibold text-slate-900">
                                                    {{ $letter->subject }}
                                                </div>
                                                <div class="mt-1 text-xs text-slate-500">
                                                    Dari: {{ $letter->sender->name }} → Ke: {{ $letter->recipient->name }}
                                                </div>
                                                <div class="mt-3 flex items-center justify-between">
                                                    @if($letter->recipient_id === $u->id && $letter->read_at === null)
                                                        <span class="text-xs px-2 py-1 rounded-full bg-yellow-50 border border-yellow-200 text-yellow-700">
                                                            Belum dibaca
                                                        </span>
                                                    @elseif($letter->recipient_id === $u->id && $letter->read_at !== null)
                                                        <span class="text-xs px-2 py-1 rounded-full bg-green-50 border border-green-200 text-green-700">
                                                            Dibaca
                                                        </span>
                                                    @else
                                                        <span class="text-xs px-2 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-700">
                                                            Terkirim
                                                        </span>
                                                    @endif

                                                    <span class="text-xs text-slate-500">
                                                        {{ optional($letter->sent_at)->format('d M Y H:i') ?? $letter->created_at->format('d M Y H:i') }}
                                                    </span>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="flex gap-3">
                                <a href="{{ route('letters.index') }}"
                                   class="w-full text-center px-4 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 transition">
                                    Lihat Semua Surat
                                </a>
                                <a href="{{ route('letters.create') }}"
                                   class="w-full text-center px-4 py-2.5 rounded-2xl bg-gradient-to-r from-blue-600 to-sky-500 text-white font-semibold shadow-md hover:from-blue-700 hover:to-sky-600 transition">
                                    Kirim Surat
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <div class="p-4 bg-gradient-to-r from-blue-600 to-sky-500 text-white">
                            <div class="font-semibold">Kenapa Postra?</div>
                            <div class="text-xs opacity-90 mt-1">Tidak ada data dummy — data muncul setelah login.</div>
                        </div>

                        <div class="p-5 space-y-3">
                            <div class="rounded-2xl border border-slate-200 p-4">
                                <div class="text-sm font-semibold text-slate-900">Surat berbasis PDF</div>
                                <div class="text-xs text-slate-500 mt-1">Upload PDF atau generate otomatis dari isi surat.</div>
                            </div>
                            <div class="rounded-2xl border border-slate-200 p-4">
                                <div class="text-sm font-semibold text-slate-900">Role & Hak Akses</div>
                                <div class="text-xs text-slate-500 mt-1">Super-admin (developer), admin, supervisor.</div>
                            </div>
                            <div class="rounded-2xl border border-slate-200 p-4">
                                <div class="text-sm font-semibold text-slate-900">Tracking baca</div>
                                <div class="text-xs text-slate-500 mt-1">Surat otomatis tertandai ketika dibuka penerima.</div>
                            </div>
                        </div>
                    </div>
                @endauth

                <div class="mt-4 text-xs text-slate-500">
                    Postra • Sistem surat-menyurat internal dengan PDF dan role-based access.
                </div>
            </div>

        </div>
    </main>

    <footer class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500">
            © {{ now()->year }} Postra — dibuat untuk surat menyurat internal.
        </div>
    </footer>
</body>
</html>
