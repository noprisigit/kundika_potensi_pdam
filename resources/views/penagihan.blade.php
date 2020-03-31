@extends('layout/main')
@section('title', 'Potensi dari Penagihan')
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
                <button type="button" class="btn btn-info btn-penagihan">Proses</button>
            </div>
        </div>
    </div>
    <!-- Image loader -->
    <div id="loader" style="display: none;">
        <img src="/dist/img/waiting.gif" class="d-flex mx-auto">
    </div>
    <!-- Image loader -->
    <div class="row" id="placement" style="display: none;">
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
                        <tbody id="hasil">

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
                        <tbody id="hasil_perhitungan">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection