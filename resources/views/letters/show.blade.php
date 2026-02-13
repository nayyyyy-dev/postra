<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-900 leading-tight">Detail Surat</h2>
            <a href="{{ route('letters.index') }}" class="ui-btn-secondary">Kembali</a>
        </div>
    </x-slot>

    <div class="ui-card float-in">
        <div class="ui-card-body">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <div class="text-xs text-slate-500">Subjek</div>
                    <div class="text-xl font-bold text-slate-900 break-words">{{ $letter->subject }}</div>

                    <div class="mt-3 text-sm text-slate-600">
                        Dari: <span class="font-semibold">{{ $letter->sender->name }}</span> ({{ $letter->sender->email }})<br />
                        Ke: <span class="font-semibold">{{ $letter->recipient->name }}</span> ({{ $letter->recipient->email }})
                    </div>

                    <div class="mt-3 text-xs text-slate-500">
                        Sent: {{ optional($letter->sent_at)->format('d M Y H:i') ?? '-' }}
                        • Read: {{ optional($letter->read_at)->format('d M Y H:i') ?? 'Belum dibaca' }}
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('letters.download', $letter) }}" class="ui-btn-primary">Download PDF</a>

                    @can('delete', $letter)
                        <form method="POST" action="{{ route('letters.destroy', $letter) }}" onsubmit="return confirm('Yakin hapus surat ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="ui-btn-danger">Hapus</button>
                        </form>
                    @endcan
                </div>
            </div>

            @if($letter->body)
                <div class="mt-6">
                    <div class="text-sm font-semibold text-slate-700">Isi Surat</div>
                    <div class="mt-2 whitespace-pre-wrap text-slate-700 leading-relaxed">
                        {{ $letter->body }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
