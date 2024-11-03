@extends('layouts.app')

@section('title', 'Obat')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Editor</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Edit Obat</h4>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('obat.update', $obat->id) }}" method="post">
                    @csrf
                    <input type="hidden" class="form-control" value="{{ $obat->id }}" name="id">
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Obat</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control" value="{{ $obat->nama_obat }}" name="nama_obat">
                        @error('nama_obat')
                          <div class="text-danger ml-1">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control selectric" name="kategori_id">
                        @foreach ($kategori as $item)
                            <option value="{{ $item->id }}" {{ old('kategori_id', $obat->kategori_id) == $item->id ? 'selected' : '' }}>{{ $item->kategori }}</option>
                        @endforeach
                        </select>
                        @error('kategori_id')
                          <div class="text-danger ml-1">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Unit</label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control selectric" name="unit_id">
                        @foreach ($unit as $jenis)
                            <option value="{{ $jenis->id }}" {{ old('unit_id', $obat->unit_id) == $jenis->id ? 'selected' : '' }}>{{ $jenis->unit }}</option>
                        @endforeach
                        </select>
                        @error('unit_id')
                          <div class="text-danger ml-1">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Stok</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="number" class="form-control" value="{{ $obat->stok }}" name="stok" @if(auth()->user()->role === 'kasir') readonly @endif>
                        @error('stok')
                          <div class="text-danger ml-1">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kadaluwarsa</label>
                      <div class="col-sm-12 col-md-7">
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <i class="fas fa-calendar"></i>
                              </div>
                            </div>
                            <input type="date" name="kadaluwarsa" class="form-control daterange-cus" value="{{$obat->kadaluwarsa}}">
                          </div>
                          @error('kadaluwarsa')
                            <div class="text-danger ml-1">{{$message}}</div>
                          @enderror
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Beli</label>
                      <div class="col-sm-12 col-md-7">
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                Rp.
                              </div>
                            </div>
                            <input type="number" name="harga_beli" class="form-control" value="{{$obat->harga_beli}}">
                          </div>
                          @error('harga_beli')
                            <div class="text-danger ml-1">{{$message}}</div>
                          @enderror
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Jual</label>
                      <div class="col-sm-12 col-md-7">
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                Rp. 
                              </div>
                            </div>
                            <input type="number" name="harga_jual" class="form-control" value="{{$obat->harga_jual}}">
                          </div>
                          @error('harga_jual')
                            <div class="text-danger ml-1">{{$message}}</div>
                          @enderror
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Indikasi</label>
                      <div class="col-sm-12 col-md-7">
                          <textarea type="text" name="indikasi" class="form-control">{{$obat->indikasi}}</textarea>
                          @error('indikasi')
                            <div class="text-danger ml-1">{{$message}}</div>
                          @enderror
                      </div>
                    </div>
                    {{-- <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pemasok</label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control selectric" name="pemasok_id">
                        @foreach ($pemasok as $distribusi)
                            <option value="{{ $distribusi->id }}" {{ old('pemasok_id', $obat->pemasok_id) == $distribusi->id ? 'selected' : '' }}>{{ $distribusi->nama_pemasok}}</option>
                        @endforeach
                        </select>
                        @error('pemasok_id')
                            <div class="text-danger ml-1">{{$message}}</div>
                        @enderror
                      </div>
                    </div> --}}
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                      <div class="col-sm-12 col-md-7">
                        <button type="submit" class="btn btn-primary">Publish</button>
                      </div>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        </section>
      </div>

@endsection

@push('scripts')
    <!-- JS Libraies -->
    @if (Session::has('message'))
    <script>
       swal("{{ Session::get('type') }}", "{{ Session::get('message') }}", "{{ Session::get('icon') }}", {
         button: "OK",
       });
   </script>
    @endif
    <!-- Page Specific JS File -->
@endpush
