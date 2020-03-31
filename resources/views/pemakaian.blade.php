@extends('layout/main')
@section('title', 'Potensi dari Pemakaian 0,00 M3')
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
                <button type="button" class="btn btn-info btn-search">Proses</button>
            </div>
        </div>
    </div>
    <!-- Image loader -->
    <div id="loader" style="display: none;">
        <img src="/dist/img/waiting.gif" class="d-flex mx-auto">
    </div>
    <!-- Image loader -->
    <div class="row" id="placement" style="display: none;">
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
                        <tbody id="hasil">
                            <tr>
                            
                                
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