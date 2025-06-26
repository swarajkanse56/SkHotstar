<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Welcome to SkHotstar</h2>

            {{-- Validation errors --}}
            <x-validation-errors class="mb-4 p-2 bg-red-100 text-red-700 rounded" />

            {{-- Status message (like logout or password reset confirmation) --}}
            @if (session('status'))
                <div class="mb-4 p-2 bg-green-100 text-green-700 rounded text-sm text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="you@example.com"
                    />
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="••••••••"
                    />
                </div>

                {{-- Role Select --}}
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Login as</label>
                    <select
                        id="role"
                        name="role"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                    >
                         <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                {{-- Remember me & Forgot password --}}
                <div class="flex items-center justify-between text-sm">
                    <label class="inline-flex items-center">
                        <input
                            id="remember_me"
                            name="remember"
                            type="checkbox"
                            class="form-checkbox h-4 w-4 text-red-600"
                        />
                        <span class="ml-2 text-gray-700">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-red-600 hover:text-red-700">
                            Forgot password?
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full py-2 bg-red-600 hover:bg-red-700 text-white rounded-md font-semibold transition"
                >
                    Sign In
                </button>
            </form>

            {{-- Register link --}}
            <p class="mt-6 text-center text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-red-600 hover:text-red-700 font-medium">
                    Sign up
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
