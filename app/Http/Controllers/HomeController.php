<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Sop;
use App\Models\Visitor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // ======================
        // 📌 Pencatatan Pengunjung
        // ======================
        $ip = $request->ip();
        $agent = $request->userAgent();

        // Cek apakah IP sudah tercatat hari ini
        $exists = Visitor::where('ip_address', $ip)
            ->whereDate('visited_at', now()->toDateString())
            ->exists();

        if (!$exists) {
            Visitor::create([
                'ip_address' => $ip,
                'user_agent' => $agent,
                'visited_at' => now(),
            ]);
        }

        // Hitung statistik
        $today  = Visitor::whereDate('visited_at', now()->toDateString())->count();
        $month  = Visitor::whereMonth('visited_at', now()->month)
            ->whereYear('visited_at', now()->year)
            ->count();
        $total  = Visitor::count();

        // ======================
        // 📌 Query Data SOP
        // ======================

        $query = Sop::with('opd', 'user')->latest();

        // Filter by keyword (judul atau nomor dokumen)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                    ->orWhereHas('opd', function ($q2) use ($request) {
                        $q2->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // Filter by OPD
        if ($request->filled('opd')) {
            $query->where('opd_id', $request->opd);
        }

        // Filter by Tahun
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        // Filter by Jenis Dokumen
        // if ($request->filled('jenis')) {
        //     $query->where('jenis', $request->jenis);
        // misalnya 'SOP' atau 'SP'
        // }

        $sops = $query->paginate(10);
        $opds = Opd::all();
        $tahunList = Sop::selectRaw('YEAR(created_at) as tahun')->distinct()->pluck('tahun');

        return view('index', compact('sops', 'opds', 'tahunList', 'today', 'month', 'total'));
    }
}
