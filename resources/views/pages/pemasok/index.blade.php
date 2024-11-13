@extends('layouts.app')

@section('title', 'Pemasok')

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
                <h4>Pemasok</h4>
                <div class="card-header-form">
                  <div class="input-group">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#tambahPemasok">Tambah Data Pemasok</button>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped data-table" id="table-1">
                    <thead>                                 
                      <tr>
                        <th>No</th>
                        <th>Pemasok</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                        <th>Deskripsi</th>
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
<div class="modal fade" tabindex="-1" role="dialog" id="tambahPemasok">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Pemasok</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="card-body">
        <form action="{{ route('pemasok.add') }}" method="post">
            @csrf
          <div class="form-group">
            <label>Nama Pemasok</label>
            <input type="text" name="pemasok" class="form-control">
            @error('pemasok')
                <div class="text-danger ml-1">{{$message}}</div>
            @enderror
          </div>   
          <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control">
            @error('alamat')
                <div class="text-danger ml-1">{{$message}}</div>
            @enderror
          </div>  
          <div class="form-group">
            <label>Telepon</label>
            <input type="text" name="telepon" class="form-control">
            @error('telepon')
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
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteForm" method="POST">
        @csrf
        <div class="modal-body">
          <p>Apakah Anda yakin ingin menghapus data ini?</p>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>





@endsection

@push('scripts')

  <script>
    $(document).ready(function() {
      $(".data-table").DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('pemasok.tampil') }}",
          columnDefs: [
            { className: 'text-left', targets: [0, 1, 2, 3, 4, 5] },
            { "searchable": false, "orderable": false, "targets": 0 },
            { "searchable": false, "orderable": false, "targets": 5 }
          ],
          columns: [
              { data: null, name: null, render: function (data, type, row, meta) {
                return meta.row + 1;
              }},
              { data: 'pemasok', name: 'pemasok' },
              { data: 'alamat', name: 'alamat' },
              { data: 'telepon', name: 'telepon' },
              { data: 'deskripsi', name: 'deskripsi' },
              { data: null, name: null, render: function (data, type, row, meta) {
                return `
                  <div class="d-flex justify-content-left">
                    <a href="/pemasok/edit/${row.id}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                   <button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}"><i class="fas fa-trash"></i></button>
                  </div>
                `;
              }}
              
          ],
          drawCallback: function() {
          // Bind click event to delete buttons after table redraw
          $('.delete-btn').on('click', function() {
            const id = $(this).data('id');
            $('#deleteForm').attr('action', `/pemasok/delete/${id}`);
            $('#deleteModal').modal('show');
          });
        }

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

 


<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

  
@endpush
