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
                <h4>Kategori</h4>
                <div class="card-header-form">
                  <div class="input-group">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#tambahUnit">Tambah Data Unit</button>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped data-table" id="table-1">
                    <thead>                                 
                      <tr>
                        <th>No</th>
                        <th>Unit</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
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
<div class="modal fade" tabindex="-1" role="dialog" id="tambahUnit">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="card-body">
        <form action="{{ route('unit.add') }}" method="post">
            @csrf
          <div class="form-group">
            <label>Nama unit</label>
            <input type="text" name="unit" class="form-control">
            @error('unit')
                <div class="text-danger ml-1">{{$message}}</div>
            @enderror
          </div>   
          <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" name="deskripsi" class="form-control">
            @error('deskripsi')
                <div class="text-danger ml-1">{{$message}}</div>
            @enderror
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


{{-- Delete Modal --}}
@foreach ($unit as $k)
<div class="modal fade" tabindex="-1" role="dialog" id="hapusUnit{{ $k->id }}">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ isset($k) ? route('unit.delete', $k->id) : '' }}"  method="post">
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
          ajax: "{{ route('unit.tampil') }}",
          columnDefs: [
            { className: 'text-left', targets: [0, 1, 2] },
            { "searchable": false, "orderable": false, "targets": 0 },
            { "searchable": false, "orderable": false, "targets": 3 }
          ],
          columns: [
              { data: null, name: null, render: function (data, type, row, meta) {
                return meta.row + 1;
              }},
              { data: 'unit', name: 'unit' },
              { data: 'deskripsi', name: 'deskripsi' },
              { data: null, name: null, render: function (data, type, row, meta) {
                return `
                  <div class="d-flex justify-content-left">
                     <a href="/unit/edit/${row.id}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                    <button class="btn btn-danger btn-sm delete-btn" data-toggle="modal" data-target="#hapusUnit${row.id}" ><i class="fas fa-trash"></i></button>
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
