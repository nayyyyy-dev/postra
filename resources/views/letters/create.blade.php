<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-900 leading-tight">Kirim Surat</h2>
    </x-slot>

    <div class="ui-card float-in">
        <div class="ui-card-body">
            <form method="POST" action="{{ route('letters.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-700">Penerima</label>
                    <select name="recipient_id" class="ui-select mt-1">
                        <option value="">-- Pilih Penerima --</option>
                        @foreach ($users as $u)
                            <option value="{{ $u->id }}" @selected(old('recipient_id') == $u->id)>
                                {{ $u->name }} ({{ $u->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('recipient_id') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700">Subjek</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" class="ui-input mt-1" placeholder="Contoh: Undangan Rapat" />
                    @error('subject') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700">Isi Surat (opsional)</label>
                    <textarea name="body" rows="6" class="ui-textarea mt-1" placeholder="Tulis isi surat...">{{ old('body') }}</textarea>
                    <div class="mt-1 text-xs text-slate-500">Jika tidak upload PDF, sistem akan generate PDF dari isi surat.</div>
                    @error('body') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700">Upload PDF (opsional)</label>
                    <input type="file" name="pdf_file" accept="application/pdf"
                        class="mt-1 w-full rounded-xl border border-slate-200 file:mr-4 file:py-2 file:px-4
                               file:rounded-xl file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition"/>
                    <div class="mt-1 text-xs text-slate-500">Maks 5MB. Jika diupload, file ini yang dikirim.</div>
                    @error('pdf_file') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="ui-btn-primary">Kirim</button>
                    <a href="{{ route('letters.index') }}" class="ui-btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    @if ($errors->any())
        <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700 float-in">
            Ada error validasi. Periksa field yang ditandai.
        </div>
    @endif
</x-app-layout>
