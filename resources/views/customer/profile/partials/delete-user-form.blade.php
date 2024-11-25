<section class="space-y-6">
    <!-- Section Header -->
    <header>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <!-- Delete Account Button -->
    <div class="flex justify-center">
        <button 
            class="btn btn-danger w-full sm:w-auto"
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        >
            {{ __('Delete Account') }}
        </button>
    </div>

    <!-- Confirmation Modal -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('customer.profile.delete') }}" class="mt-6 space-y-6">
            @csrf
            @method('delete')

            <!-- Modal Title -->
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <!-- Modal Description -->
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <!-- Confirmation Checkbox -->
            <div class="mt-4">
                <label class="flex items-center">
                    <input type="checkbox" name="confirm_deletion" required class="mr-2" />
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('I confirm that I want to delete my account.') }}
                    </span>
                </label>
            </div>

            <!-- Password Input -->
            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Password') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control"
                    placeholder="{{ __('Enter your password') }}"
                    required
                />
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Modal Action Buttons -->
            <div class="flex justify-end gap-4 mt-6">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="btn btn-secondary"
                >
                    {{ __('Cancel') }}
                </button>

                <button
                    type="submit"
                    class="btn btn-danger"
                >
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>