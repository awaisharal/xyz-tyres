<section>
    <form method="post" action="{{ route('customer.profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="row">
            <!-- Name Field -->
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label for="name" class="title">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter your full name..." value="{{ old('name', $customer->name) }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Email Field -->
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label for="email" class="title">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email..." value="{{ old('email', $customer->email) }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    @if ($customer instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $customer->hasVerifiedEmail())
                        <div class="mt-2">
                            <p class="text-sm text-gray-800 dark:text-gray-200">
                                {{ __('Your email address is unverified.') }}
                                <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Save Button -->
            <div class="col-md-12 mb-3 text-right">
                <button class="btn btn-dark py-1 px-3">
                    {{ __('Save') }}
                </button>
            </div>

            <!-- Success Message -->
            @if (session('status') === 'profile-updated')
                <div class="col-md-12 text-success">
                    <p class="text-sm">{{ __('Saved.') }}</p>
                </div>
            @endif
        </div>
    </form>
</section>
