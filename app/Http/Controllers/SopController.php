<?php

namespace App\Http\Controllers;

use App\Models\Sop;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class SopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Sop::with('user')->latest();

        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        $sops = $query->get();

        return view('sops.index', compact('sops'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('sops.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'file'      => 'required|file|mimes:pdf|max:2048',
            'user_id'   => 'required|exists:users,id',
            'deskripsi' => 'nullable|string',
            'status'    => 'nullable|in:draft,tolak,review,tte',
        ]);

        $filePath = $request->file('file')->store('sops', 'public');

        Sop::create([
            'judul'     => $request->judul,
            'slug'      => Str::slug($request->judul) . '-' . uniqid(),
            'file'      => $filePath,
            'user_id'   => Auth::id(),
            'deskripsi' => $request->deskripsi,
            'status'    => $request->input('status', 'draft'),
            'opd_id'    => Auth::user()->opd_id,
        ]);

        return redirect()->route('sops.index')->with('success', 'Dokumen berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sop = Sop::with('user')->findOrFail($id);
        return view('sops.show', compact('sop'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sop = Sop::findOrFail($id);
        $users = User::all();
        return view('sops.edit', compact('sop', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // logger('Request Data:', $request->all());
        if (!$request->has('status')) {
            Log::error('STATUS TIDAK ADA', $request->all());
            abort(400, 'Field status wajib ada');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'file'      => 'nullable|file|mimes:pdf|max:2048',
            'user_id' => 'required|exists:users,id',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string|in:draft,review,disetujui,ditolak,tte',
        ]);

        if ($request->status === 'ditolak' && empty($request->feedback)) {
            return back()->withErrors(['feedback' => 'Feedback wajib diisi jika status ditolak']);
        }

        $sop = Sop::findOrFail($id);
        // Jika status ditolak, feedback harus diisi
        // Jika status bukan ditolak, feedback boleh kosong
        $originalStatus = $request->status;
        $finalStatus = $originalStatus === 'ditolak' ? 'review' : $originalStatus;

        $data = [
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul) . '-' . uniqid(),
            'user_id' => $request->user_id,
            'deskripsi' => $request->deskripsi,
            'status' => $finalStatus,
            'feedback' => $finalStatus === 'review' ? $request->feedback : null,
        ];

        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($sop->file && Storage::disk('public')->exists($sop->file)) {
                Storage::disk('public')->delete($sop->file);
            }
            // Simpan file baru
            $data['file'] = $request->file('file')->store('sops', 'public');
        }

        if ($request->status === 'ditolak') {
            $data['feedback'] = $request->feedback;
        } else {
            $data['feedback'] = null; // Kosongkan jika status bukan tolak
        }

        $sop->update($data);

        return redirect()->route('sops.index')->with('success', 'Dokumen berhasil diperbarui, status ' . ucfirst($finalStatus) . '!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sop = Sop::findOrFail($id);

        if ($sop->file && Storage::disk('public')->exists($sop->file)) {
            Storage::disk('public')->delete($sop->file);
        }

        $sop->delete();

        return redirect()->route('sops.index')->with('success', 'Dokumen berhasil dihapus');
    }

    /**
     * Preview the specified resource.
     */
    public function preview($slug)
    {
        $sop = Sop::where('slug', $slug)->firstOrFail();

        return view('sops.show', compact('sop'));
    }

    public function stream($slug)
    {
        $sop = Sop::where('slug', $slug)->firstOrFail();

        // if (in_array($sop->status, ['draft'])) {
        //     $sop->status = 'review';
        //     $sop->save();
        // }

        $path = storage_path('app/public/' . $sop->file);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->stream(function () use ($path) {
            readfile($path);
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . Str::slug($sop->file) . '.pdf"',
            'X-Content-Type-Options' => 'nosniff',
            'Content-Transfer-Encoding' => 'binary',
            'Accept-Ranges' => 'bytes',
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, max-age=0, must-revalidate',
            'Pragma' => 'public',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $sop = Sop::findOrFail($id);

        // Cek perubahan status dan feedback sebelum update
        $updated = false;

        if ($sop->status !== $request->status) {
            $sop->status = $request->status;
            $updated = true;
        }

        if ($sop->feedback !== $request->feedback) {
            $sop->feedback = $request->feedback;
            $updated = true;
        }

        if ($sop->user_id !== Auth::id()) {
            $sop->user_id = Auth::id();
            $updated = true;
        }
        // Jika ada perubahan, simpan ke database
        if ($sop->status === 'disetujui') {
            $sop->status = 'disetujui';
            $sop->feedback = $request->feedback;
            $updated = true;
        } elseif ($sop->status === 'ditolak') {
            $sop->status = 'ditolak';
            $sop->feedback = $request->feedback;
            $updated = true;
        }
        if ($updated) {
            $sop->save();
            return redirect()->route('sops.index')->with('success', 'Dokumen berhasil diperbarui! Status saat ini: ' . ucfirst($sop->status));
        } else {
            return redirect()->route('sops.index')->with('info', 'Tidak ada perubahan pada dokumen.');
        }
    }

    public function processTte($slug)
    {
        $sop = Sop::where('slug', $slug)->firstOrFail();

        if ($sop->status !== 'disetujui') {
            return redirect()->route('sops.index')->with('error', 'Dokumen tidak dalam status disetujui untuk TTE.');
        }

        // Logika untuk proses TTE
        // Misalnya, menandai dokumen sebagai TTE atau mengirim notifikasi

        return view('sops.tte', compact('sop'));
    }

    public function review($slug)
    {
        $sop = Sop::where('slug', $slug)->firstOrFail();

        if ($sop->status === 'draft') {
            $sop->status = 'review';
            $sop->save();
        }

        return redirect()->back()->with('success', 'SOP berhasil diajukan untuk review.');
    }
}
