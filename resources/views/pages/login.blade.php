@push('css')
    <style>

    </style>
@endpush


<div>

    <form class="login100-form" wire:submit="login">
        <span class="login100-form-title">
            Member Login
        </span>

        <div class="wrap-input100">
            <input class="input100" type="text" wire:model="username" placeholder="User ID">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-envelope" aria-hidden="true"></i>
            </span>
            @error('username')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="wrap-input100">
            <input class="input100" type="password" wire:model="password" placeholder="Password">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="container-login100-form-btn">
            <button class="login100-form-btn" wire:target="login" wire:loading.attr="disabled">
                Login
            </button>
        </div>

        <div class="text-center p-t-12">
            <span class="txt1">
                Forgot
            </span>
            <a class="txt2" href="#">
                Username / Password?
            </a>
        </div>

        <div class="text-center p-t-136">
            <a class="txt2" href="{{ route('register') }}">
                Create your Account
                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
            </a>
        </div>
    </form>
</div>
