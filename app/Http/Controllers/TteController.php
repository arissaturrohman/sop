<?php

namespace App\Http\Controllers;

use App\Models\Sop;
use Illuminate\Http\Request;

class TteController extends Controller
{
    public function submitTte($slug)
    {
        $sop = Sop::where('slug', $slug)->firstOrFail();

        // Ganti status menjadi 'TTE'
        $sop->status = 'TTE';
        $sop->feedback = 'Ditandatangani secara elektronik';
        $sop->signed_at = now()->toDateTimeString();
        $sop->save();

        return redirect()->back()->with('success', 'Dokumen berhasil ditandatangani secara elektronik.');
    }
}
