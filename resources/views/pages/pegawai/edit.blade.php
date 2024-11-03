@extends('layouts.app')

@section('title', 'Laravel 11 Stisla Starter')

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
                    <h4>Edit Pegawai</h4>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('pegawai.update', $pegawai->id) }}" method="post">
                    @csrf
                    <input type="hidden" class="form-control" value="{{ $pegawai->id }}" name="id">
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Pegawai</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control" value="{{ $pegawai->name }}" name="name">
                        @error('name')
                          <div class="text-danger ml-1">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="email" class="form-control" name="email" value="{{ $pegawai->email }}">
                        @error('email')
                          <div class="text-danger ml-1">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password</label>
                        <div class="col-sm-12 col-md-7">
                        <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                          @error('password')
                            <div class="text-danger ml-1">{{$message}}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Role</label>
                        <div class="col-sm-12 col-md-7">
                            <select class="form-control selectric" name="role">
                                <option value="kasir" {{ old('role') === 'kasir' ? 'selected' : '' }}>Kasir</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                                @error('role')
                                  <div class="text-danger ml-1">{{$message}}</div>
                                @enderror
                        </div>
                      </div>
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
