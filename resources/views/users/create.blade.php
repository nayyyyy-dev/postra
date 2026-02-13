<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-900 leading-tight">Buat User</h2>
    </x-slot>

    <div class="ui-card float-in">
        <div class="ui-card-body">
            <form method="POST" action="{{ route('users.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-700">Nama</label>
                    <input name="name" value="{{ old('name') }}" class="ui-input mt-1" />
                    @error('name') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700">Email</label>
                    <input name="email" value="{{ old('email') }}" class="ui-input mt-1" />
                    @error('email') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700">Password</label>
                    <input type="password" name="password" class="ui-input mt-1" />
                    @error('password') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700">Role</label>
                    <select name="role" class="ui-select mt-1">
                        <option value="admin" @selected(old('role') === 'admin')>admin</option>
                        <option value="supervisor" @selected(old('role') === 'supervisor')>supervisor</option>
                    </select>
                    @error('role') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button class="ui-btn-primary">Simpan</button>
                    <a href="{{ route('users.index') }}" class="ui-btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    @if ($errors->any())
        <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700 float-in">
            Ada error validasi. Periksa input.
        </div>
    @endif
</x-app-layout>
