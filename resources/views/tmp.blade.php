@extends('layout/main')
@section('title', 'Home')
@section('container')
<div class="container-fluid">
    <label for="pilihPDAM">Pilih PDAM</label>
    <form action="/proses" method="get">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <select name="kd" id="kd_pdam" class="form-control" required>
                        <option selected disabled>- Pilih PDAM -</option>
                        <option value="1906">PDAM BELITUNG TIMUR</option>
                        <option value="1303">PDAM KABUPATEN SIJUNJUNG</option>
                        <option value="1304">PDAM KABUPATEN TANAH DATAR</option>
                        <option value="1805">PDAM WAY TULANG BAWANG</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <button type="submit" class="btn btn-info">Proses</button>
                </div>
            </div>
        </div>
    </form>

    <div class="placement mt-3">
        <h3>1. Potensi dari pemakaian 0,00 M3</h3>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-responsive">
                            <thead>                        
                                <tr>
                                    <th class="text-center pb-5" rowspan="2">#</th>
                                    <th class="text-center pb-5" rowspan="2">Nama Cabang</th>
                                    <th class="text-center" width="30px">Pelanggan Aktif</th>
                                    <th class="text-center" width="30px">Pelanggan Pemakaian 0 M3</th>
                                    <th class="text-center">Pelanggan Efektif</th>
                                    <th class="text-center">Pemakaian Air Bulanan</th>
                                    <th class="text-center">Pemakaian Air Rata-Rata</th>
                                    <th class="text-center">Harga Air Rata-Rata</th>
                                </tr>
                                <tr>
                                    <th class="text-center">(JUMLAH)</th>
                                    <th class="text-center">(JUMLAH)</th>
                                    <th class="text-center">(JUMLAH)</th>
                                    <th class="text-center">(M3)</th>
                                    <th class="text-center">(M3)</th>
                                    <th class="text-center">(Rp / M3)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach($data['pemakaian'] as $item)
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td>{{ $item->nama_cabang }}</td>
                                    <td class="text-center">{{ $item->pelanggan_aktif }}</td>
                                    <td class="text-center">{{ $item->pemakaian_0 }}</td>
                                    <td class="text-center">{{ $item->efektif }}</td>
                                    <td class="text-center">{{ $item->pemakaian }}</td>
                                    <td class="text-center">{{ $item->pemakaian_rata }}</td>
                                    <td class="text-center">{{ $item->rata }}</td>
                                </tr>
                                <?php $no++; ?>
                                @endforeach
                                <tr>
                                    <td class="text-center text-bold" colspan="2">Total</td>
                                    <td class="text-center text-bold">{{ $data['total_pelanggan_aktif'] }}</td>
                                    <td class="text-center text-bold">{{ $data['total_pemakaian_0'] }}</td>
                                    <td class="text-center text-bold">{{ $data['total_pelanggan_efektif'] }}</td>
                                    <td class="text-center text-bold">{{ $data['total_pemakaian_air'] }}</td>
                                    <td class="text-center text-bold">{{ $data['rata2_pemakaian_air'] }}</td>
                                    <?php $hasil_rupiah = "Rp " . number_format($data['rata2_harga_air'],2,',','.') ?>
                                    <td class="text-center text-bold"><?= $hasil_rupiah; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>                        
                                <tr>
                                    <th class="text-center" width="130px">Pemakaian Air Bulanan dari Pelanggan 0 M3</th>
                                    <th class="text-center" width="150px">Tambahan Penjualan</th>
                                </tr>
                                <tr>
                                    <th class="text-center">(M3)</th>
                                    <th class="text-center">(Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i = 0; $i < count($data['hitung_pemakaian']['pemakaian_air_bulanan']); $i++)
                                <tr>
                                    <td class="text-center">{{ $data['hitung_pemakaian']['pemakaian_air_bulanan'][$i] }}</td>
                                    <?php $tmbhan_penjualan = "Rp " . number_format($data['hitung_pemakaian']['tambahan_penjualan'][$i],2,',','.') ?>
                                    <td class="text-center"><?= $tmbhan_penjualan; ?></td>
                                </tr>
                                @endfor
                                <tr>
                                    <td class="text-center text-bold">{{ $data['total_pemakaian_air_bulanan'] }}</td>
                                    <?php $total_tmbhan_penjualan = "Rp " . number_format($data['total_tambahan_penjualan'],2,',','.') ?>
                                    <td class="text-center text-bold"><?= $total_tmbhan_penjualan; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>            
                </div>
            </div>
        </div>
    </div>

    <div class="placement mt-3">
        <h3>2. Potensi dari efisiensi penagihan</h3>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>                        
                                <tr>
                                    <th class="text-center pb-5" rowspan="3">#</th>
                                    <th class="text-center pb-5" rowspan="3">Nama Cabang</th>
                                    <th class="text-center" colspan="3">Data</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Penjualan</th>
                                    <th class="text-center">Pembayaran</th>
                                    <th class="text-center">Persentase</th>
                                </tr>
                                <tr>
                                    <th class="text-center">(Rp)</th>
                                    <th class="text-center">(Rp)</th>
                                    <th class="text-center">(%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data['penagihan'] != 0)
                                <?php $no = 1; ?>
                                @foreach($data['penagihan'] as $item)
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td>{{ $item->nama_cabang }}</td>
                                    <?php $hasil_tagihan = "Rp " . number_format($item->tagihan,2,',','.') ?>
                                    <?php $hasil_bayar = "Rp " . number_format($item->bayar,2,',','.') ?>
                                    <td class="text-center"><?= $hasil_tagihan; ?></td>
                                    <td class="text-center"><?= $hasil_bayar; ?></td>
                                    <td class="text-center">{{ $item->rata }} %</td>
                                </tr>
                                <?php $no++; ?>
                                @endforeach
                                <tr>
                                    <td colspan="2" class="text-center text-bold">Total</td>
                                    <?php $total_tagihan = "Rp " . number_format($data['total_tagihan'],2,',','.') ?>
                                    <?php $total_bayar = "Rp " . number_format($data['total_bayar'],2,',','.') ?>
                                    <td class="text-center text-bold"><?= $total_tagihan; ?></td>
                                    <td class="text-center text-bold"><?= $total_bayar; ?></td>
                                    <td class="text-center text-bold"><?= round($data['persentase_bayar']); ?> %</td>
                                </tr>
                                @else
                                    <tr>
                                        <td>Data Belum Ada</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>                        
                                <tr>
                                    <th class="text-center">OPSI KE 1</th>
                                    <th class="text-center">OPSI KE 2</th>
                                    <th class="text-center">OPSI KE 1</th>
                                    <th class="text-center">OPSI KE 2</th>
                                </tr>
                                <tr>
                                    <th class="text-center" colspan="2">Pembayaran Menjadi (Rp)</th>
                                    <th class="text-center" colspan="2">Tambahan Pembayaran (Rp)</th>
                                </tr>
                                <tr>
                                    <th class="text-center">70 %</th>
                                    <th class="text-center">80 %</th>
                                    <th class="text-center">70 %</th>
                                    <th class="text-center">80 %</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < count($data['hitung_penagihan']['opsi_pembayaran_1']); $i++)
                                <tr>
                                    <?php $bayar_1 = "Rp " . number_format($data['hitung_penagihan']['opsi_pembayaran_1'][$i],2,',','.') ?>
                                    <td class="text-center"><?= $bayar_1; ?></td>
                                    <?php $bayar_2 = "Rp " . number_format($data['hitung_penagihan']['opsi_pembayaran_2'][$i],2,',','.') ?>
                                    <td class="text-center"><?= $bayar_2; ?></td>
                                    <?php $tambahan_1 = "Rp " . number_format($data['hitung_penagihan']['tambahan_pembayaran_1'][$i],2,',','.') ?>
                                    <td class="text-center"><?= $tambahan_1; ?></td>
                                    <?php $tambahan_2 = "Rp " . number_format($data['hitung_penagihan']['tambahan_pembayaran_2'][$i],2,',','.') ?>
                                    <td class="text-center"><?= $tambahan_2; ?></td>
                                </tr>
                                @endfor
                                <tr>
                                    <?php $total_bayar_1 = "Rp " . number_format($data['total_opsi_pembayaran_1'],2,',','.') ?>
                                    <td class="text-center text-bold"><?= $total_bayar_1; ?></td>
                                    <?php $total_bayar_2 = "Rp " . number_format($data['total_opsi_pembayaran_2'],2,',','.') ?>
                                    <td class="text-center text-bold"><?= $total_bayar_2; ?></td>
                                    <?php $total_bayar_3 = "Rp " . number_format($data['total_tambahan_pembayaran_1'],2,',','.') ?>
                                    <td class="text-center text-bold"><?= $total_bayar_3; ?></td>
                                    <?php $total_bayar_4 = "Rp " . number_format($data['total_tambahan_pembayaran_2'],2,',','.') ?>
                                    <td class="text-center text-bold"><?= $total_bayar_4; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="placement mt-3">
        <h3>3. Potensi dari tunggakan</h3>
        <div class="row">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>                        
                                <tr>
                                    <th class="text-center pb-5" rowspan="3">#</th>
                                    <th class="text-center pb-5" rowspan="3">Nama Cabang</th>
                                    <th class="text-center" colspan="3">Data</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Jumlah Tunggakan</th>
                                    <th class="text-center">Besaran Tunggakan</th>
                                    <th class="text-center">Tunggakan Rata-Rata</th>
                                </tr>
                                <tr>
                                    <th class="text-center">(JUMLAH)</th>
                                    <th class="text-center">(Rp)</th>
                                    <th class="text-center">(RP / Tunggakan)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach($data['tunggakan'] as $item)
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td>{{ $item->nama_cabang }}</td>
                                    <td class="text-center">{{ $item->jum_tunggakan }}</td>
                                    <?php $besar_tunggakan = "Rp " . number_format($item->total_tunggakan,2,',','.') ?>
                                    <?php $besar_rata_tunggakan = "Rp " . number_format($item->tunggakan_rata,2,',','.') ?>
                                    <td class="text-center"><?= $besar_tunggakan ?></td>
                                    <td class="text-center"><?= $besar_rata_tunggakan ?></td>
                                </tr>
                                <?php $no++; ?>
                                @endforeach
                                <tr>
                                    <td colspan="2" class="text-center text-bold">Total</td>
                                    <td class="text-center text-bold">{{ $data['total_tunggakan'] }}</td>
                                    <?php $total_besar_tunggakan = "Rp " . number_format($data['total_besar_tunggakan'],2,',','.') ?>
                                    <td class="text-center text-bold"><?= $total_besar_tunggakan; ?></td>
                                    <?php $total_rata_tunggakan = "Rp " . number_format($data['total_rata_tunggakan'],2,',','.') ?>
                                    <td class="text-center text-bold"><?= $total_rata_tunggakan; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>                        
                                <tr>
                                    <th class="text-center">OPSI KE 1</th>
                                    <th class="text-center">OPSI KE 2</th>
                                </tr>
                                <tr>
                                    <th class="text-center" colspan="2">Pelunasan Menjadi (Rp)</th>
                                </tr>
                                <tr>
                                    <th class="text-center">70 %</th>
                                    <th class="text-center">80 %</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < count($data['hitung_tunggakan']['opsi_pelunasan_1']); $i++)
                                <tr>
                                    <?php $opsi_lunas_1 = "Rp " . number_format($data['hitung_tunggakan']['opsi_pelunasan_1'][$i],2,',','.') ?>
                                    <td class="text-center"><?= $opsi_lunas_1; ?></td>
                                    <?php $opsi_lunas_2 = "Rp " . number_format($data['hitung_tunggakan']['opsi_pelunasan_2'][$i],2,',','.') ?>
                                    <td class="text-center"><?= $opsi_lunas_2; ?></td>
                                </tr>  
                                @endfor
                                <tr>
                                    <?php $total_opsi_lunas_1 = "Rp " . number_format($data['total_opsi_pelunasan_1'],2,',','.') ?>
                                    <td class="text-center text-bold"><?= $total_opsi_lunas_1; ?></td>
                                    <?php $total_opsi_lunas_2 = "Rp " . number_format($data['total_opsi_pelunasan_2'],2,',','.') ?>
                                    <td class="text-center text-bold"><?= $total_opsi_lunas_2; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="placement mt-3">
        <h2>Tambahan Pendapatan PDAM</h2>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">                    
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="3" class="text-center p-5">Potensi</th>
                                    <th colspan="2" class="text-center">Pilihan</th>
                                </tr>
                                <tr>
                                    <th class="text-center">OPSI KE 1</th>
                                    <th class="text-center">OPSI KE 2</th>
                                </tr>
                                <tr>
                                    <th class="text-center">70%</th>
                                    <th class="text-center">80%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Efisiensi Penagihan</td>
                                    <?php $total_bayar_3 = "Rp " . number_format($data['total_tambahan_pembayaran_1'],2,',','.') ?>
                                    <td class="text-center"><?= $total_bayar_3; ?></td>
                                    <?php $total_bayar_4 = "Rp " . number_format($data['total_tambahan_pembayaran_2'],2,',','.') ?>
                                    <td class="text-center"><?= $total_bayar_4; ?></td>
                                </tr>
                                <tr>
                                    <td>Tunggakan</td>
                                    <?php $total_opsi_lunas_1 = "Rp " . number_format($data['total_opsi_pelunasan_1'],2,',','.') ?>
                                    <td class="text-center"><?= $total_opsi_lunas_1; ?></td>
                                    <?php $total_opsi_lunas_2 = "Rp " . number_format($data['total_opsi_pelunasan_2'],2,',','.') ?>
                                    <td class="text-center"><?= $total_opsi_lunas_2; ?></td>
                                </tr>
                                <tr>
                                    <td>Pemakaian 0 M3</td>
                                    <?php $total_tmbhan_penjualan = "Rp " . number_format($data['total_tambahan_penjualan'],2,',','.') ?>
                                    <td class="text-center"><?= $total_tmbhan_penjualan; ?></td>
                                    <td class="text-center"><?= $total_tmbhan_penjualan; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-bold">Total</td>
                                    <?php $total_tmbhan_pdam_1 = "Rp " . number_format($data['total_tambahan_pdam_1'],2,',','.') ?>
                                    <td class="text-center text-bold"><?= $total_tmbhan_pdam_1; ?></td>
                                    <?php $total_tmbhan_pdam_2 = "Rp " . number_format($data['total_tambahan_pdam_2'],2,',','.') ?>
                                    <td class="text-center text-bold"><?= $total_tmbhan_pdam_2; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="placement mt-3">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Vendor</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="/proses-vendor" method="post" role="form" name="input-vendor">
                         {{ csrf_field() }}
                        <div class="card-body">
                            <input type="hidden" name="kd_pdam" value="{{ $data['kd_pdam'] }}">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Harga Sekarang</label>
                                <input type="number" class="form-control" id="harga_sekarang" name="harga_sekarang" placeholder="Harga Sekarang" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Lama Cicilan</label>
                                <input type="number" class="form-control" id="lama_cicilan" name="lama_cicilan" placeholder="Lama Cicilan (Tahun)" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Interes / Tahun (%)</label>
                                <input type="number" class="form-control" id="persentase" name="persentase" placeholder="Persen Interes" required>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Harga Sekarang</td>
                                    <td>(Rp)</td>
                                    @if(\Session::has('harga_sekarang'))
                                    <?php $harga = "Rp " . number_format(Session::get('harga_sekarang'),2,',','.') ?>
                                    <td class="text-center text-bold">{{ $harga }}</td>
                                    @else
                                    <td>Data Belum Ada</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Lama Cicilan</td>
                                    <td>Tahun</td>
                                    @if(\Session::has('lama_cicilan'))
                                    <td class="text-center text-bold">{{ Session::get('lama_cicilan') }} Tahun</td>
                                    @else
                                    <td>Data Belum Ada</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Interes / Tahun</td>
                                    <td>Prosentase</td>
                                    @if(\Session::has('persentase'))
                                    <td class="text-center text-bold">{{ Session::get('persentase') }} %</td>
                                    @else
                                    <td>Data Belum Ada</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Harga Nanti</td>
                                    <td>Rp</td>
                                    @if(\Session::has('harga_sekarang'))
                                    <?php $harga_nanti = "Rp " . number_format($data['harga_nanti'],2,',','.') ?>
                                    <td class="text-center text-bold">{{ $harga_nanti }}</td>
                                    @else
                                    <td>Data Belum Ada</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Haga Cicilan / Bulan</td>
                                    <td>Rp / Bulan</td>
                                    @if(\Session::has('harga_sekarang'))
                                    <?php $harga_cicilan = "Rp " . number_format($data['harga_cicilan_bulanan'],2,',','.') ?>
                                    <td class="text-center text-bold">{{  $harga_cicilan }}</td>
                                    @else
                                    <td>Data Belum Ada</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="placement mt-3">
        <div class="row">
            <div class="col-lg-8">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title text-uppercase">Resume</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2" align="center" valign="middle">Dari Total</th>
                                    <th colspan="2" class="text-center">Kemampuan</th>
                                    <th colspan="2" class="text-center">Jumlah Meter Air</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Opsi Ke 1</th>
                                    <th class="text-center">Opsi Ke 2</th>
                                    <th class="text-center">Opsi Ke 1</th>
                                    <th class="text-center">Opsi Ke 2</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center text-bold">30%</td>
                                    <?php $kemampuan_opsi_1_30 = "Rp " . number_format($data['kemampuan_opsi_1_30'],2,',','.') ?>
                                    <td class="text-center">{{ $kemampuan_opsi_1_30 }}</td>
                                    <?php $kemampuan_opsi_2_30 = "Rp " . number_format($data['kemampuan_opsi_2_30'],2,',','.') ?>
                                    <td class="text-center">{{ $kemampuan_opsi_2_30 }}</td>
                                    <td class="text-center">{{ round($data['jumlah_meter_air_1_30'], 2) }}</td>
                                    <td class="text-center">{{ round($data['jumlah_meter_air_2_30'], 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center text-bold">40%</td>
                                    <?php $kemampuan_opsi_1_40 = "Rp " . number_format($data['kemampuan_opsi_1_40'],2,',','.') ?>
                                    <td class="text-center">{{ $kemampuan_opsi_1_40 }}</td>
                                    <?php $kemampuan_opsi_2_40 = "Rp " . number_format($data['kemampuan_opsi_2_40'],2,',','.') ?>
                                    <td class="text-center">{{ $kemampuan_opsi_2_40 }}</td>
                                    <td class="text-center">{{ round($data['jumlah_meter_air_1_40'], 2) }}</td>
                                    <td class="text-center">{{ round($data['jumlah_meter_air_2_40'], 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title text-uppercase">Exercise</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" rowspan="3" style="vertical-align: middle">% dari Pendapatan</th>
                                    <th class="text-center">Jumlah SR =</th>
                                    <th class="text-center">1000</th>
                                    <th class="text-center">Jumlah SR =</th>
                                    <th class="text-center">2000</th>
                                    <th class="text-center">Jumlah SR =</th>
                                    <th class="text-center">3000</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Opsi Ke 1</th>
                                    <th class="text-center">Opsi Ke 2</th>
                                    <th class="text-center">Opsi Ke 1</th>
                                    <th class="text-center">Opsi Ke 2</th>
                                    <th class="text-center">Opsi Ke 1</th>
                                    <th class="text-center">Opsi Ke 2</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Cicilan (bulan)</th>
                                    <th class="text-center">Cicilan (bulan)</th>
                                    <th class="text-center">Cicilan (bulan)</th>
                                    <th class="text-center">Cicilan (bulan)</th>
                                    <th class="text-center">Cicilan (bulan)</th>
                                    <th class="text-center">Cicilan (bulan)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center text-bold">30%</td>
                                    <td class="text-center">{{ $data['sr1000_opsi_1_30'] }}</td>
                                    <td class="text-center">{{ $data['sr1000_opsi_2_30'] }}</td>
                                    <td class="text-center">{{ $data['sr2000_opsi_1_30'] }}</td>
                                    <td class="text-center">{{ $data['sr2000_opsi_2_30'] }}</td>
                                    <td class="text-center">{{ $data['sr3000_opsi_1_30'] }}</td>
                                    <td class="text-center">{{ $data['sr3000_opsi_2_30'] }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center text-bold">40%</td>
                                    <td class="text-center">{{ $data['sr1000_opsi_1_40'] }}</td>
                                    <td class="text-center">{{ $data['sr1000_opsi_2_40'] }}</td>
                                    <td class="text-center">{{ $data['sr2000_opsi_1_40'] }}</td>
                                    <td class="text-center">{{ $data['sr2000_opsi_2_40'] }}</td>
                                    <td class="text-center">{{ $data['sr3000_opsi_1_40'] }}</td>
                                    <td class="text-center">{{ $data['sr3000_opsi_2_40'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection