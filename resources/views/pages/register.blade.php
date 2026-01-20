@push('css')
    <style>

    </style>
@endpush
<div>
    <form class="login100-form" wire:submit.prevent="register" wire:target="register" method="get">
        <span class="login100-form-title">
            Member Registration
        </span>

        <div class="wrap-input100">
            <input class="input100" type="text"wire:model="name" placeholder="Name">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-user-o" aria-hidden="true"></i>
            </span>
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        {{-- <div class="wrap-input100">
            <input class="input100" type="text"wire:model="username" placeholder="Username">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-user" aria-hidden="true"></i>
            </span>
            @error('username')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div> --}}
        <div class="wrap-input100">
            <input class="input100" type="text"wire:model="mobile" placeholder="Phone">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-phone" aria-hidden="true"></i>
            </span>
            @error('mobile')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="wrap-input100">
            <input class="input100" type="text"wire:model="email" placeholder="Email">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-envelope" aria-hidden="true"></i>
            </span>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="wrap-input100" data-validate = "Password is required">
            <input class="input100" type="password" wire:model="password" placeholder="Password">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="wrap-input100" data-validate = "Password is required">
            <input class="input100" type="password" wire:model="password_confirmation" placeholder="Confirm Password">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
            @error('password_confirmation')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="wrap-input100">
            <input class="input100" type="text"wire:model="sponsor_username" placeholder="Ref ID">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-users" aria-hidden="true"></i>
            </span>
            @error('sponsor_username')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="container-login100-form-btn">
            <button class="login100-form-btn" wire:target="register" wire:target="register"
                wire:loading.attr="disabled">
                Register
            </button>
        </div>

        <div class="text-center p-t-12">
            <span class="txt1">
                Have a account?
            </span>
            <a class="txt2" href="{{ route('login') }}">
                <u>Login</u>
            </a>
        </div>

    </form>

</div>
