<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tampungan');
    }

    public function proses (Request $request) {
        $kd_pdam = $request->input('kd');
        $data['kd_pdam'] = $kd_pdam;

        $data['pemakaian'] = DB::select("SELECT
                                NAMA_CABANG,
                                pelanggan_aktif,
                                pemakaian_0,
                                ( pelanggan_aktif - pemakaian_0 ) AS efektif,
                                pemakaian,
                                round(( pemakaian / ( pelanggan_aktif - pemakaian_0 )), 3 ) AS pemakaian_rata,
                                round( tagihan / pemakaian ) rata 
                            FROM
                                (
                                SELECT
                                    max( c.NAMA_CABANG ) NAMA_CABANG,
                                    sum( a.NILAI_AIR ) AS tagihan,
                                    sum( d.PEMAKAIAN ) AS pemakaian,
                                    count( CASE WHEN d.pemakaian >= '0' AND pemakaian < '1' THEN 1 END ) AS pemakaian_0,
                                    count( d.id_pelanggan ) AS pelanggan_aktif 
                                FROM
                                    T_PEMBAYARAN a,
                                    T_PELANGGAN b,
                                    T_CABANG c,
                                    T_BILLING d 
                                WHERE
                                    a.ID_PELANGGAN = b.ID_PELANGGAN 
                                    AND b.KD_CABANG = c.KD_CABANG 
                                    AND b.KD_PDAM = c.KD_PDAM 
                                    AND a.TIPE_BAYAR = 'billing' 
                                    AND a.ID_TIPE = d.ID_BILLING 
                                    AND b.KD_PDAM = ".$kd_pdam." 
                                    AND to_number( d.BULAN ) = to_number(
                                    to_char( add_months( SYSDATE,- 1 ), 'MM' )) 
                                    AND to_number( d.TAHUN ) = to_number(
                                    to_char( add_months( SYSDATE,- 1 ), 'YYYY' )) 
                                GROUP BY
                                    b.KD_CABANG 
                                ) 
                            ORDER BY
                                rata ASC");
                            // dd($data['pemakaian']);

        $data['total_pelanggan_aktif'] = 0;
        $data['total_pemakaian_0'] = 0;
        $data['total_pelanggan_efektif'] = 0;
        $data['total_pemakaian_air'] = 0;
        $data['total_rata_pemakaian_air'] = 0;
        $data['total_rata_harga_air'] = 0;
            
        for ($i = 0; $i < count($data['pemakaian']); $i++) {
            $data['total_pelanggan_aktif'] = $data['total_pelanggan_aktif'] + $data['pemakaian'][$i]->pelanggan_aktif;
            $data['total_pemakaian_0'] = $data['total_pemakaian_0'] + $data['pemakaian'][$i]->pemakaian_0;
            $data['total_pelanggan_efektif'] = $data['total_pelanggan_efektif'] + $data['pemakaian'][$i]->efektif;
            $data['total_pemakaian_air'] = $data['total_pemakaian_air'] + $data['pemakaian'][$i]->pemakaian;
            $data['total_rata_pemakaian_air'] = $data['total_rata_pemakaian_air'] + $data['pemakaian'][$i]->pemakaian_rata;
            $data['total_rata_harga_air'] = $data['total_rata_harga_air'] + $data['pemakaian'][$i]->rata;
        }
        
        $data['rata2_pemakaian_air'] = $data['total_rata_pemakaian_air'] / count($data['pemakaian']);
        $data['rata2_harga_air'] = $data['total_rata_harga_air'] / count($data['pemakaian']);

        $data['hitung_pemakaian'] = [];
        $data['data_pemakaian_air_bulanan'] = [];
        $data['data_tambahan_penjualan'] = [];

        for ($i = 0; $i < count($data['pemakaian']); $i++) {
            $data['hitung_pemakaian']['pemakaian_air_bulanan'][$i] = $data['pemakaian'][$i]->pemakaian_0 * $data['rata2_pemakaian_air'];
            $data['hitung_pemakaian']['tambahan_penjualan'][$i] = $data['hitung_pemakaian']['pemakaian_air_bulanan'][$i] * $data['rata2_harga_air'];
            $data['data_pemakaian_air_bulanan'][$i] = $data['hitung_pemakaian']['pemakaian_air_bulanan'][$i];
            $data['data_tambahan_penjualan'][$i] = $data['hitung_pemakaian']['tambahan_penjualan'][$i];
        }

        $data['total_pemakaian_air_bulanan'] = 0;
        $data['total_tambahan_penjualan'] = 0;

        for ($i = 0; $i < count($data['pemakaian']); $i++) {
            $data['total_pemakaian_air_bulanan'] += $data['data_pemakaian_air_bulanan'][$i];
            $data['total_tambahan_penjualan'] += $data['data_tambahan_penjualan'][$i];
        }

        $data['penagihan'] = DB::select("
                                SELECT
                                    NAMA_CABANG,
                                    tagihan,
                                    bayar,
                                    round( bayar / tagihan * 100 ) rata 
                                FROM
                                    (
                                    SELECT
                                        max( c.NAMA_CABANG ) NAMA_CABANG,
                                        sum( a.TAGIHAN ) AS tagihan,
                                        sum( a.TOTAL_BAYAR ) AS bayar 
                                    FROM
                                        T_PEMBAYARAN a,
                                        T_PELANGGAN b,
                                        T_CABANG c 
                                    WHERE
                                        a.ID_PELANGGAN = b.ID_PELANGGAN 
                                        AND b.KD_CABANG = c.KD_CABANG 
                                        AND c.KD_PDAM = b.KD_PDAM 
                                        AND b.KD_PDAM = ". $kd_pdam ." 
                                        AND a.TIPE_BAYAR = 'billing' 
                                        AND to_number( a.BULAN ) = to_number(
                                        to_char( add_months( SYSDATE,- 2 ), 'MM' )) 
                                        AND to_number( a.TAHUN ) = to_number(
                                        to_char( add_months( SYSDATE,- 2 ), 'YYYY' )) 
                                    GROUP BY
                                        b.KD_CABANG 
                                    ) 
                                ORDER BY
                                    rata ASC
                            ");

        $data['total_tagihan'] = 0;
        $data['total_bayar'] = 0;
        for ($i = 0; $i < count($data['penagihan']); $i++) {
            $data['total_tagihan'] = $data['total_tagihan'] + $data['penagihan'][$i]->tagihan;
            $data['total_bayar'] = $data['total_bayar'] + $data['penagihan'][$i]->bayar;
        }
        $data['persentase_bayar'] = $data['total_bayar'] / $data['total_tagihan'] * 100;

        $data['hitung_penagihan'] = [];
        $data['data_opsi_pembayaran_1'] = [];
        $data['data_opsi_pembayaran_2'] = [];
        $data['data_tambahan_pembayaran_1'] = [];
        $data['data_tambahan_pembayaran_2'] = [];

        for ($i = 0; $i < count($data['penagihan']); $i++) {
            $data['hitung_penagihan']['opsi_pembayaran_1'][$i] = $data['penagihan'][$i]->tagihan * 0.7;
            $data['hitung_penagihan']['opsi_pembayaran_2'][$i] = $data['penagihan'][$i]->tagihan * 0.8;
            $data['hitung_penagihan']['tambahan_pembayaran_1'][$i] = $data['hitung_penagihan']['opsi_pembayaran_1'][$i] - $data['penagihan'][$i]->bayar;
            $data['hitung_penagihan']['tambahan_pembayaran_2'][$i] = $data['hitung_penagihan']['opsi_pembayaran_2'][$i] - $data['penagihan'][$i]->bayar;
            $data['data_opsi_pembayaran_1'][$i] = $data['hitung_penagihan']['opsi_pembayaran_1'][$i];
            $data['data_opsi_pembayaran_2'][$i] = $data['hitung_penagihan']['opsi_pembayaran_2'][$i];
            $data['data_tambahan_pembayaran_1'][$i] = $data['hitung_penagihan']['tambahan_pembayaran_1'][$i];
            $data['data_tambahan_pembayaran_2'][$i] = $data['hitung_penagihan']['tambahan_pembayaran_2'][$i];
        }

        $data['total_opsi_pembayaran_1'] = 0;
        $data['total_opsi_pembayaran_2'] = 0;
        $data['total_tambahan_pembayaran_1'] = 0;
        $data['total_tambahan_pembayaran_2'] = 0;

        for ($i = 0; $i < count($data['penagihan']); $i++) {
            $data['total_opsi_pembayaran_1'] += $data['data_opsi_pembayaran_1'][$i];
            $data['total_opsi_pembayaran_2'] +=  $data['data_opsi_pembayaran_2'][$i];
            $data['total_tambahan_pembayaran_1'] += $data['data_tambahan_pembayaran_1'][$i];
            $data['total_tambahan_pembayaran_2'] += $data['data_tambahan_pembayaran_2'][$i];
        }
        
        $data['tunggakan'] = DB::select("
                                SELECT
                                    nama_cabang,
                                    jum_tunggakan,
                                    total_tunggakan,
                                    round( total_tunggakan / jum_tunggakan ) AS tunggakan_rata 
                                FROM
                                    (
                                    SELECT
                                        max( c.nama_cabang ) AS nama_cabang,
                                        count( b.total_tagihan ) AS jum_tunggakan,
                                        sum( b.total_tagihan ) AS total_tunggakan 
                                    FROM
                                        t_pelanggan a,
                                        t_billing b,
                                        t_cabang c 
                                    WHERE
                                        a.id_pelanggan = b.id_pelanggan 
                                        AND a.kd_cabang = c.kd_cabang 
                                        AND a.kd_pdam = c.kd_pdam 
                                        AND a.kd_pdam = ".$kd_pdam." 
                                        AND b.status = 0 
                                        AND b.tahun || lpad( b.bulan, 2, '0' ) <= to_number(
                                        to_char( add_months( SYSDATE,- 1 ), 'YYYY' )) || lpad( to_number( to_char( add_months( SYSDATE,- 1 ), 'MM' )), 2, '0' ) 
                                    GROUP BY
                                        a.kd_cabang 
                                    ) 
                                ORDER BY
                                    nama_cabang ASC
                            ");

        $data['total_tunggakan'] = 0;
        $data['total_besar_tunggakan'] = 0;
        $data['total_rata_tunggakan'] = 0;

        for ($i = 0; $i < count($data['tunggakan']); $i++) {
            $data['total_tunggakan'] = $data['total_tunggakan'] + $data['tunggakan'][$i]->jum_tunggakan;
            $data['total_besar_tunggakan'] = $data['total_besar_tunggakan'] + $data['tunggakan'][$i]->total_tunggakan;
            $data['total_rata_tunggakan'] = $data['total_rata_tunggakan'] + $data['tunggakan'][$i]->tunggakan_rata;
        }

        $data['hitung_tunggakan'] = [];
        for ($i = 0; $i < count($data['tunggakan']); $i++) {
            $data['hitung_tunggakan']['opsi_pelunasan_1'][$i] = $data['tunggakan'][$i]->total_tunggakan * 0.7;
            $data['hitung_tunggakan']['opsi_pelunasan_2'][$i] = $data['tunggakan'][$i]->total_tunggakan * 0.8;
        }

        $data['total_opsi_pelunasan_1'] = 0;
        $data['total_opsi_pelunasan_2'] = 0;

        for ($i = 0; $i < count($data['tunggakan']); $i++) {
            $data['total_opsi_pelunasan_1'] += $data['hitung_tunggakan']['opsi_pelunasan_1'][$i];
            $data['total_opsi_pelunasan_2'] += $data['hitung_tunggakan']['opsi_pelunasan_2'][$i];
        }

        //proses tambahan pendapatan PDAM
        $data['total_tambahan_pdam_1'] = $data['total_tambahan_pembayaran_1'] + $data['total_opsi_pelunasan_1'] + $data['total_tambahan_penjualan'];
        $data['total_tambahan_pdam_2'] = $data['total_tambahan_pembayaran_2'] + $data['total_opsi_pelunasan_2'] + $data['total_tambahan_penjualan'];

        $harga_sekarang = Session::get('harga_sekarang');
        $lama_cicilan = Session::get('lama_cicilan');
        $persentase = Session::get('persentase');

        $data['harga_nanti'] = $harga_sekarang * pow((1 + ($persentase / 100)), $lama_cicilan);  
        $data['harga_cicilan_bulanan'] = $data['harga_nanti'] / 12;

        $data['kemampuan_opsi_1_30'] = $data['total_tambahan_pdam_1'] * 0.3;
        $data['kemampuan_opsi_1_40'] = $data['total_tambahan_pdam_1'] * 0.4;
        $data['kemampuan_opsi_2_30'] = $data['total_tambahan_pdam_2'] * 0.3;
        $data['kemampuan_opsi_2_40'] = $data['total_tambahan_pdam_2'] * 0.4;

        $data['jumlah_meter_air_1_30'] = $data['kemampuan_opsi_1_30'] / $data['harga_cicilan_bulanan'];
        $data['jumlah_meter_air_1_40'] = $data['kemampuan_opsi_1_40'] / $data['harga_cicilan_bulanan'];
        $data['jumlah_meter_air_2_30'] = $data['kemampuan_opsi_2_30'] / $data['harga_cicilan_bulanan'];
        $data['jumlah_meter_air_2_40'] = $data['kemampuan_opsi_2_40'] / $data['harga_cicilan_bulanan'];

        $data['sr1000_opsi_1_30'] = 1000 / $data['jumlah_meter_air_1_30'] * 12;
        $data['sr1000_opsi_1_40'] = 1000 / $data['jumlah_meter_air_1_40'] * 12;
        $data['sr1000_opsi_2_30'] = 1000 / $data['jumlah_meter_air_2_30'] * 12;
        $data['sr1000_opsi_2_40'] = 1000 / $data['jumlah_meter_air_2_40'] * 12;

        $data['sr2000_opsi_1_30'] = 2000 / $data['jumlah_meter_air_1_30'] * 12;
        $data['sr2000_opsi_1_40'] = 2000 / $data['jumlah_meter_air_1_40'] * 12;
        $data['sr2000_opsi_2_30'] = 2000 / $data['jumlah_meter_air_2_30'] * 12;
        $data['sr2000_opsi_2_40'] = 2000 / $data['jumlah_meter_air_2_40'] * 12;

        $data['sr3000_opsi_1_30'] = 3000 / $data['jumlah_meter_air_1_30'] * 12;
        $data['sr3000_opsi_1_40'] = 3000 / $data['jumlah_meter_air_1_40'] * 12;
        $data['sr3000_opsi_2_30'] = 3000 / $data['jumlah_meter_air_2_30'] * 12;
        $data['sr3000_opsi_2_40'] = 3000 / $data['jumlah_meter_air_2_40'] * 12;

        return view('tmp', ['data' => $data]);
    }

    public function vendor() {
        $kd_pdam = request('kd_pdam');
        $vendor = [
            'harga_sekarang'    => request('harga_sekarang'),
            'lama_cicilan'      => request('lama_cicilan'),
            'persentase'        => request('persentase')
        ];
        Session::put('harga_sekarang', request('harga_sekarang'));
        Session::put('lama_cicilan', request('lama_cicilan'));
        Session::put('persentase', request('persentase'));
        return redirect('/proses?kd='.$kd_pdam);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request) {
        $kd_pdam = $request->input('kd');
        
        $data['result'] = DB::select("SELECT
            NAMA_CABANG,
            pelanggan_aktif,
            pemakaian_0,
            ( pelanggan_aktif - pemakaian_0 ) AS efektif,
            pemakaian,
            round(( pemakaian / ( pelanggan_aktif - pemakaian_0 )), 3 ) AS pemakaian_rata,
            round( tagihan / pemakaian ) rata 
        FROM
            (
            SELECT
                max( c.NAMA_CABANG ) NAMA_CABANG,
                sum( a.NILAI_AIR ) AS tagihan,
                sum( d.PEMAKAIAN ) AS pemakaian,
                count( CASE WHEN d.pemakaian >= '0' AND pemakaian < '1' THEN 1 END ) AS pemakaian_0,
                count( d.id_pelanggan ) AS pelanggan_aktif 
            FROM
                T_PEMBAYARAN a,
                T_PELANGGAN b,
                T_CABANG c,
                T_BILLING d 
            WHERE
                a.ID_PELANGGAN = b.ID_PELANGGAN 
                AND b.KD_CABANG = c.KD_CABANG 
                AND b.KD_PDAM = c.KD_PDAM 
                AND a.TIPE_BAYAR = 'billing' 
                AND a.ID_TIPE = d.ID_BILLING 
                AND b.KD_PDAM = ".$kd_pdam." 
                AND to_number( d.BULAN ) = to_number(
                to_char( add_months( SYSDATE,- 1 ), 'MM' )) 
                AND to_number( d.TAHUN ) = to_number(
                to_char( add_months( SYSDATE,- 1 ), 'YYYY' )) 
            GROUP BY
                b.KD_CABANG 
            ) 
        ORDER BY
            rata ASC");
                // dd($data['result']);
                // return view('index', ['data' => $data]);
        return $data['result'];
    }

    public function penagihan(Request $request) {
        $kd_pdam = $request->input('kd');

        $data = DB::select("
            SELECT
                NAMA_CABANG,
                tagihan,
                bayar,
                round( bayar / tagihan * 100 ) rata 
            FROM
                (
                SELECT
                    max( c.NAMA_CABANG ) NAMA_CABANG,
                    sum( a.TAGIHAN ) AS tagihan,
                    sum( a.TOTAL_BAYAR ) AS bayar 
                FROM
                    T_PEMBAYARAN a,
                    T_PELANGGAN b,
                    T_CABANG c 
                WHERE
                    a.ID_PELANGGAN = b.ID_PELANGGAN 
                    AND b.KD_CABANG = c.KD_CABANG 
                    AND c.KD_PDAM = b.KD_PDAM 
                    AND b.KD_PDAM = ". $kd_pdam ." 
                    AND a.TIPE_BAYAR = 'billing' 
                    AND to_number( a.BULAN ) = to_number(
                    to_char( add_months( SYSDATE,- 2 ), 'MM' )) 
                    AND to_number( a.TAHUN ) = to_number(
                    to_char( add_months( SYSDATE,- 2 ), 'YYYY' )) 
                GROUP BY
                    b.KD_CABANG 
                ) 
            ORDER BY
                rata ASC
        ");
        return $data;
    }

    public function tunggakan (Request $request) {
        $kd_pdam = $request->input('kd');

        $data = DB::select("
            SELECT
                nama_cabang,
                jum_tunggakan,
                total_tunggakan,
                round( total_tunggakan / jum_tunggakan ) AS tunggakan_rata 
            FROM
                (
                SELECT
                    max( c.nama_cabang ) AS nama_cabang,
                    count( b.total_tagihan ) AS jum_tunggakan,
                    sum( b.total_tagihan ) AS total_tunggakan 
                FROM
                    t_pelanggan a,
                    t_billing b,
                    t_cabang c 
                WHERE
                    a.id_pelanggan = b.id_pelanggan 
                    AND a.kd_cabang = c.kd_cabang 
                    AND a.kd_pdam = c.kd_pdam 
                    AND a.kd_pdam = ".$kd_pdam." 
                    AND b.status = 0 
                    AND b.tahun || lpad( b.bulan, 2, '0' ) <= to_number(
                    to_char( add_months( SYSDATE,- 1 ), 'YYYY' )) || lpad( to_number( to_char( add_months( SYSDATE,- 1 ), 'MM' )), 2, '0' ) 
                GROUP BY
                    a.kd_cabang 
                ) 
            ORDER BY
                nama_cabang ASC
        ");
        return $data;
    }
}
