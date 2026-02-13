<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-900 leading-tight">Surat</h2>
            <a href="{{ route('letters.create') }}" class="ui-btn-primary">Kirim Surat</a>
        </div>
    </x-slot>

    <div class="ui-card float-in overflow-hidden">
        <div class="ui-card-header">
            <div>
                <div class="font-bold text-slate-900">Daftar Surat</div>
                <div class="text-sm text-slate-500">Surat masuk & keluar sesuai role.</div>
            </div>
        </div>

        <div class="divide-y divide-slate-200">
            @forelse ($letters as $letter)
                <a href="{{ route('letters.show', $letter) }}" class="block p-5 hover:bg-slate-50 transition">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <div class="font-bold text-slate-900 truncate">{{ $letter->subject }}</div>
                            <div class="mt-1 text-sm text-slate-600">
                                Dari: <span class="font-semibold">{{ $letter->sender->name }}</span>
                                → Ke: <span class="font-semibold">{{ $letter->recipient->name }}</span>
                            </div>
                            <div class="mt-1 text-xs text-slate-500">
                                Sent: {{ optional($letter->sent_at)->format('d M Y H:i') ?? '-' }}
                                • Read: {{ optional($letter->read_at)->format('d M Y H:i') ?? 'Belum dibaca' }}
                            </div>
                        </div>

                        <div class="shrink-0">
                            @if($letter->read_at)
                                <span class="ui-badge-green">Dibaca</span>
                            @else
                                <span class="ui-badge-yellow">Belum</span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center text-slate-500">
                    Belum ada surat.
                </div>
            @endforelse
        </div>

        <div class="p-5">
            {{ $letters->links() }}
        </div>
    </div>
</x-app-layout>
