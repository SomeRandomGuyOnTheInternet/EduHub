<x-layout>
    <x-hero-card>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if (session('status'))
        <div class="alert alert-success mb-4">
            {{ session('status') }}
        </div>
    @endif

    <div>
        <a href="/">
            <div class="center-logo mb-3">
                <img src="/images/logo-transparent-white.png" alt="Logo" width="350">
            </div>
        </a>
    </div>

    <div>
        <div class="container">
            <form method="POST" action="{{ route('password.store') }}" style="min-width: 400px;">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Reset Password') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
    </x-hero-card>
</x-layout>

<x-layout>
    <x-hero-card>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        @if (session('status'))
            <div class="alert alert-success mb-4">
                {{ session('status') }}
            </div>
        @endif

        <div>
            <a href="/">
                <div class="center-logo mb-3">
                    <img src="/images/logo-transparent-white.png" alt="Logo" width="350">
                </div>
            </a>
        </div>

        <div>
            <div class="hero-container">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
    
                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}"
                            required autofocus autocomplete="username">
                        @if ($errors->has('email'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
    
                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" class="form-control" type="password" name="password" required
                            autocomplete="current-password">
                        @if ($errors->has('password'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
    
                {{-- <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label for="remember_me" class="form-check-label">{{ __('Remember me') }}</label>
                </div> --}}
    
                    <div class="d-flex justify-content-end">
                        @if (Route::has('password.request'))
                            <a class="text-sm text-decoration-none me-3" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
    
                        <button type="submit" class="btn btn-primary">
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-hero-card>
</x-layout>
