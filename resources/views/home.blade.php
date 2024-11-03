@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>Jumlah Obat</h4>
                      </div>
                      <div class="card-body">
                        {{$jumlahObat}}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                    <i class="fas fa-money-bill"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>Jumlah Pembelian</h4>
                      </div>
                      <div class="card-body">
                       Rp. {{number_format($totalPembelian)}}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-money-bill"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>Jumlah Penjualan</h4>
                      </div>
                      <div class="card-body">
                        Rp. {{number_format($totalPenjualan)}}
                      </div>
                    </div>
                  </div>
                </div>    
            </div>  
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                  <div class="card">
                    <div class="card-header">
                      <h4>Data Obat yang Kadaluwarsa dalam 30 Hari</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                              <tr>
                                <th>No</th>
                                <th>Obat</th>
                                <th>Kategori</th>
                                <th>Unit</th>
                                <th>Stok</th>
                                <th>Kadaluwarsa</th>
                              </tr>
                              @foreach ($ObatKadaluwarsa as $index => $obat)
                              <tr>
                                
                                <td>{{$index + 1}}</td>
                                <td>{{$obat->nama_obat}}</td>
                                <td>{{$obat->kategoris->kategori}}</td>
                                <td>{{$obat->units->unit}}</td>
                                <td>{{$obat->stok}}</td>
                                <td>{{$obat->kadaluwarsa}}</td>
                           
                              </tr>
                              @endforeach
                            </table>
                          </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                    <div class="card">
                      <div class="card-header">
                        <h4>5 Obat Terlaris</h4>
                      </div>
                      <div class="card-body">             
                        <ul class="list-unstyled list-unstyled-border">
                          @foreach ($ObatTerlaris as $item)
                              <li>{{$item -> nama_obat}}</li>
                          @endforeach
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </section>
        
    </div>
  
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
