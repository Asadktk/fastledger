{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

<x-layout>
    <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
        <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
            <div class="my-5 d-flex justify-content-center">
                <x-logo src="admin/assets/images/brand-logos/desktop-dark.png" alt="logo" href="/" />
            </div>

            <x-form-card title="Sign In" subtitle="Welcome back Asad !">
                <x-form method="POST" action="/login">

                    <div class="row gy-3">
                        <div class="col-xl-12">
                            <label for="email" class="form-label text-default">User Name</label>
                            <input type="email"
                                class="form-control 
                                @error('email') is-invalid @enderror
                                @if (session('success')) is-valid @endif"
                                id="email" name="email" placeholder="user name" value="{{ old('email') }}">

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-xl-12 mb-2">
                            <label for="password" class="form-label text-default d-block">Password<a
                                    href="reset-password-basic.html"
                                    class="float-end link-danger op-5 fw-medium fs-12">Forget password ?</a></label>
                            <div class="position-relative">
                                <input type="password"
                                    class="form-control  
                                    @error('password') is-invalid @enderror
                                    @if (session('success')) is-valid @endif"
                                    id="password" name="password" placeholder="password"
                                    value="{{ old('password') }}">

                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label text-muted fw-normal fs-12" for="defaultCheck1">
                                        Remember password ?
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center my-3 authentication-barrier">
                        <span class="op-4 fs-11">OR SignIn With</span>
                    </div>
                    {{-- <div class="d-flex align-items-center justify-content-between gap-3 mb-3 flex-wrap">
                        <button
                            class="btn btn-light btn-w-lg border d-flex align-items-center justify-content-center flex-fill">
                            <span class="avatar avatar-xs">
                                <img src="{{ asset('admin/assets/images/media/apps/google.png') }}" alt="">
                            </span>
                            <span class="lh-1 ms-2 fs-13 text-default fw-medium">Google</span>
                        </button>
                        <button
                            class="btn btn-light btn-w-lg border d-flex align-items-center justify-content-center flex-fill">
                            <span class="avatar avatar-xs">
                                <img src="{{ asset('admin/assets/images/media/apps/facebook.png') }}" alt="">
                            </span>
                            <span class="lh-1 ms-2 fs-13 text-default fw-medium">Facebook</span>
                        </button>
                    </div> --}}
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Sign In</button>
                    </div>
                    <div class="text-center">
                        <p class="text-muted mt-3 mb-0">Dont have an account? <a href="{{ route('register') }}"
                                class="text-primary">Sign Up</a></p>
                    </div>
                </x-form>

            </x-form-card>
        </div>
    </div>
</x-layout>
