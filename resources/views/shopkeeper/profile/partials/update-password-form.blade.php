<!-- resources/views/partials/password-update.blade.php -->
<form method="post" action="{{ route('password.update') }}" class="mt-4">
    @csrf
    @method('put')

    <!-- Current Password Field -->
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="form-group">
                <label for="update_password_current_password" class="title">Current Password</label>
                <input type="password" id="update_password_current_password" name="current_password" class="form-control" placeholder="Enter your current password..." autocomplete="current-password">
                @error('current_password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- New Password Field -->
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="form-group">
                <label for="update_password_password" class="title">New Password</label>
                <input type="password" id="update_password_password" name="password" class="form-control" placeholder="Enter a new password..." autocomplete="new-password">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Confirm Password Field -->
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="form-group">
                <label for="update_password_password_confirmation" class="title">Confirm New Password</label>
                <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm your new password..." autocomplete="new-password">
                @error('password_confirmation')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="row">
        <div class="col-md-12 mb-3 text-right">
            <button class="btn btn-dark py-1 px-3">
                Change Password
            </button>

            @if (session('status') === 'password-updated')
                <p class="mt-2 text-sm text-green-600 dark:text-green-400">
                    {{ __('Password updated successfully.') }}
                </p>
            @endif
        </div>
    </div>
</form>
