@extends('layout/main')
@section('title', 'Data Vendor')
@section('container')
<div class="container-fluid">
    <label for="pilihPDAM">Pilih PDAM</label>
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
                            <button type="button" class="btn btn-primary btn-vendor">Submit</button>
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
                                </tr>
                                <tr>
                                    <td>Lama Cicilan</td>
                                    <td>Tahun</td>
                                    <td class="text-bold">14</td>
                                </tr>
                                <tr>
                                    <td>Interes / Tahun</td>
                                    <td>Prosentase</td>
                                    <td class="text-bold">14%</td>
                                </tr>
                                <tr>
                                    <td>Harga Nanti</td>
                                    <td>Rp</td>
                                    <td class="text-bold">285000</td>
                                </tr>
                                <tr>
                                    <td>Haga Cicilan / Bulan</td>
                                    <td>Rp / Bulan</td>
                                    <td class="text-bold">23750</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    
</div>
<!-- /.container-fluid -->
@endsection