<x-guest-layout>
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #fef2f2, #f8fafc); padding: 1.5rem;">
        <div style="background-color: #ffffff; border-radius: 1rem; box-shadow: 0 12px 35px rgba(0, 0, 0, 0.08); padding: 2rem; max-width: 430px; width: 100%;">

            <!-- Header -->
            <div style="text-align: center; margin-bottom: 1.8rem;">
                <div style="display: inline-flex; align-items: center; justify-content: center; background-color: #fee2e2; width: 60px; height: 60px; border-radius: 50%; margin-bottom: 1rem;">
                    <svg style="width: 28px; height: 28px; color: #dc2626;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h2 style="font-size: 1.7rem; font-weight: 700; color: #1f2937;">Welcome to SkHotstar</h2>
                <p style="color: #6b7280; font-size: 0.9rem;">Sign in to access your dashboard</p>
            </div>

            <!-- Validation Errors -->
            <x-validation-errors style="margin-bottom: 1rem; padding: 0.75rem; background-color: #fef2f2; color: #b91c1c; border-left: 4px solid #dc2626; border-radius: 0.5rem; font-size: 0.875rem;" />

            <!-- Session Message -->
            @if (session('status'))
                <div style="margin-bottom: 1rem; padding: 0.75rem; background-color: #ecfdf5; color: #059669; border-left: 4px solid #059669; border-radius: 0.5rem; font-size: 0.875rem;">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" style="margin-bottom: 1.5rem;">
                @csrf

                <!-- Email -->
                <div style="margin-bottom: 1rem;">
                    <label for="email" style="display: block; color: #374151; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.4rem;">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        placeholder="you@example.com"
                        style="width: 100%; padding: 0.625rem 0.75rem; font-size: 0.875rem; border: 1px solid #d1d5db; border-radius: 0.5rem; background-color: #f9fafb; transition: 0.2s;"
                        onfocus="this.style.borderColor='#dc2626'; this.style.boxShadow='0 0 0 3px rgba(220, 38, 38, 0.1)';"
                        onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';"
                    />
                </div>

                <!-- Password -->
                <div style="margin-bottom: 1rem;">
                    <label for="password" style="display: block; color: #374151; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.4rem;">Password</label>
                    <input id="password" name="password" type="password" required placeholder="••••••••"
                        style="width: 100%; padding: 0.625rem 0.75rem; font-size: 0.875rem; border: 1px solid #d1d5db; border-radius: 0.5rem; background-color: #f9fafb; transition: 0.2s;"
                        onfocus="this.style.borderColor='#dc2626'; this.style.boxShadow='0 0 0 3px rgba(220, 38, 38, 0.1)';"
                        onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';"
                    />
                </div>

                <!-- Role Selection -->
                <div style="margin-bottom: 1rem;">
                    <label for="role" style="display: block; color: #374151; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.4rem;">Login as</label>
                    <select id="role" name="role" required
                        style="width: 100%; padding: 0.625rem 0.75rem; font-size: 0.875rem; border: 1px solid #d1d5db; border-radius: 0.5rem; background-color: #f9fafb;">
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <!-- Remember & Forgot -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.875rem;">
                    <label style="display: flex; align-items: center;">
                        <input id="remember_me" name="remember" type="checkbox"
                            style="width: 1rem; height: 1rem; margin-right: 0.5rem; accent-color: #dc2626;" />
                        <span style="color: #4b5563;">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="color: #dc2626; text-decoration: none; font-weight: 500;"
                            onmouseover="this.style.color='#b91c1c';"
                            onmouseout="this.style.color='#dc2626';">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    style="width: 100%; padding: 0.75rem; background-color: #dc2626; color: white; font-weight: 600; border: none; border-radius: 0.5rem; cursor: pointer; transition: 0.2s;"
                    onmouseover="this.style.backgroundColor='#b91c1c'; this.style.transform='translateY(-1px)';"
                    onmouseout="this.style.backgroundColor='#dc2626'; this.style.transform='translateY(0)';">
                    Sign In
                </button>
            </form>

            <!-- Register Prompt -->
            <div style="text-align: center; font-size: 0.875rem; color: #6b7280;">
                Don’t have an account?
                <a href="{{ route('register') }}" style="color: #dc2626; font-weight: 600; text-decoration: none;"
                    onmouseover="this.style.color='#b91c1c';"
                    onmouseout="this.style.color='#dc2626';">
                    Sign up
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
