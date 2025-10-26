<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $pelanggan = DB::table('t_pelanggan')->orderBy('id_pelanggan')->get();
        $transaksi = DB::table('t_transaksi')->orderBy('id_transaksi')->get();

        // Hasil join 1:1 (sesuai seed Anda)
        $joined = DB::table('t_transaksi as t')
            ->join('t_pelanggan as p', 'p.id_pelanggan', '=', 't.id_pelanggan')
            ->select('t.id_pelanggan','t.tanggal_transaksi','t.total_transaksi','p.nama_pelanggan','p.email','p.no_hp')
            ->orderBy('t.id_pelanggan')
            ->get();

        return view('dashboard', compact('pelanggan','transaksi','joined'));
    }
}
