@extends('layouts.app')

@section('title', 'Laravel 11 Stisla Starter')

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
                  <h4>Obat</h4>
                  <div class="card-header-form">
                    <div class="input-group">
                      <button class="btn btn-primary" data-toggle="modal" data-target="#tambahObat">Tambah Data Obat</button>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped data-table" id="table-1">
                      <thead>                                 
                        <tr>
                          <th>No</th>
                          <th>Obat</th>
                          <th>Kategori</th>
                          <th>Unit</th>
                          <th>Stok</th>
                          <th>Kadaluwarsa</th>
                          <th>Harga Jual</th>
                          {{-- <th>Pemasok</th> --}}
                          <th>Action</th>
                        </tr>
                      </thead>
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
  <div class="modal fade" tabindex="-1" role="dialog" id="tambahObat">
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
              @error('nama_obat')
                  <div class="text-danger ml-1">{{$message}}</div>
              @enderror
            </div>
            <div class="form-group">   
              <label>Kategori</label>
              <select class="form-control select" name="kategori_id">
                <option value="" disabled>Pilih Kategori</option>
                  @foreach ($kategori as $kategori)
                    <option value={{ $kategori->id }}>{{ $kategori->kategori }}</option>
                  @endforeach
              </select>
              @error('kategori_id')
                <div class="text-danger ml-1">{{$message}}</div>
              @enderror
            </div>
            <div class="form-group">
              <label>Unit</label>
              <select class="form-control select" name="unit_id">
                <option value="" disabled>Pilih Unit</option>
                  @foreach ($unit as $unit)
                    <option value={{ $unit->id }}>{{ $unit->unit }}</option>
                  @endforeach
              </select>
              @error('unit_id')
                <div class="text-danger ml-1">{{$message}}</div>
              @enderror
            </div>
            {{-- <div class="form-group">
              <label>Stok</label>
              <input type="number" name="stok" class="form-control">
              @error('stok')
                  <div class="text-danger ml-1">{{$message}}</div>
              @enderror
            </div> --}}
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
              @error('kadaluwarsa')
                  <div class="text-danger ml-1">{{$message}}</div>
              @enderror
            </div>
            <div class="form-group">
              <label>Indikasi</label>
              <textarea type="text" name="indikasi" class="form-control"></textarea>
              @error('indikasi')
                  <div class="text-danger ml-1">{{$message}}</div>
              @enderror
            </div>
            {{-- <div class="form-group">
              <label>Harga Beli</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    Rp.
                  </div>
                </div>
                <input type="number" class="form-control currency" name="harga_beli">
              </div>
              @error('harga_beli')
                <div class="text-danger ml-1">{{$message}}</div>
              @enderror
            </div> --}}
            {{-- <div class="form-group">
              <label>Harga Jual</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    Rp.
                  </div>
                </div>
                <input type="number" class="form-control currency" name="harga_jual">
              </div>
              @error('harga_jual')
                <div class="text-danger ml-1">{{$message}}</div>
              @enderror
            </div>   --}}
            {{-- <div class="form-group">
              <label>Pemasok</label>
              <select class="form-control select" name="pemasok_id">
                <option value="" disabled>Pilih Pemasok</option>
                  @foreach ($pemasok as $pemasok)
                    <option value={{ $pemasok->id }}>{{ $pemasok->pemasok }}</option>
                  @endforeach
              </select>
              @error('pemasok_id')
                <div class="text-danger ml-1">{{$message}}</div>
              @enderror
            </div> --}}
          </div>    
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
      </div>
    </div>
  </div>


  {{-- Delete Modal --}}
  @foreach ($obat as $o)
  <div class="modal fade" tabindex="-1" role="dialog" id="hapusObat{{ $o->id }}">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ isset($o) ? route('obat.delete', $o->id) : '' }}"  method="post">
        @csrf
        <div class="modal-body">
          <p>Modal body text goes here.</p>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Save changes</button>
        </div>
      </form>
      </div>
    </div>
  </div>
  @endforeach


@endsection

@push('scripts')

  <script>
    $(document).ready(function() {
      $(".data-table").DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('obat.tampil') }}",
          columnDefs: [
            { className: 'text-left', targets: [0, 1, 2, 3, 4, 5, 6, 7] },
            { "searchable": false, "orderable": false, "targets": 0 },
            { "searchable": false, "orderable": false, "targets": 7 }
          ],
          columns: [
              { data: null, name: null, render: function (data, type, row, meta) {
                return meta.row + 1;
              }},
              { data: 'nama_obat', name: 'nama_obat' },
              { data: 'kategori_id', name: 'kategori_id' },
              { data: 'unit_id', name: 'unit_id' },
              { data: 'stok', name: 'stok' },
              { data: 'kadaluwarsa', name: 'kadaluwarsa' },
              { 
                    data: 'harga_jual', 
                    name: 'harga_jual',
                    render: function(data, type, row) {
                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data);
                    }
                },
              // { data: 'pemasok_id', name: 'pemasok_id' },
              { data: null, name: null, render: function (data, type, row, meta) {
                return `
                  <div class="d-flex justify-content-left">
                     <a href="/obat/edit/${row.id}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                    <button class="btn btn-danger btn-sm delete-btn" data-toggle="modal" data-target="#hapusObat${row.id}" ><i class="fas fa-trash"></i></button>
                  </div>
                `;
              }}
              
          ],

        });
     });
    </script>
 @if (Session::has('message'))
 <script>
    swal("{{ Session::get('type') }}", "{{ Session::get('message') }}", "{{ Session::get('icon') }}", {
      button: "OK",
    });
</script>
 @endif

 
</script>


<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

  
@endpush
