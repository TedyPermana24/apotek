@extends('layouts.app')

@section('title', 'Edit Penjualan')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Penjualan</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Penjualan Obat</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="invoice">Invoice</label>
                                        <input type="text" class="form-control" id="invoice" name="invoice" value="{{ $pembelian->invoice }}" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="pemasok">Pemasok</label>
                                        <select class="form-control select" name="pemasok_id">
                                            <option value="" disabled>Pilih Pemasok</option>
                                            @foreach ($pemasok as $dist)
                                                <option value="{{ $dist->id }}" {{ old('pemasok_id', $pembelian->pemasok_id) == $dist->id ? 'selected' : '' }}>{{ $dist->pemasok }}</option>
                                            @endforeach
                                        </select>
                                        @error('pemasok_id')
                                            <div class="text-danger ml-1">{{$message}}</div>
                                         @enderror
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="tanggal">Tanggal</label>
                                        <input type="date" class="form-control datepicker" id="tanggal" value="{{ $pembelian->tanggal }}" name="tanggal" required>
                                        @error('tanggal')
                                            <div class="text-danger ml-1">{{$message}}</div>
                                         @enderror
                                    </div>
                                </div>

                                <hr>
                                <div id="data-obat-section">
                                    @foreach($pembelianObat as $index => $item)
                                    <div class="form-row" id="data-obat-row-{{ $index + 1 }}">
                                        <div class="form-group col-md-3">
                                            <label for="nama_obat">Nama Obat</label>
                                            <select class="form-control select" name="nama_obat[]" onchange="updateKategori(this); updateStok(this);">
                                                <option value="" disabled selected>Pilih Obat</option>
                                                @foreach ($obat as $obatItem)
                                                    <option value="{{ $obatItem->id }}" data-stok-id="{{ $obatItem->stok}}" 
                                                        data-kategori-id="{{ $obatItem->kategoris->kategori}}" 
                                                        {{ $obatItem->id == $item->obat_id ? 'selected' : '' }}>
                                                        {{ $obatItem->nama_obat }}</option>
                                                @endforeach
                                            </select>
                                            @error('nama_obat')
                                                <div class="text-danger ml-1">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-1">
                                            <label for="stok">Stok</label>
                                            <input type="text" class="form-control stok-input" name="stok[]" value="{{ $item->obats->stok }}" readonly>
                                            @error('stok')
                                                <div class="text-danger ml-1">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="kategori">Kategori</label>
                                            <input type="text" class="form-control kategori-input" name="kategori[]" value="{{ $item->obats->kategoris->kategori }}" readonly>
                                            @error('kategori')
                                                <div class="text-danger ml-1">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-1">
                                            <label for="jumlah">Jumlah</label>
                                            <input type="number" class="form-control" name="jumlah[]" value="{{ $item->jumlah }}" oninput="updateTotal(this)" required>
                                            @error('jumlah')
                                                <div class="text-danger ml-1">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="harga">Harga</label>
                                            <input type="number" class="form-control" name="harga[]" value="{{ $item->harga }}" oninput="updateTotal(this)"  required>
                                            @error('harga')
                                                <div class="text-danger ml-1">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="total_harga">Total Harga</label>
                                            <input type="number" class="form-control" name="total_harga[]" value="{{ $item->jumlah * $item->harga }}" readonly>
                                            @error('total_harga')
                                                <div class="text-danger ml-1">{{$message}}</div>
                                            @enderror
                                        </div>
                                        @if(!$loop->first)
                                        <div class="form-group col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger" onclick="hapusDataObat(this)"><i class="fas fa-trash"></i></button>
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
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
                                    <button class="btn btn-primary mr-1" type="submit">Update</button>
                                    <a href="{{ route('detailpembelian.tampil') }}" class="btn btn-secondary">Kembali</a>
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
let obatRowCount = {{ count($pembelianObat) }};

function updateKategori(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const kategoriId = selectedOption.getAttribute('data-kategori-id');
    const kategoriInput = selectElement.closest('.form-row').querySelector('.kategori-input');
    kategoriInput.value = kategoriId;
}


function updateStok(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const stokId = selectedOption.getAttribute('data-stok-id');
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
            <select class="form-control select" name="nama_obat[]" onchange="updateKategori(this); updateStok(this)">
                <option value="" disabled selected>Pilih Obat</option>
                @foreach ($obat as $items)
                    <option value="{{ $items->id }}" 
                            data-stok-id="{{$items->stok}}" 
                            data-harga-id="{{$items->harga_jual}}" 
                            data-kategori-id="{{ $items->kategoris->kategori}}">
                        {{ $items->nama_obat}}
                    </option>
                @endforeach
            </select>
            @error('nama_obat')
                <div class="text-danger ml-1">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group col-md-1">
            <input type="text" class="form-control stok-input" name="stok[]" oninput="updateTotal(this)"readonly>
            @error('stok')
                <div class="text-danger ml-1">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control kategori-input" name="kategori[]" oninput="updateTotal(this)" readonly>
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
        <div class="form-group col-md-1 d-flex align-items-end">
            <button type="button" class="btn btn-danger" onclick="hapusDataObat(this)"><i class="fas fa-trash"></i></button>
        </div>
    `;
    dataObatSection.appendChild(newRow);
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

    const formattedTotal = totalKeseluruhan.toLocaleString('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });

    document.getElementById('total-keseluruhan').textContent = formattedTotal;
}

function hapusDataObat(button) {
    const row = button.closest('.form-row');
    row.remove();
    updateTotalKeseluruhan();
}

// Initialize total on page load
document.addEventListener('DOMContentLoaded', function() {
    updateTotalKeseluruhan();
});
</script>

@if (Session::has('message'))
<script>
    swal("{{ Session::get('type') }}", "{{ Session::get('message') }}", "{{ Session::get('icon') }}", {
        button: "OK",
    });
</script>
@endif
@endpush