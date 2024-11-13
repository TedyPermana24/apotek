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
                    <h4>Pembelian Logger</h4>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped data-table" id="table-1">
                        <thead>                                 
                            <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                            <th>Detail</th>
                            <th>Penjualan ID</th>
                            <th>Dilakukan pada</th>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
    $(".data-table").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('penjualan.logger') }}", 
        columnDefs: [
            { className: 'text-left', targets: [0, 1, 2, 3, 4] },
            { "searchable": false, "orderable": false, "targets": 0 }
        ],
        columns: [
            { data: null, name: null, render: function (data, type, row, meta) {
                return meta.row + 1; 
            }},
            { data: 'username', name: 'username' }, 
            { data: 'action', name: 'action' }, 
            { data: 'details', name: 'details'}, 
            { data: 'penjualan_id', name: 'penjualan_id' },
            { 
                    data: 'created_at', 
                    name: 'created_at', 
                    render: function(data, type, row) {
                        // Format the created_at date
                        if (data) {
                            const date = new Date(data);
                            return date.toLocaleString(); // Adjust format as needed
                        }
                        return '';
                    }
                }
        ],
    });
});
</script>

<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
@endpush