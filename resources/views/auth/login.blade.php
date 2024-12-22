<x-layout>
    <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
        <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
            <!-- Logo Section -->
            <div class="my-5 d-flex justify-content-center">
                <x-logo src="admin/assets/images/brand-logos/desktop-dark.png" alt="logo" href="/" />
            </div>

            <!-- Form Card -->
            <x-form-card title="Sign In" subtitle="Welcome back Asad!">
                <x-form method="POST" action="/login">
                    <div class="row gy-3">
                        <!-- Email Input -->
                        <div class="col-12">
                            <label for="email" class="form-label text-default">User Name</label>
                            <input type="email" 
                                class="form-control @error('email') is-invalid @enderror @if(session('success')) is-valid @endif" 
                                id="email" name="email" placeholder="Enter Email" value="{{ old('email') }}" 
                                oninput="hideError('email')">
                            @error('email')
                                <div class="invalid-feedback" id="email-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="col-12 mb-2">
                            <label for="password" class="form-label text-default d-block">
                                Password
                                <a href="reset-password-basic.html" class="float-end link-danger op-5 fw-medium fs-12">Forgot password?</a>
                            </label>
                            <div class="position-relative">
                                <input type="password" 
                                    class="form-control @error('password') is-invalid @enderror @if(session('success')) is-valid @endif" 
                                    id="password" name="password" placeholder="Enter Password" value="{{ old('password') }}" 
                                    oninput="hideError('password')">

                                <!-- Password Eye Icon -->
                                <span id="toggle-password" 
                                    class="position-absolute icons-list-item top-50 end-0 translate-middle-y me-3 cursor-pointer">
                                    <i class="fe fe-eye"></i>                                </span>
                                @error('password')
                                    <div class="invalid-feedback" id="password-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="defaultCheck1">
                                    <label class="form-check-label text-muted fw-normal fs-12" for="defaultCheck1">
                                        Remember password?
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Sign In</button>
                    </div>

                    <!-- Footer Text -->
                    <div class="text-center">
                        <p class="text-muted mt-3 mb-0">
                            Don't have an account? <a href="{{ route('register') }}" class="text-primary">Sign Up</a>
                        </p>
                    </div>
                </x-form>
            </x-form-card>
        </div>
    </div>
</x-layout>

<script>
  
    function hideError(field) {
        const input = document.getElementById(field);
        const error = document.getElementById(`${field}-error`);
        if (error) error.style.display = 'none';
        if (input) input.classList.remove('is-invalid');
    }

    document.getElementById('toggle-password').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('.fe');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.replace('fe-eye', 'fe-eye-off');
        } else {
            passwordInput.type = 'password';
            icon.classList.replace('fe-eye-off', 'fe-eye');
        }
    });
</script>
