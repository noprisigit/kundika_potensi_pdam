<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>AdminLTE 3 | @yield('title')</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-dark navbar-info">
            <div class="container-fluid">
                <a href="../../index3.html" class="navbar-brand">
                    <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">AdminLTE 3</span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="/" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="/potensi-pemakaian" class="nav-link">Pemakaian</a>
                        </li>
                        <li class="nav-item">
                            <a href="/potensi-penagihan" class="nav-link">Penagihan</a>
                        </li>
                        <li class="nav-item">
                            <a href="/potensi-tunggakan" class="nav-link">Tunggakan</a>
                        </li>            
                    </ul>
                </div>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"> @yield('title') </h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Layout</a></li>
                                <li class="breadcrumb-item active">Top Navigation</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                @yield('container')
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/dist/js/accounting.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/dist/js/adminlte.min.js"></script>
    <script>     
        let pendapatan_1;   
        let opsi_1, opsi_2;
        let tunggakan_1, tunggakan_2;
        $(document).on('click', '.btn-proses', function (e) {
            $('.placement').hide();

            var value = $('#kd_pdam').val();

            // Potensi pemakaian
            var total_pelanggan_aktif = 0;
            var total_pemakaian_nol = 0;
            var total_pelanggan_efektif = 0;
            var total_pemakaian_air = 0;
            var total_pemakaian_air_rata = 0;
            var total_harga_air = 0;
            var avg_pemakaian_air = 0;
            var avg_harga_air = 0;
            var pemakaian_dari_pelanggan_nol = [];
            var tmp_pemakaian_nol = [];
            // Akhir Potensi Pemakaian

            // Potensi penagihan
            let total_tagihan = 0;
            let total_bayar = 0;
            let total_presentase = 0;

            let data_opsi_pembayaran = [];
            let data_bayar = [];
            // Akhir Potensi Penagihan

            // Potensi Tunggakan
            let total_jum_tunggakan = 0;
            let total_besar_tunggakan = 0;
            let total_rata_tunggakan = 0;

            let data_besaran_tunggakan = [];
            // Akhir Potensi Tunggakan

            if (value == null) {
                alert('Pilih PDAM');
                e.preventDefault();
            } else {
                // Potensi Pemakaian
                $.ajax({
                    url: '/search',
                    type: 'get',
                    data: { kd: value },
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function (res) {
                        let ujung = res.length;
                        
                        $('#hasil_pemakaian').empty();
                        $('#hasil_hitung_pemakaian').empty();
                        if (res.length > 0) {
                            for (var i = 0; i < res.length; i++) {
                                total_pelanggan_aktif = total_pelanggan_aktif + parseInt(res[i]['pelanggan_aktif']);
                                total_pemakaian_nol = total_pemakaian_nol + parseInt(res[i]['pemakaian_0']);
                                total_pelanggan_efektif = total_pelanggan_efektif + parseInt(res[i]['efektif']);
                                total_pemakaian_air = total_pemakaian_air + parseInt(res[i]['pemakaian']);
                                total_pemakaian_air_rata = total_pemakaian_air_rata + parseFloat(res[i]['pemakaian_rata']);
                                total_harga_air = total_harga_air + parseInt(res[i]['rata']);

                                tmp_pemakaian_nol[i] = parseInt(res[i]['pemakaian_0']);
                                
                                $('#hasil_pemakaian').append(`
                                    <tr>
                                        <td class="text-center">` + (i+1) + `</td>
                                        <td>` + res[i]['nama_cabang'] + `</td>
                                        <td class="text-center">` + res[i]['pelanggan_aktif'] + `</td>
                                        <td class="text-center">` + res[i]['pemakaian_0'] + `</td>
                                        <td class="text-center">` + res[i]['efektif'] + `</td>
                                        <td class="text-center">` + res[i]['pemakaian'] + `</td>
                                        <td class="text-center">` + res[i]['pemakaian_rata'] + `</td>
                                        <td class="text-center">` + accounting.formatMoney(res[i]['rata'], "Rp. ", 2, ".", ",") + `</td>
                                    </tr>
                                `);
                            }

                            avg_pemakaian_air = (total_pemakaian_air_rata / res.length);
                            avg_harga_air = (total_harga_air / res.length);
                            var total_pemakaian_dari_pelanggan_nol = 0;
                            var tambahan_penjualan = [];
                            var total_tambahan_penjualan = 0;

                            for (var i=0; i < ujung; i++) {
                                pemakaian_dari_pelanggan_nol[i] = tmp_pemakaian_nol[i] * avg_pemakaian_air;
                                total_pemakaian_dari_pelanggan_nol = total_pemakaian_dari_pelanggan_nol + pemakaian_dari_pelanggan_nol[i];

                                tambahan_penjualan[i] = pemakaian_dari_pelanggan_nol[i] * avg_harga_air
                                total_tambahan_penjualan = total_tambahan_penjualan + tambahan_penjualan[i]
                                
                                $('#hasil_hitung_pemakaian').append(`
                                    <tr>
                                        <td class="text-center">` + pemakaian_dari_pelanggan_nol[i].toFixed(2) + `</td>
                                        <td class="text-center">` + accounting.formatMoney(tambahan_penjualan[i], "Rp. ", 2, ".", ",") + `</td>
                                    </tr>
                                `);
                            }                           
                            get_total_tambahan_penjualan(total_tambahan_penjualan);
                            $('#hasil_pemakaian').append(`
                                <tr>
                                    <td class="text-center text-bold" colspan="2">Total</td>
                                    <td class="text-center text-bold">` + total_pelanggan_aktif + `</td>
                                    <td class="text-center text-bold">` + total_pemakaian_nol + `</td>
                                    <td class="text-center text-bold">` + total_pelanggan_efektif + `</td>
                                    <td class="text-center text-bold">` + total_pemakaian_air + `</td>
                                    <td class="text-center text-bold">` + avg_pemakaian_air.toFixed(2) + `</td>
                                    <td class="text-center text-bold">` + accounting.formatMoney(avg_harga_air.toFixed(2), "Rp. ", 2, ".", ",") + `</td>
                                </tr>
                            `);
                            $('#hasil_hitung_pemakaian').append(`
                                <tr>
                                    <td class="text-center text-bold">` + total_pemakaian_dari_pelanggan_nol.toFixed(2) + `</td>
                                    <td class="text-center text-bold">` + accounting.formatMoney(total_tambahan_penjualan, "Rp. ", 2, ".", ",") + `</td>
                                </tr>
                            `);

                        } else {
                            $('#hasil_pemakaian').append(`
                                <tr>
                                    <td class="text-center" colspan="8">Data Belum Ada</td>  
                                </tr>  
                            `);
                            $('#hasil_hitung_pemakaian').append(`
                                <tr>
                                    <td class="text-center" colspan="2">Data Belum Ada</td>  
                                </tr> 
                            `);
                        }
                    },
                    complete: function () {
                        $('#loader').hide();
                        $('.placement').show();
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });

                // Potensi Penagihan
                $.ajax({
                    url: '/penagihan',
                    type: 'get',
                    data: { kd: value},
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function (res) {
                        let x = res.length;
                        $('#hasil_penagihan').empty();
                        $('#hasil_hitung_penagihan').empty();
                        if (res.length > 0) {
                            for (let i = 0; i < res.length; i++) {
                                total_tagihan = total_tagihan + parseInt(res[i]['tagihan']);
                                total_bayar = total_bayar + parseInt(res[i]['bayar']);
                                total_presentase = total_presentase + parseInt(res[i]['rata']);

                                data_opsi_pembayaran[i] = res[i]['tagihan'];
                                data_bayar[i] = res[i]['bayar'];

                                $('#hasil_penagihan').append(`
                                    <tr>
                                        <td class="text-center">` + (i+1) + `</td>
                                        <td>` + res[i]['nama_cabang'] + `</td>
                                        <td class="text-center">` + accounting.formatMoney(res[i]['tagihan'], "Rp. ", 2, ".", ",") + `</td>
                                        <td class="text-center">` + accounting.formatMoney(res[i]['bayar'], "Rp. ", 2, ".", ",") + `</td>
                                        <td class="text-center">` + res[i]['rata'] + ' %' + `</td>
                                    </tr>
                                `);
                            }

                            let opsi_pembayaran_1 = [];
                            let opsi_pembayaran_2 = [];
                            let total_opsi_pembayaran_1 = 0;
                            let total_opsi_pembayaran_2 = 0;

                            let opsi_tambahan_1 = [];
                            let opsi_tambahan_2 = [];
                            let total_opsi_tambahan_1 = 0;
                            let total_opsi_tambahan_2 = 0;
                            
                            for (let i = 0; i < res.length; i++) {
                                opsi_pembayaran_1[i] = data_opsi_pembayaran[i] * 0.7;
                                total_opsi_pembayaran_1 = total_opsi_pembayaran_1 + opsi_pembayaran_1[i];

                                opsi_pembayaran_2[i] = data_opsi_pembayaran[i] * 0.8;
                                total_opsi_pembayaran_2 = total_opsi_pembayaran_2 + opsi_pembayaran_2[i];

                                opsi_tambahan_1[i] = opsi_pembayaran_1[i] - data_bayar[i];
                                total_opsi_tambahan_1 = total_opsi_tambahan_1 + opsi_tambahan_1[i];

                                opsi_tambahan_2[i] = opsi_pembayaran_2[i] - data_bayar[i];
                                total_opsi_tambahan_2 = total_opsi_tambahan_2 + opsi_tambahan_2[i];

                                $('#hasil_hitung_penagihan').append(`
                                    <tr>
                                        <td class="text-center">` + accounting.formatMoney(Math.round(opsi_pembayaran_1[i]), "Rp. ", 2, ".", ",") + `</td>
                                        <td class="text-center">` + accounting.formatMoney(Math.round(opsi_pembayaran_2[i]), "Rp. ", 2, ".", ",") + `</td>
                                        <td class="text-center">` + accounting.formatMoney(Math.round(opsi_tambahan_1[i]), "Rp. ", 2, ".", ",") + `</td>
                                        <td class="text-center">` + accounting.formatMoney(Math.round(opsi_tambahan_2[i]), "Rp. ", 2, ".", ",") + `</td>
                                    </tr>
                                `);
                            }

                            let rata_presentase;
                            rata_presentase = total_bayar / total_tagihan * 100;

                            $('#hasil_penagihan').append(`
                                <tr>
                                    <td class="text-center text-bold" colspan="2">Total</td>
                                    <td class="text-center text-bold">` + accounting.formatMoney(total_tagihan, "Rp. ", 2, ".", ",") + `</td>
                                    <td class="text-center text-bold">` + accounting.formatMoney(total_bayar, "Rp. ", 2, ".", ",") + `</td>
                                    <td class="text-center text-bold">` + Math.round(rata_presentase) + ' %' + `</td>
                                </tr>
                            `)
                            $('#hasil_hitung_penagihan').append(`
                                <tr>
                                    <td class="text-center text-bold">` + accounting.formatMoney(total_opsi_pembayaran_1, "Rp. ", 2, ".", ",") + `</td>
                                    <td class="text-center text-bold">` + accounting.formatMoney(total_opsi_pembayaran_2, "Rp. ", 2, ".", ",") + `</td>
                                    <td class="text-center text-bold" id="total_opsi_tambahan_1">` + accounting.formatMoney(total_opsi_tambahan_1, "Rp. ", 2, ".", ",") + `</td>
                                    <td class="text-center text-bold" id="total_opsi_tambahan_2">` + accounting.formatMoney(total_opsi_tambahan_2, "Rp. ", 2, ".", ",") + `</td>
                                </tr>
                            `);

                            
                        } else {
                            $('#hasil_penagihan').append(`
                                <tr>
                                    <td class="text-center" colspan="5">Data Belum Ada</td>  
                                </tr>  
                            `);
                            $('#hasil_hitung_penagihan').append(`
                                <tr>
                                    <td class="text-center" colspan="4">Data Belum Ada</td>  
                                </tr>  
                            `);
                        }
                    },
                    complete: function () {
                        $('#loader').hide();
                        $('.placement').show();
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });

                // Potensi Tunggakan
                $.ajax({
                    url: '/tunggakan',
                    type: 'get',
                    data: { kd: value },
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function (res) {
                        
                        $('#hasil_tunggakan').empty();
                        $('#hasil_hitung_tunggakan').empty();

                        if (res.length > 0) {
                            for (let i = 0; i < res.length; i++) {
                                total_jum_tunggakan = total_jum_tunggakan + parseInt(res[i]['jum_tunggakan']);
                                total_besar_tunggakan = total_besar_tunggakan + parseInt(res[i]['total_tunggakan']);
                                total_rata_tunggakan = total_rata_tunggakan + parseInt(res[i]['tunggakan_rata']);

                                data_besaran_tunggakan[i] = res[i]['total_tunggakan'];

                                $('#hasil_tunggakan').append(`
                                    <tr>
                                        <td class="text-center">` + (i+1) + `</td>
                                        <td>` + res[i]['nama_cabang'] + `</td>
                                        <td class="text-center">` + res[i]['jum_tunggakan'] + `</td>
                                        <td class="text-center">` + accounting.formatMoney(res[i]['total_tunggakan'], "Rp. ", 2, ".", ",") + `</td>
                                        <td class="text-center">` + accounting.formatMoney(res[i]['tunggakan_rata'], "Rp. ", 2, ".", ",") + `</td>
                                    </tr>
                                `);
                            }

                            let opsi_pelunasan_1 = [];
                            let opsi_pelunasan_2 = [];

                            let total_opsi_pelunasan_1 = 0;
                            let total_opsi_pelunasan_2 = 0;

                            for (let i = 0; i < res.length; i++) {
                                opsi_pelunasan_1[i] = 0.7 * data_besaran_tunggakan[i];
                                opsi_pelunasan_2[i] = 0.8 * data_besaran_tunggakan[i];

                                total_opsi_pelunasan_1 = total_opsi_pelunasan_1 + opsi_pelunasan_1[i];
                                total_opsi_pelunasan_2 = total_opsi_pelunasan_2 + opsi_pelunasan_2[i];

                                $('#hasil_hitung_tunggakan').append(`
                                    <tr>
                                        <td class="text-center">` + accounting.formatMoney(Math.round(opsi_pelunasan_1[i]), "Rp. ", 2, ".", ",") + `</td>
                                        <td class="text-center">` + accounting.formatMoney(Math.round(opsi_pelunasan_2[i]), "Rp. ", 2, ".", ",") + `</td>
                                    </tr>
                                `);
                            }
                            let hasil_opsi_pelunasan_1, hasil_opsi_pelunasan_2;
                            hasil_opsi_pelunasan_1 = total_opsi_pelunasan_1;
                            hasil_opsi_pelunasan_2 = total_opsi_pelunasan_2;
                            

                            $('#hasil_tunggakan').append(`
                                <tr>
                                    <td class="text-center text-bold" colspan="2">Total</td>
                                    <td class="text-center text-bold">` + total_jum_tunggakan + `</td>
                                    <td class="text-center text-bold">` + accounting.formatMoney(total_besar_tunggakan, "Rp. ", 2, ".", ",") + `</td>
                                    <td class="text-center text-bold">` + accounting.formatMoney(total_rata_tunggakan, "Rp. ", 2, ".", ",") +  `</td>
                                </tr>
                            `);

                            $('#hasil_hitung_tunggakan').append(`
                                <tr>
                                    <td class="text-center text-bold">` + accounting.formatMoney(Math.round(total_opsi_pelunasan_1), "Rp. ", 2, ".", ",") + `</td>
                                    <td class="text-center text-bold">` + accounting.formatMoney(Math.round(total_opsi_pelunasan_2), "Rp. ", 2, ".", ",") + `</td>
                                </tr>
                            `);

                        } else {
                            $('#hasil_tunggakan').append(`
                                <tr>
                                    <td class="text-center" colspan="5">Data Belum Ada</td>  
                                </tr>  
                            `);
                            $('#hasil_hitung_tunggakan').append(`
                                <tr>
                                    <td class="text-center" colspan="2">Data Belum Ada</td>  
                                </tr>  
                            `);
                        }
                    },
                    complete: function () {
                        $('#loader').hide();
                        $('.placement').show();
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
          
                

            }
        });

        function get_total_tambahan_penjualan(param) {
            console.log(param)
            return param;
        }
        let tambahan = get_total_tambahan_penjualan();
        console.log(tambahan);

        $('.btn-search').on('click', function (e) {
            $('#placement').hide();

            var value = $('#kd_pdam').val();
            var total_pelanggan_aktif = 0;
            var total_pemakaian_nol = 0;
            var total_pelanggan_efektif = 0;
            var total_pemakaian_air = 0;
            var total_pemakaian_air_rata = 0;
            var total_harga_air = 0;
            var avg_pemakaian_air = 0;
            var avg_harga_air = 0;
            var pemakaian_dari_pelanggan_nol = [];
            var tmp_pemakaian_nol = [];

            if (value == null) {
                alert('Pilih PDAM');
                e.preventDefault();
            } else {
                $.ajax({
                    url: '/search',
                    type: 'get',
                    data: { kd: value },
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function (res) {
                        let ujung = res.length;
                        
                        $('#hasil').empty();
                        $('#hasil_perhitungan').empty();
                        if (res.length > 0) {
                            for (var i = 0; i < res.length; i++) {
                                total_pelanggan_aktif = total_pelanggan_aktif + parseInt(res[i]['pelanggan_aktif']);
                                total_pemakaian_nol = total_pemakaian_nol + parseInt(res[i]['pemakaian_0']);
                                total_pelanggan_efektif = total_pelanggan_efektif + parseInt(res[i]['efektif']);
                                total_pemakaian_air = total_pemakaian_air + parseInt(res[i]['pemakaian']);
                                total_pemakaian_air_rata = total_pemakaian_air_rata + parseFloat(res[i]['pemakaian_rata']);
                                total_harga_air = total_harga_air + parseInt(res[i]['rata']);

                                tmp_pemakaian_nol[i] = parseInt(res[i]['pemakaian_0']);
                                
                                $('#hasil').append(`
                                    <tr>
                                        <td class="text-center">` + (i+1) + `</td>
                                        <td>` + res[i]['nama_cabang'] + `</td>
                                        <td class="text-center">` + res[i]['pelanggan_aktif'] + `</td>
                                        <td class="text-center">` + res[i]['pemakaian_0'] + `</td>
                                        <td class="text-center">` + res[i]['efektif'] + `</td>
                                        <td class="text-center">` + res[i]['pemakaian'] + `</td>
                                        <td class="text-center">` + res[i]['pemakaian_rata'] + `</td>
                                        <td class="text-center">` + accounting.formatMoney(res[i]['rata'], "Rp. ", 2, ".", ",") + `</td>
                                    </tr>
                                `);
                            }

                            avg_pemakaian_air = (total_pemakaian_air_rata / res.length);
                            avg_harga_air = (total_harga_air / res.length);
                            var total_pemakaian_dari_pelanggan_nol = 0;
                            var tambahan_penjualan = [];
                            var total_tambahan_penjualan = 0;

                            for (var i=0; i < ujung; i++) {
                                pemakaian_dari_pelanggan_nol[i] = tmp_pemakaian_nol[i] * avg_pemakaian_air;
                                total_pemakaian_dari_pelanggan_nol = total_pemakaian_dari_pelanggan_nol + pemakaian_dari_pelanggan_nol[i];

                                tambahan_penjualan[i] = pemakaian_dari_pelanggan_nol[i] * avg_harga_air
                                total_tambahan_penjualan = total_tambahan_penjualan + tambahan_penjualan[i]
                                $('#hasil_perhitungan').append(`
                                    <tr>
                                        <td class="text-center">` + pemakaian_dari_pelanggan_nol[i].toFixed(2) + `</td>
                                        <td class="text-center">` + accounting.formatMoney(tambahan_penjualan[i], "Rp. ", 2, ".", ",") + `</td>
                                    </tr>
                                `);
                            }                           
                            
                            $('#hasil').append(`
                                <tr>
                                    <td class="text-center text-bold" colspan="2">Total</td>
                                    <td class="text-center text-bold">` + total_pelanggan_aktif + `</td>
                                    <td class="text-center text-bold">` + total_pemakaian_nol + `</td>
                                    <td class="text-center text-bold">` + total_pelanggan_efektif + `</td>
                                    <td class="text-center text-bold">` + total_pemakaian_air + `</td>
                                    <td class="text-center text-bold">` + avg_pemakaian_air.toFixed(2) + `</td>
                                    <td class="text-center text-bold">` + accounting.formatMoney(avg_harga_air.toFixed(2), "Rp. ", 2, ".", ",") + `</td>
                                </tr>
                            `);
                            $('#hasil_perhitungan').append(`
                                <tr>
                                    <td class="text-center text-bold">` + total_pemakaian_dari_pelanggan_nol.toFixed(2) + `</td>
                                    <td class="text-center text-bold">` + accounting.formatMoney(total_tambahan_penjualan, "Rp. ", 2, ".", ",") + `</td>
                                </tr>
                            `);
                        } else {
                            $('#hasil').append(`
                                <tr>
                                    <td class="text-center" colspan="8">Data Belum Ada</td>  
                                </tr>  
                            `);
                            $('#hasil_perhitungan').append(`
                                <tr>
                                    <td class="text-center" colspan="2">Data Belum Ada</td>  
                                </tr> 
                            `);
                        }
                    },
                    complete: function () {
                        $('#loader').hide();
                        $('#placement').show();
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }

        });

        $('.btn-penagihan').on('click', function (e) {
            let value = $('#kd_pdam').val();
            
            $('#placement').hide();
            let total_tagihan = 0;
            let total_bayar = 0;
            let total_presentase = 0;

            let data_opsi_pembayaran = [];
            let data_bayar = [];

            if (value == null) {
                alert('Pilih PDAM');
                e.preventDefault();
            } else {
                $.ajax({
                    url: '/penagihan',
                    type: 'get',
                    data: { kd: value},
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function (res) {
                        let x = res.length;
                        $('#hasil').empty();
                        $('#hasil_perhitungan').empty();
                        if (res.length > 0) {
                            for (let i = 0; i < res.length; i++) {
                                total_tagihan = total_tagihan + parseInt(res[i]['tagihan']);
                                total_bayar = total_bayar + parseInt(res[i]['bayar']);
                                total_presentase = total_presentase + parseInt(res[i]['rata']);

                                data_opsi_pembayaran[i] = res[i]['tagihan'];
                                data_bayar[i] = res[i]['bayar'];

                                $('#hasil').append(`
                                    <tr>
                                        <td class="text-center">` + (i+1) + `</td>
                                        <td>` + res[i]['nama_cabang'] + `</td>
                                        <td class="text-center">` + accounting.formatMoney(res[i]['tagihan'], "Rp. ", 2, ".", ",") + `</td>
                                        <td class="text-center">` + accounting.formatMoney(res[i]['bayar'], "Rp. ", 2, ".", ",") + `</td>
                                        <td class="text-center">` + res[i]['rata'] + ' %' + `</td>
                                    </tr>
                                `);
                            }

                            let opsi_pembayaran_1 = [];
                            let opsi_pembayaran_2 = [];
                            let total_opsi_pembayaran_1 = 0;
                            let total_opsi_pembayaran_2 = 0;

                            let opsi_tambahan_1 = [];
                            let opsi_tambahan_2 = [];
                            let total_opsi_tambahan_1 = 0;
                            let total_opsi_tambahan_2 = 0;
                            
                            for (let i = 0; i < res.length; i++) {
                                opsi_pembayaran_1[i] = data_opsi_pembayaran[i] * 0.7;
                                total_opsi_pembayaran_1 = total_opsi_pembayaran_1 + opsi_pembayaran_1[i];

                                opsi_pembayaran_2[i] = data_opsi_pembayaran[i] * 0.8;
                                total_opsi_pembayaran_2 = total_opsi_pembayaran_2 + opsi_pembayaran_2[i];

                                opsi_tambahan_1[i] = opsi_pembayaran_1[i] - data_bayar[i];
                                total_opsi_tambahan_1 = total_opsi_tambahan_1 + opsi_tambahan_1[i];

                                opsi_tambahan_2[i] = opsi_pembayaran_2[i] - data_bayar[i];
                                total_opsi_tambahan_2 = total_opsi_tambahan_2 + opsi_tambahan_2[i];

                                $('#hasil_perhitungan').append(`
                                    <tr>
                                        <td class="text-center">` + accounting.formatMoney(Math.round(opsi_pembayaran_1[i]), "Rp. ", 2, ".", ",") + `</td>
                                        <td class="text-center">` + accounting.formatMoney(Math.round(opsi_pembayaran_2[i]), "Rp. ", 2, ".", ",") + `</td>
                                        <td class="text-center">` + accounting.formatMoney(Math.round(opsi_tambahan_1[i]), "Rp. ", 2, ".", ",") + `</td>
                                        <td class="text-center">` + accounting.formatMoney(Math.round(opsi_tambahan_2[i]), "Rp. ", 2, ".", ",") + `</td>
                                    </tr>
                                `);
                            }

                            let rata_presentase;
                            rata_presentase = total_bayar / total_tagihan * 100;

                            $('#hasil').append(`
                                <tr>
                                    <td class="text-center text-bold" colspan="2">Total</td>
                                    <td class="text-center text-bold">` + accounting.formatMoney(total_tagihan, "Rp. ", 2, ".", ",") + `</td>
                                    <td class="text-center text-bold">` + accounting.formatMoney(total_bayar, "Rp. ", 2, ".", ",") + `</td>
                                    <td class="text-center text-bold">` + Math.round(rata_presentase) + ' %' + `</td>
                                </tr>
                            `)
                            $('#hasil_perhitungan').append(`
                                <tr>
                                    <td class="text-center text-bold">` + accounting.formatMoney(total_opsi_pembayaran_1, "Rp. ", 2, ".", ",") + `</td>
                                    <td class="text-center text-bold">` + accounting.formatMoney(total_opsi_pembayaran_2, "Rp. ", 2, ".", ",") + `</td>
                                    <td class="text-center text-bold">` + accounting.formatMoney(total_opsi_tambahan_1, "Rp. ", 2, ".", ",") + `</td>
                                    <td class="text-center text-bold">` + accounting.formatMoney(total_opsi_tambahan_2, "Rp. ", 2, ".", ",") + `</td>
                                </tr>
                            `);
                        } else {
                            $('#hasil').append(`
                                <tr>
                                    <td class="text-center" colspan="5">Data Belum Ada</td>  
                                </tr>  
                            `);
                            $('#hasil_perhitungan').append(`
                                <tr>
                                    <td class="text-center" colspan="4">Data Belum Ada</td>  
                                </tr>  
                            `);
                        }
                    },
                    complete: function () {
                        $('#loader').hide();
                        $('#placement').show();
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }
        });

        $('.btn-tunggakan').on('click', function (e) {
            let value = $('#kd_pdam').val();
            
            $('#placement').hide();

            let total_jum_tunggakan = 0;
            let total_besar_tunggakan = 0;
            let total_rata_tunggakan = 0;

            let data_besaran_tunggakan = [];

            if (value == null) {
                alert('Pilih PDAM');
                e.preventDefault();
            } else {
                $.ajax({
                    url: '/tunggakan',
                    type: 'get',
                    data: { kd: value },
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function (res) {
                        
                        $('#hasil').empty();
                        $('#hasil_perhitungan').empty();

                        if (res.length > 0) {
                            for (let i = 0; i < res.length; i++) {
                                total_jum_tunggakan = total_jum_tunggakan + parseInt(res[i]['jum_tunggakan']);
                                total_besar_tunggakan = total_besar_tunggakan + parseInt(res[i]['total_tunggakan']);
                                total_rata_tunggakan = total_rata_tunggakan + parseInt(res[i]['tunggakan_rata']);

                                data_besaran_tunggakan[i] = res[i]['total_tunggakan'];

                                $('#hasil').append(`
                                    <tr>
                                        <td class="text-center">` + (i+1) + `</td>
                                        <td>` + res[i]['nama_cabang'] + `</td>
                                        <td class="text-center">` + res[i]['jum_tunggakan'] + `</td>
                                        <td class="text-center">` + accounting.formatMoney(res[i]['total_tunggakan'], "Rp. ", 2, ".", ",") + `</td>
                                        <td class="text-center">` + accounting.formatMoney(res[i]['tunggakan_rata'], "Rp. ", 2, ".", ",") + `</td>
                                    </tr>
                                `);
                            }

                            let opsi_pelunasan_1 = [];
                            let opsi_pelunasan_2 = [];

                            let total_opsi_pelunasan_1 = 0;
                            let total_opsi_pelunasan_2 = 0;

                            for (let i = 0; i < res.length; i++) {
                                opsi_pelunasan_1[i] = 0.7 * data_besaran_tunggakan[i];
                                opsi_pelunasan_2[i] = 0.8 * data_besaran_tunggakan[i];

                                total_opsi_pelunasan_1 = total_opsi_pelunasan_1 + opsi_pelunasan_1[i];
                                total_opsi_pelunasan_2 = total_opsi_pelunasan_2 + opsi_pelunasan_2[i];

                                $('#hasil_perhitungan').append(`
                                    <tr>
                                        <td class="text-center">` + accounting.formatMoney(Math.round(opsi_pelunasan_1[i]), "Rp. ", 2, ".", ",") + `</td>
                                        <td class="text-center">` + accounting.formatMoney(Math.round(opsi_pelunasan_2[i]), "Rp. ", 2, ".", ",") + `</td>
                                    </tr>
                                `);
                            }

                            $('#hasil').append(`
                                <tr>
                                    <td class="text-center text-bold" colspan="2">Total</td>
                                    <td class="text-center text-bold">` + total_jum_tunggakan + `</td>
                                    <td class="text-center text-bold">` + accounting.formatMoney(total_besar_tunggakan, "Rp. ", 2, ".", ",") + `</td>
                                    <td class="text-center text-bold">` + accounting.formatMoney(total_rata_tunggakan, "Rp. ", 2, ".", ",") +  `</td>
                                </tr>
                            `);

                            $('#hasil_perhitungan').append(`
                                <tr>
                                    <td class="text-center text-bold">` + accounting.formatMoney(Math.round(total_opsi_pelunasan_1), "Rp. ", 2, ".", ",") + `</td>
                                    <td class="text-center text-bold">` + accounting.formatMoney(Math.round(total_opsi_pelunasan_2), "Rp. ", 2, ".", ",") + `</td>
                                </tr>
                            `);
                        } else {
                            $('#hasil').append(`
                                <tr>
                                    <td class="text-center" colspan="5">Data Belum Ada</td>  
                                </tr>  
                            `);
                            $('#hasil_perhitungan').append(`
                                <tr>
                                    <td class="text-center" colspan="2">Data Belum Ada</td>  
                                </tr>  
                            `);
                        }
                    },
                    complete: function () {
                        $('#loader').hide();
                        $('#placement').show();
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }
        });
        
        $('.btn-vendor').on('click', function () {
            var token = $('form[name="input-vendor"] input[name="_token"]').val();
            var harga_sekarang = $('#harga_sekarang').val();
            var lama_cicilan = $('#lama_cicilan').val();
            var persentase = $('#persentase').val();

            console.log(token);

            $.ajax({
                url: '/proses-vendor',
                type: 'post',
                data: { _token: token, harga_sekarang: harga_sekarang, lama_cicilan: lama_cicilan, persentase: persentase},
                success: function () {
                    console.log('berhasil');
                },
                error: function (err) {
                    console.log(err)
                }
            });
        });
    </script>
</body>

</html>