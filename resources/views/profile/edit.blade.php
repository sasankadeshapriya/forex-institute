{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

@extends('admin.layouts.main')

@section('content')
<div class="main-content">
  <section class="section">
    {{-- Page header --}}
    <div class="section-header">
      <h1>My Profile</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
        <div class="breadcrumb-item">Profile</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        {{-- Profile Info --}}
        <div class="col-lg-6">
                    <div class="card">
                      <div class="card-header">
                        <h4>Update Profile Information</h4>
                      </div>
                      <div class="card-body">
                        {{-- resend verification --}}
                        <form id="send-verification" method="POST" action="{{ route('verification.send') }}">@csrf</form>

                        <form method="POST" action="{{ route('profile.update') }}">
                          @csrf
                          @method('PATCH')

                          <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name"
                                   type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}"
                                   required
                                   autofocus>
                            @error('name')
                              <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                          </div>

                          <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email"
                                   type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}"
                                   required>
                            @error('email')
                              <span class="invalid-feedback">{{ $message }}</span>
                            @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                              <div class="mt-2">
                                <small class="text-warning">
                                  Your email is unverified.
                                  <button form="send-verification" class="btn btn-link p-0">
                                    Re-send verification
                                  </button>
                                </small>
                                @if (session('status') === 'verification-link-sent')
                                  <div class="text-success mt-1">
                                    A verification link has been sent.
                                  </div>
                                @endif
                              </div>
                            @endif
                          </div>

                          <div class="card-footer p-0 mt-3 text-end">
                            <button type="submit" class="btn btn-primary">Save</button>
                            @if (session('status') === 'profile-updated')
                              <span class="text-success ms-3">Saved.</span>
                            @endif
                          </div>
                        </form>
                      </div>
                    </div>
        </div>
        {{-- Change Password --}}
        <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h4>Update Password</h4>
              </div>
              <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                  @csrf
                  @method('PUT')

                  <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input id="current_password"
                           type="password"
                           name="current_password"
                           class="form-control @error('current_password') is-invalid @enderror"
                           autocomplete="current-password">
                    @error('current_password')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-row">
                        <div class="form-group col-lg-6">
                          <label for="password">New Password</label>
                          <input id="password"
                                 type="password"
                                 name="password"
                                 class="form-control @error('password') is-invalid @enderror"
                                 autocomplete="new-password">
                          @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                          @enderror
                        </div>
                        <div class="form-group col-lg-6">
                          <label for="password_confirmation">Confirm Password</label>
                          <input id="password_confirmation"
                                 type="password"
                                 name="password_confirmation"
                                 class="form-control @error('password_confirmation') is-invalid @enderror"
                                 autocomplete="new-password">
                          @error('password_confirmation')
                            <span class="invalid-feedback">{{ $message }}</span>
                          @enderror
                        </div>
                  </div>

                  <div class="card-footer p-0 mt-3 text-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                    @if (session('status') === 'password-updated')
                      <span class="text-success ms-3">Saved.</span>
                    @endif
                  </div>
                </form>
              </div>
            </div>
        </div>
      </div>

      <div class="row">
        {{-- Delete Account --}}
        <div class="col-12 col-lg-6">
            <div class="card">
              <div class="card-header">
                <h4>Delete Account</h4>
              </div>
              <div class="card-body">
                <p class="text-muted">
                  Once you delete your account, all resources and data will be permanently removed. Please download any data you wish to keep before proceeding.
                </p>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeletionModal">
                  Delete Account
                </button>
              </div>
            </div>
        </div>
      </div>

    </div>
  </section>
</div>

{{-- Deletion confirmation modal --}}
<div class="modal fade" id="confirmDeletionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('profile.destroy') }}" class="modal-content">
      @csrf
      @method('DELETE')
      <div class="modal-header">
        <h5 class="modal-title">Confirm Account Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Enter your password to confirm you want to permanently delete your account:</p>
        <div class="form-group">
          <input id="delete_password"
                 name="password"
                 type="password"
                 class="form-control @error('password') is-invalid @enderror"
                 placeholder="Password">
          @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger">Delete Account</button>
      </div>
    </form>
  </div>
</div>
@endsection
