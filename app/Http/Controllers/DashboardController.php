<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pelanggan = DB::table('t_pelanggan')->orderBy('id_pelanggan')->get();
        $transaksi = DB::table('t_transaksi')->orderBy('id_transaksi')->get();

        // Hasil join 1:1 (sesuai seed Anda)
        $joined = DB::table('t_transaksi as t')
            ->join('t_pelanggan as p', 'p.id_pelanggan', '=', 't.id_pelanggan')
            ->select('t.id_transaksi', 't.id_pelanggan','t.tanggal_transaksi','t.total_transaksi','p.nama_pelanggan','p.email','p.no_hp')
            ->orderBy('t.id_pelanggan')
            ->get();

        return view('dashboard', compact('pelanggan','transaksi','joined'));
    }

    public function create(Request $request){
        $request->validate([
            'id_pelanggan' => 'required|integer',
            'tanggal_transaksi' => 'required|date',
            'total_transaksi' => 'required|numeric'
        ]);

        DB::table('t_transaksi')->insert([
            'id_pelanggan' => $request->id_pelanggan,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'total_transaksi' => $request->total_transaksi
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dibuat'
        ], JsonResponse::HTTP_OK);
    }

public function destroy(int $id)
{
    // Hapus dd($id); itu akan menghentikan eksekusi.
    $deleted = DB::table('t_transaksi')
        ->where('id_transaksi', $id)
        ->delete();

    if ($deleted) {
        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dihapus'
        ], JsonResponse::HTTP_OK);
    }

    return response()->json([
        'success' => false,
        'message' => 'Transaksi tidak ditemukan'
    ], JsonResponse::HTTP_NOT_FOUND);
}





    
}
