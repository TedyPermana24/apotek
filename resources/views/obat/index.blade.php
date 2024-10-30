@extends('layouts.app')

@section('title', 'Laravel 11 Stisla Starter')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Laravel 11 Stisla Starter</h1>
      </div>
      <div class="section-body">
          <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Obat</h4>
                    <div class="card-header-form">
                      <div class="input-group">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Tambah Data Obat</button>
                      </div>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <tr>
                          <th>No</th>
                          <th>Nama obat</th>
                          <th>Kategori</th>
                          <th>Unit</th>
                          <th>Stok</th>
                          <th>Kadaluwarsa</th>
                          <th>Harga Jual</th>
                          <th>Aksi</th>
                        </tr>
                        @foreach ($data as $no=>$obat)
                        <tr>
                          <td>{{ $no+1 }}</td>
                          <td>{{ $obat->nama_obat }}</td>
                          <td>{{ $obat->kategoris->kategori }}</td>
                          <td>{{ $obat->units->nama_unit}}</td>
                          <td>{{ $obat->stok }}</td>
                          <td>{{ $obat->kadaluwarsa }}</td>
                          <td>{{ $obat->harga_jual }}</td>
                          <td>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#editObat{{ $obat->id }}"> <i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger"> <i class="fas fa-trash"></i></button>
                          </td>
                        </tr>
                        @endforeach
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
  </section>
</div>

{{-- Add Modal --}}
<div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('obat.add') }}" method="post">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label>Nama obat</label>
            <input type="text" name="nama_obat" class="form-control">
          </div>
          <div class="form-group">   
            <label>Kategori</label>
            <select class="form-control select" name="kategori_id">
                @foreach ($kategori as $kategori)
                  <option value={{ $kategori->id }}>{{ $kategori->kategori }}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Kategori</label>
            <select class="form-control select" name="unit_id">
                @foreach ($unit as $unit)
                  <option value={{ $unit->id }}>{{ $unit->nama_unit }}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control">
          </div>
          <div class="form-group">
            <label>Kadaluwarsa</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-calendar"></i>
                </div>
              </div>
              <input type="date" name="kadaluwarsa" class="form-control daterange-cus">
            </div>
          </div>
          <div class="form-group">
            <label>Harga Beli</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  Rp.
                </div>
              </div>
              <input type="number" class="form-control currency" name="harga_beli">
            </div>
          </div>
          <div class="form-group">
            <label>Harga Jual</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  Rp.
                </div>
              </div>
              <input type="number" class="form-control currency" name="harga_jual">
            </div>
          </div>  
          <div class="form-group">
            <label>Pemasok</label>
            <select class="form-control select" name="pemasok_id">
                @foreach ($pemasok as $pemasok)
                  <option value={{ $pemasok->id }}>{{ $pemasok->nama_pemasok }}</option>
                @endforeach
            </select>
          </div>
        </div>    
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>

{{-- Edit Modal --}}
{{-- <div class="modal fade" tabindex="-1" role="dialog" id="editObat1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label>Nama obat</label>
            <input type="text" name="nama_obat" class="form-control" value="{{ old('nama_obat', $obat->nama_obat) }}">
          </div>
          <div class="form-group">   
            <label>Kategori</label>
            <select class="form-control select" name="kategori_id">
                @foreach ($kategori as $kategori)
                  <option value=></option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Kategori</label>
            <select class="form-control select" name="unit_id">
                @foreach ($unit as $unit)
                  <option value={{ $unit->id }}>{{ $unit->nama_unit }}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control">
          </div>
          <div class="form-group">
            <label>Kadaluwarsa</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-calendar"></i>
                </div>
              </div>
              <input type="date" name="kadaluwarsa" class="form-control daterange-cus">
            </div>
          </div>
          <div class="form-group">
            <label>Harga Beli</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  Rp.
                </div>
              </div>
              <input type="number" class="form-control currency" name="harga_beli">
            </div>
          </div>
          <div class="form-group">
            <label>Harga Jual</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  Rp.
                </div>
              </div>
              <input type="number" class="form-control currency" name="harga_jual">
            </div>
          </div>  
          <div class="form-group">
            <label>Pemasok</label>
            <select class="form-control select" name="pemasok_id">
                @foreach ($pemasok as $pemasok)
                  <option value={{ $pemasok->id }}>{{ $pemasok->nama_pemasok }}</option>
                @endforeach
            </select>
          </div>
        </div>    
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div> --}}

@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
