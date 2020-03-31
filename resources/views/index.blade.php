@extends('layout/main')
@section('title', 'Home')
@section('container')
<div class="container-fluid">
    <label for="pilihPDAM">Pilih PDAM</label>
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
                <button type="button" class="btn btn-info btn-proses">Proses</button>
            </div>
        </div>
    </div>

    <!-- Image loader -->
    <div id="loader" style="display: none;">
        <img src="/dist/img/waiting.gif" class="d-flex mx-auto">
    </div>
    <!-- Image loader -->

    <div class="placement mt-3" style="display: none;">
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
                            <tbody id="hasil_pemakaian">
                    
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
                            <tbody id="hasil_hitung_pemakaian">
                            </tbody>
                        </table>
                    </div>            
                </div>
            </div>
        </div>
    </div>

    <div class="placement mt-3" style="display: none;">
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
                            <tbody id="hasil_penagihan">

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
                            <tbody id="hasil_hitung_penagihan">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="placement mt-3" style="display: none;">
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
                            <tbody id="hasil_tunggakan">

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
                            <tbody id="hasil_hitung_tunggakan">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="placement mt-3" style="display: none;">
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
                                    <td id="penagihan_70"></td>
                                    <td id="penagihan_80"></td>
                                </tr>
                                <tr>
                                    <td>Tunggakan</td>
                                    <td id="penagihan_70"></td>
                                    <td id="penagihan_80"></td>
                                </tr>
                                <tr>
                                    <td>Pemakaian 0 M3</td>
                                    <td id="penagihan_70"></td>
                                    <td id="penagihan_80"></td>
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