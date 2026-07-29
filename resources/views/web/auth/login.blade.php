@extends('web.auth.base')

@section('auth.content')
<div class="col-lg-6">
    <div class="usercontent login-card">

        <div class="text-center mb-4">
            <h2>{{ __('login') }}</h2>
            {{-- <pclass="text-muted">__('login_description') --}}</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('web.auth.attempt') }}" method="POST">
            @csrf

            {{-- Email --}}
            <div class="form-group mb-3">
                <label>{{ __('email') }}</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-envelope"></i>
                        </span>
                    </div>

                    <input
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="{{ __('email') }}"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        autofocus
                        required>

                </div>

                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group mb-2">
                <label>{{ __('password') }}</label>

                <div class="input-group">

                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="{{ __('password') }}"
                        autocomplete="current-password"
                        required>

                    <div class="input-group-append">
                        <button
                            class="btn btn-light border"
                            type="button"
                            onclick="togglePassword()">

                            <i class="fa fa-eye" id="eyeIcon"></i>

                        </button>
                    </div>

                </div>

                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Remember --}}
            <div class="d-flex justify-content-between align-items-center mb-4">

           <div class="remember-check">
    <input
        type="checkbox"
        name="remember"
        id="remember"
        {{ old('remember') ? 'checked' : '' }}>

    <label for="remember">
        {{ __('remember_me') }}
    </label>
</div>

                <a href="{{ route('password.reset') }}">
                    {{ __('forgot_password') }}
                </a>

            </div>

            <button class="btn btn-success btn-block login-btn" id="loginBtn">
                {{ __('login') }}
            </button>

        </form>

       {{-- <div class="divider my-4">
            <span>{{ __('or') }}</span>
        </div>

        <div class="text-center">

         
            <a href="#" class="social-btn facebook">
                <img src="/assets/img/Icons/facebook.png" width="28">
            </a>

            <a href="#" class="social-btn google">
                <img src="/assets/img/Icons/google.png" width="28">
            </a>

        </div> --}} 

    </div>
</div>

<script>

function togglePassword(){

    let input=document.getElementById('password');
    let icon=document.getElementById('eyeIcon');

    if(input.type==="password"){
        input.type="text";
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }else{
        input.type="password";
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }

}

document.querySelector("form").addEventListener("submit",function(){

    let btn=document.getElementById("loginBtn");

    btn.disabled=true;

    btn.innerHTML='<i class="fa fa-spinner fa-spin"></i> {{ __("loading") }}';

});

</script>

@stop