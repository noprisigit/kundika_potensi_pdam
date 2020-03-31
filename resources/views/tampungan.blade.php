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

    
</div>
<!-- /.container-fluid -->
@endsection