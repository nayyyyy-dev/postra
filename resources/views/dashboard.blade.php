<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                Dashboard
            </h2>

            <a href="{{ route('letters.create') }}" class="ui-btn-primary">
                Kirim Surat
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="ui-card p-5 float-in">
            <div class="text-xs text-slate-500">Role</div>
            <div class="mt-2 text-lg font-bold text-slate-900">
                {{ auth()->user()->getRoleNames()->implode(', ') ?: 'No Role' }}
            </div>
            <div class="mt-2 text-sm text-slate-600">
                Akses & menu disesuaikan dengan role.
            </div>
        </div>

        <div class="ui-card p-5 float-in">
            <div class="text-xs text-slate-500">Fitur</div>
            <div class="mt-2 text-lg font-bold text-slate-900">Surat PDF</div>
            <div class="mt-2 text-sm text-slate-600">
                Upload PDF atau generate otomatis dari isi surat.
            </div>
        </div>

        <div class="ui-card p-5 float-in bg-gradient-to-br from-blue-600 to-sky-500 text-white border-0 shadow-md">
            <div class="text-xs opacity-90">Quick Action</div>
            <div class="mt-2 text-lg font-bold">Buat Surat Baru</div>
            <div class="mt-3">
                <a href="{{ route('letters.create') }}" class="ui-btn-secondary !bg-white/15 !border-white/20 !text-white hover:!bg-white/25">
                    Tulis & Kirim
                </a>
            </div>
        </div>
    </div>

    <div class="mt-6 ui-card float-in">
        <div class="ui-card-body">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-slate-900">Navigasi</h3>
                <a class="ui-link" href="{{ route('letters.index') }}">Lihat semua surat →</a>
            </div>
            <p class="mt-2 text-sm text-slate-600">
                Semua halaman dashboard sudah memakai tema gradient biru-sky yang konsisten.
            </p>
        </div>
    </div>
</x-app-layout>
