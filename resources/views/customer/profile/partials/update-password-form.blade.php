<section>
    <form method="post" action="{{ route('customer.profile.password.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="row">
            <!-- Current Password Field -->
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label for="current_password" class="title">Current Password</label>
                    <input type="password" name="current_password" class="form-control" placeholder="Enter your current password..." required>
                    @error('current_password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- New Password Field -->
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label for="password" class="title">New Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter a new password..." required>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Confirm New Password Field -->
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label for="password_confirmation" class="title">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm your new password..." required>
                    @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Save Button -->
            <div class="col-md-12 mb-3 text-right">
                <button class="btn btn-dark py-1 px-3">
                    {{ __('Change Password') }}
                </button>
            </div>

            <!-- Success Message -->
            @if (session('status') === 'password-updated')
                <div class="col-md-12 text-success">
                    <p class="text-sm">{{ __('Password successfully updated.') }}</p>
                </div>
            @endif
        </div>
    </form>
</section>
