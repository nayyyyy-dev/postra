<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-900 leading-tight">User Management</h2>
            <a href="{{ route('users.create') }}" class="ui-btn-primary">Buat User</a>
        </div>
    </x-slot>

    <div class="ui-card float-in overflow-hidden">
        <div class="ui-card-header">
            <div>
                <div class="font-bold text-slate-900">Daftar User</div>
                <div class="text-sm text-slate-500">Hanya super-admin.</div>
            </div>
        </div>

        <div class="divide-y divide-slate-200">
            @foreach ($users as $u)
                <div class="p-5 flex items-center justify-between gap-4">
                    <div class="min-w-0">
                        <div class="font-bold text-slate-900 truncate">{{ $u->name }}</div>
                        <div class="text-sm text-slate-600 truncate">{{ $u->email }}</div>
                        <div class="text-xs text-slate-500">
                            Role: {{ $u->getRoleNames()->implode(', ') ?: '-' }}
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        @if(!$u->hasRole('super-admin'))
                            <form method="POST" action="{{ route('users.destroy', $u) }}" onsubmit="return confirm('Yakin hapus user ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="ui-btn-danger">Hapus</button>
                            </form>
                        @else
                            <span class="ui-badge-blue">Super Admin</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="p-5">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
