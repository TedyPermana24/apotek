@extends('layouts.app')

@section('title', 'Laravel 11 Stisla Starter')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pembelian</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pembelian Obat</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('pembelian.store') }}" method="POST">
                                @csrf
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="invoice">Invoice</label>
                                    <input type="text" class="form-control datepicker" id="invoice" name="invoice" value="{{ $invoice }}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="pemasok">Pemasok</label>
                                    <select class="form-control select" name="pemasok_id">
                                        <option value="" disabled>Pilih Pemasok</option>
                                        @foreach ($pemasok as $items)
                                            <option value="{{ $items->id }}">{{ $items->pemasok }}</option>
                                        @endforeach
                                    </select>
                                    @error('pemasok_id')
                                        <div class="text-danger ml-1">{{$message}}</div>
                                     @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" class="form-control datepicker" id="tanggal" name="tanggal" required>
                                    @error('tanggal')
                                        <div class="text-danger ml-1">{{$message}}</div>
                                     @enderror
                                </div>
                            </div>

                            <hr>

                           
                            <div id="data-obat-section">
                                <div class="form-row" id="data-obat-row-1">
                                    <div class="form-group col-md-3">
                                        <label for="nama_obat">Nama Obat</label>
                                        <select class="form-control select" name="nama_obat[]" onchange="updateKategori(this); updateStok(this);">
                                            <option value="" disabled selected>Pilih Obat</option>
                                            @foreach ($obat as $items)
                                                <option value="{{ $items->id }}" data-stok-id="{{ $items->stok}}" data-kategori-id="{{ $items->kategoris->kategori}}">{{ $items->nama_obat}}</option>
                                            @endforeach
                                        </select>
                                        @error('nama_obat')
                                            <div class="text-danger ml-1">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="stok">Stok</label>
                                        <input type="text" class="form-control stok-input" name="stok[]" readonly>
                                        @error('stok')
                                            <div class="text-danger ml-1">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="kategori">Kategori</label>
                                        <input type="text" class="form-control kategori-input" name="kategori[]" readonly>
                                        @error('kategori')
                                            <div class="text-danger ml-1">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="jumlah">Jumlah</label>
                                        <input type="number" class="form-control" name="jumlah[]" oninput="updateTotal(this)" required>
                                        @error('jumlah')
                                            <div class="text-danger ml-1">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="harga">Harga</label>
                                        <input type="number" class="form-control" name="harga[]" oninput="updateTotal(this)"  required>
                                        @error('harga')
                                            <div class="text-danger ml-1">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="total_harga">Total Harga</label>
                                        <input type="number" class="form-control" name="total_harga[]" readonly>
                                        @error('total_harga')
                                            <div class="text-danger ml-1">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary mt-3" onclick="tambahDataObat()">Tambah Data</button>

                            <div class="form-row">
                                <div class="form-group col-md-9"></div>
                                <div class="form-group col-md-2">
                                    <label><strong>Total Keseluruhan:</strong></label>
                                    <strong><span id="total-keseluruhan">0</span></strong>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button class="btn btn-primary mr-1" type="submit">Submit</button>
                            </div>
                        </form>
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
let obatRowCount = 1;

function updateKategori(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const kategoriId = selectedOption.getAttribute('data-kategori-id');
        
        // Update kategori input in the same row
        const kategoriInput = selectElement.closest('.form-row').querySelector('.kategori-input');
        kategoriInput.value = kategoriId;
    }

    function updateStok(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const stokId = selectedOption.getAttribute('data-stok-id');
        
        // Update kategori input in the same row
        const stokInput = selectElement.closest('.form-row').querySelector('.stok-input');
        stokInput.value = stokId;
    }

function tambahDataObat() {
    obatRowCount++;
    const dataObatSection = document.getElementById('data-obat-section');
    const newRow = document.createElement('div');
    newRow.className = 'form-row';
    newRow.id = 'data-obat-row-' + obatRowCount;
    newRow.innerHTML = `
        <div class="form-group col-md-3">
            <select class="form-control select" name="nama_obat[]" onchange="updateKategori(this)">
                <option value="" disabled selected>Pilih Obat</option>
                     @foreach ($obat as $items)
                            <option value="{{ $items->id }}" data-kategori-id="{{ $items->kategoris->kategori}}">{{ $items->nama_obat}}</option>
                    @endforeach
            </select>
            @error('nama_obat')
                <div class="text-danger ml-1">{{$message}}</div>
            @enderror
        </div>
         <div class="form-group col-md-1">
            <input type="text" class="form-control stok-input" name="stok[]" readonly>
            @error('stok')
                <div class="text-danger ml-1">{{$message}}</div>
            @enderror
        </div>
         <div class="form-group col-md-2">
            <input type="text" class="form-control kategori-input" name="kategori[]" readonly>
            @error('kategori')
                <div class="text-danger ml-1">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group col-md-1">
            <input type="number" class="form-control" name="jumlah[]" oninput="updateTotal(this)" required>
            @error('jumlah')
                <div class="text-danger ml-1">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group col-md-2">
            <input type="number" class="form-control" name="harga[]" oninput="updateTotal(this)" required>
            @error('harga')
                <div class="text-danger ml-1">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group col-md-2">
           
            <input type="number" class="form-control" name="total_harga[]" readonly>
            @error('total_harga')
                <div class="text-danger ml-1">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-danger" onclick="hapusDataObat(this)"><i class="fas fa-trash"></i></button>
        </div>
  
    `;
    dataObatSection.appendChild(newRow);
}

function setKategori(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const row = selectElement.closest('.form-row');
}

function updateTotal(element) {
    const row = element.closest('.form-row');
    const jumlah = row.querySelector('input[name="jumlah[]"]').value;
    const harga = row.querySelector('input[name="harga[]"]').value;
    const totalField = row.querySelector('input[name="total_harga[]"]');
    totalField.value = jumlah && harga ? jumlah * harga : 0;

    updateTotalKeseluruhan();
}

function updateTotalKeseluruhan() {
    const totalFields = document.querySelectorAll('input[name="total_harga[]"]');
    let totalKeseluruhan = 0;

    totalFields.forEach(field => {
        totalKeseluruhan += parseFloat(field.value) || 0;
    });

    // Memformat total menjadi format rupiah
    const formattedTotal = totalKeseluruhan.toLocaleString('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0, // Tidak menampilkan desimal
        maximumFractionDigits: 0  // Tidak menampilkan desimal
    });

    document.getElementById('total-keseluruhan').textContent = formattedTotal;
}

function hapusDataObat(button) {
    const row = button.closest('.form-row');
    row.remove();
    updateTotalKeseluruhan();
}
</script>

@if (Session::has('message'))
 <script>
    swal("{{ Session::get('type') }}", "{{ Session::get('message') }}", "{{ Session::get('icon') }}", {
      button: "OK",
    });
</script>
 @endif
@endpush