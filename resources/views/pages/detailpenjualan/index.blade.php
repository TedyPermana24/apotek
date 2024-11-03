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
                  <h4>Obat</h4>
                  <div class="card-header-form">
                    <div class="input-group">
                      <a class="btn btn-primary" href="{{ route('penjualan.tampil')}}">Tambah Penjualan</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped data-table" id="table-1">
                      <thead>                                 
                        <tr>
                          <th>No</th>
                          <th>Invoice</th>
                          <th>Nama</th>
                          <th>Tanggal</th>
                          <th>Total Harga</th>
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

  @if(auth()->user()->role === 'admin')
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
  @endif

@endsection

@push('scripts')

  <script>
       $(document).ready(function() {
      let table = $(".data-table").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('detailpenjualan.tampil') }}",
        columnDefs: [
          { className: 'text-left', targets: [0, 1, 2, 3, 4, 5] },
          { "searchable": false, "orderable": false, "targets": 0 },
          { "searchable": false, "orderable": false, "targets": 5 }
        ],
        columns: [
          { data: null, name: null, render: function (data, type, row, meta) {
            return meta.row + 1;
          }},
          { data: 'invoice', name: 'invoice' },
          { data: 'nama', name: 'nama' },
          { data: 'tanggal', name: 'tanggal' },
          { 
            data: 'total_harga', 
            name: 'total_harga',
            render: function(data, type, row) {
              return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data);
            }
          },
          { data: null, name: null, render: function (data, type, row, meta) {
            return `
              <div class="d-flex justify-content-left">
                <a href="/detailpenjualan/showDetail/${row.id}" class="btn btn-primary btn-sm"><i class="fa-regular fa-eye"></i></a>
                @if(auth()->user()->role === 'admin')
                    <button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}"><i class="fas fa-trash"></i></button>
                @endif
              </div>
            `;
          }}
        ],
        drawCallback: function() {
          // Bind click event to delete buttons after table redraw
          $('.delete-btn').on('click', function() {
            const id = $(this).data('id');
            $('#deleteForm').attr('action', `/penjualan/delete/${id}`);
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

 
</script>


<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

  
@endpush
