@extends('layouts.app')

@section('content')
    <div class="row d-flex justify-content-center my-5">
        <div class="col-lg-4 card-shadow card bg-white rounded py-4">
            <div class="card-header border-0">
                <div class="title-header">
                    <h3 class="font-weight-normal">{{ __('auth.log_in') }}</h3>
                </div>
            </div>
            <div class="pb-3 px-3">
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mt-3">
                        <x-form.label for="email" :value="__('auth.email')"/>

                        <x-form.input type="email" name="email" :value="old('email')" required autofocus />
                    </div>

                    <div class="mt-4">
                        <x-form.label for="password" :value="__('auth.password')" />

                        <x-form.input type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <div class="mt-3 form-check">
                            <x-form.input id="checkDefault" type="checkbox" class="form-check-input" :value="true" name="remember" />
                            <x-form.label class="form-check-label" for="checkDefault" :value="__('auth.remember_me')" />
                        </div>
                        <x-button class="px-5" color="primary">{{ __('auth.log_in') }}</x-button>
                    </div>

                    <div class="d-flex justify-content-end">
                        @if (Route::has('password.request'))
                            <a class="text-decoration-none p-0 mt-2 btn link-secondary" href="{{ route('password.request') }}">
                                {{ __('auth.forgot_password') }}?
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
