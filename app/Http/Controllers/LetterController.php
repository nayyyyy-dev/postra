<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;
 

class LetterController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $q = Letter::query()->with(['sender', 'recipient'])->latest();

        if (! $user->hasAnyRole(['super-admin', 'admin'])) {
            $q->where(function ($w) use ($user) {
                $w->where('sender_id', $user->id)
                  ->orWhere('recipient_id', $user->id);
            });
        }

        $letters = $q->paginate(10);

        return view('letters.index', compact('letters'));
    }

    public function create()
    {
        $this->authorize('create', Letter::class);

        $users = User::query()
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('letters.create', compact('users'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Letter::class);

        $data = $request->validate([
            'recipient_id' => ['required', 'integer', Rule::exists('users', 'id')],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'pdf_file' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5MB
        ]);

        $sender = $request->user();

        // Folder penyimpanan
        $dir = 'public/letters';
        Storage::makeDirectory($dir);

        $pdfPath = null;

        if ($request->hasFile('pdf_file')) {
            // Upload PDF
            $pdfPath = $request->file('pdf_file')->store($dir);
        } else {
            // Generate PDF dari body
            $pdf = Pdf::loadView('letters.pdf', [
                'sender' => $sender,
                'recipient' => User::findOrFail($data['recipient_id']),
                'subject' => $data['subject'],
                'body' => $data['body'] ?? '',
                'date' => now(),
            ])->setPaper('a4');

            $filename = 'public/letters/letter_' . now()->format('Ymd_His') . '_' . $sender->id . '.pdf';
            Storage::put($filename, $pdf->output());
            $pdfPath = $filename;
        }

        $letter = Letter::create([
            'sender_id' => $sender->id,
            'recipient_id' => $data['recipient_id'],
            'subject' => $data['subject'],
            'body' => $data['body'] ?? null,
            'pdf_path' => $pdfPath,
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        return redirect()->route('letters.show', $letter)->with('success', 'Surat berhasil dikirim.');
    }

    public function show(Letter $letter)
    {
        $this->authorize('view', $letter);

        // Jika recipient membuka, tandai read_at
        $user = Auth::user();
        if ($user && $user->id === $letter->recipient_id && $letter->read_at === null) {
            $letter->update(['read_at' => now()]);
        }

        return view('letters.show', compact('letter'));
    }

    public function download(Letter $letter)
    {
        $this->authorize('view', $letter);

        $path = $letter->pdf_path;
        if (!Storage::exists($path)) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        // Convert "public/..." to actual downloadable
        $downloadName = 'Postra_' . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $letter->subject) . '.pdf';

        return Storage::download($path, $downloadName);
    }

    public function destroy(Letter $letter)
    {
        $this->authorize('delete', $letter);

        if ($letter->pdf_path && Storage::exists($letter->pdf_path)) {
            Storage::delete($letter->pdf_path);
        }

        $letter->delete();

        return redirect()->route('letters.index')->with('success', 'Surat berhasil dihapus.');
    }
}
