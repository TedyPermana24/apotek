
@extends('layouts.auth')

@section('title', 'Login')

@push('style')

@endpush

            @section('main')

              <div class="card card-primary">
                <div class="card-header"><h4>Login</h4></div>
  
                <div class="card-body">
                  <form method="POST" action="{{ route('login.proses') }}" class="needs-validation" novalidate="">
                    @csrf
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                      <div class="invalid-feedback">
                        Please fill in your email
                      </div>
                    </div>
  
                    <div class="form-group">
                      <div class="d-block">
                          <label for="password" class="control-label">Password</label>
                      </div>
                      <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                      <div class="invalid-feedback">
                        please fill in your password
                      </div>
                    </div>

  
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Login
                      </button>
                    </div>
                  </form>
  
                </div>
              </div>
           
            @endsection
      

  @push('scripts')

@if (Session::get('failed'))
<script>
    Swal.fire({
     title: "Gagal!!!",
     text: 'Username atau password salah',
     icon: "error"
     });
  </script>
 
@endif
  

  @endpush