@extends('layouts.app')

@section('title', 'Detail Penjualan')

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
@endpush

@section('main')
  <div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data</h1>
        </div>
        <div class="section-body">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Detail Penjualan Obat</h4>
                  <div class="card-header-form">
                    <div class="input-group">
                      <a href="/penjualan/edit/{{ $penjualan->id }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="invoice" class="col-sm-1 col-form-label">Invoice</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control" id="invoice" value="{{ $penjualan->invoice }}" readonly>
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="invoice" class="col-sm-1 col-form-label">Nama</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control" id="invoice" value="{{ $penjualan->nama }}" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="tanggal" class="col-sm-1 col-form-label">Tanggal</label>
                        <div class="col-sm-3">
                          <input type="date" class="form-control" id="tanggal" value="{{ $penjualan->tanggal }}" readonly>
                        </div>
                      </div>
                      <hr>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>                                 
                        <tr>
                          <th>No</th>
                          <th>Obat</th>
                          <th>Kategori</th>
                          <th>Unit</th>
                          <th>Jumlah</th>
                          <th>Harga Satuan</th>
                          <th>Total Harga</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                         $subtotal = 0; 
                        @endphp
                        @foreach($detailObat as $index => $item)
                        @php
                            $totalHarga = $item->jumlah * $item->harga; 
                            $subtotal += $totalHarga; 
                        @endphp
                          <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->obats->nama_obat }}</td> 
                            <td>{{ $item->obats->kategoris->kategori }}</td> 
                            <td>{{ $item->obats->units->unit }}</td> 
                            <td>{{ $item->jumlah }}</td>
                            <td>Rp. {{ number_format($item->harga) }}</td>
                            <td>Rp. {{ number_format($item->jumlah * $item->harga) }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer text-right">
                    <strong>Subtotal: </strong> Rp. {{ number_format($subtotal) }} 
                  </div>
              </div>
            </div>
          </div>
        </div>
    </section>
  </div>

@endsection

@push('scripts')

@endpush
