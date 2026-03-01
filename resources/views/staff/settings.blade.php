@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="px-4 sm:px-8 lg:px-16 xl:px-24 py-8 max-w-6xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-10">
        <div class="flex items-center gap-2 mb-2">
            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                <path d="M4.67 1.33h6.66a1 1 0 011 1v11.34a1 1 0 01-1 1H4.67a1 1 0 01-1-1V2.33a1 1 0 011-1z"/>
            </svg>
            <span class="text-[10px] font-bold uppercase tracking-widest text-purple-600">Staff Control Panel</span>
        </div>
        <h1 class="font-mono text-3xl font-bold text-zinc-900 leading-tight">Settings</h1>
        <p class="mt-2 text-sm text-gray-500 max-w-xl leading-relaxed">
            Manage your account profile and core store information. These settings are restricted to administrative accounts.
        </p>
    </div>

    {{-- Cards Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        {{-- Profile Info Card --}}
        <div class="bg-white rounded-[2rem] border border-zinc-100 shadow-sm p-8 flex flex-col gap-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 opacity-60">
                    <svg class="w-4 h-4 text-zinc-900" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                        <circle cx="8" cy="5.5" r="2.5"/>
                        <path d="M2.67 14a5.33 5.33 0 0110.66 0"/>
                    </svg>
                    <span class="text-sm font-bold uppercase tracking-wider text-zinc-900">Profile Info</span>
                </div>
                <span class="px-2.5 py-1 bg-purple-600/5 border border-purple-600/10 rounded-xl text-[9px] font-bold uppercase tracking-wide text-purple-600">
                    Owner
                </span>
            </div>

            <div class="flex flex-col gap-5">
                {{-- Full Name --}}
                <div class="flex flex-col gap-1.5">
                    <label for="full_name" class="text-[10px] font-bold uppercase tracking-wide text-gray-500">
                        Full Name
                    </label>
                    <input
                        type="text"
                        id="full_name"
                        name="full_name"
                        value="John Lennon"
                        class="w-full h-12 px-5 bg-gray-50/50 border border-zinc-100 rounded-2xl text-sm text-zinc-900 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-purple-600/20 focus:border-purple-600/40 transition"
                    />
                </div>

                {{-- Email Address --}}
                <div class="flex flex-col gap-1.5">
                    <label for="email" class="text-[10px] font-bold uppercase tracking-wide text-gray-500">
                        Email Address
                    </label>
                    <input
                        type="mail"
                        id="mail"
                        name="mail"
                        value="john@company.com"
                        class="w-full h-12 px-5 bg-gray-50/50 border border-zinc-100 rounded-2xl text-sm text-zinc-900 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-purple-600/20 focus:border-purple-600/40 transition"
                    />
                </div>
            </div>
        </div>

        {{-- Security Card --}}
        <div class="bg-white rounded-[2rem] border border-zinc-100 shadow-sm p-8 flex flex-col gap-6">
            <div class="flex items-center gap-2 opacity-60">
                <svg class="w-4 h-4 text-zinc-900" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                    <rect x="2.67" y="7.33" width="10.66" height="7.34" rx="1"/>
                    <path d="M5.33 7.33V4.67a2.67 2.67 0 015.34 0v2.66"/>
                    <circle cx="8" cy="10.67" r="1"/>
                </svg>
                <span class="text-sm font-bold uppercase tracking-wider text-zinc-900">Security</span>
            </div>

            <div class="flex flex-col gap-4">
                {{-- Current Password --}}
                <div class="flex flex-col gap-1.5">
                    <label for="current_password" class="text-[10px] font-bold uppercase tracking-wide text-gray-500">
                        Current Password
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 opacity-40">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                                <rect x="1.33" y="7.33" width="13.34" height="7.34" rx="1.33"/>
                                <path d="M4.67 7.33V5.33a3.33 3.33 0 016.66 0v2"/>
                            </svg>
                        </span>
                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            placeholder="••••••••"
                            class="w-full h-12 pl-11 pr-11 bg-gray-50/50 border border-zinc-100 rounded-2xl text-sm text-zinc-900/50 placeholder-zinc-400/60 focus:outline-none focus:ring-2 focus:ring-purple-600/20 focus:border-purple-600/40 transition"
                        />
                        <button type="button" onclick="togglePassword('current_password', this)"
                            class="absolute right-4 top-1/2 -translate-y-1/2 opacity-40 hover:opacity-70 transition-opacity">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                                <path d="M1.33 8S3.67 2.67 8 2.67 14.67 8 14.67 8 12.33 13.33 8 13.33 1.33 8 1.33 8z"/>
                                <circle cx="8" cy="8" r="2"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- New Password --}}
                <div class="flex flex-col gap-1.5">
                    <label for="new_password" class="text-[10px] font-bold uppercase tracking-wide text-gray-500">
                        New Password
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 opacity-40">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                                <circle cx="8" cy="5.5" r="2.5"/>
                                <path d="M2.67 14a5.33 5.33 0 0110.66 0"/>
                            </svg>
                        </span>
                        <input
                            type="password"
                            id="new_password"
                            name="new_password"
                            placeholder="••••••••"
                            class="w-full h-12 pl-11 pr-11 bg-gray-50/50 border border-zinc-100 rounded-2xl text-sm text-zinc-900/50 placeholder-zinc-400/60 focus:outline-none focus:ring-2 focus:ring-purple-600/20 focus:border-purple-600/40 transition"
                        />
                        <button type="button" onclick="togglePassword('new_password', this)"
                            class="absolute right-4 top-1/2 -translate-y-1/2 opacity-40 hover:opacity-70 transition-opacity">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                                <path d="M1.33 8S3.67 2.67 8 2.67 14.67 8 14.67 8 12.33 13.33 8 13.33 1.33 8 1.33 8z"/>
                                <circle cx="8" cy="8" r="2"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Confirm New Password --}}
                <div class="flex flex-col gap-1.5">
                    <label for="confirm_password" class="text-[10px] font-bold uppercase tracking-wide text-gray-500">
                        Confirm New Password
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 opacity-40">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                                <path d="M8 1.33L14.67 5v6L8 14.67 1.33 11V5L8 1.33z"/>
                                <circle cx="8" cy="8" r="1.5"/>
                            </svg>
                        </span>
                        <input
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                            placeholder="••••••••"
                            class="w-full h-12 pl-11 pr-11 bg-gray-50/50 border border-zinc-100 rounded-2xl text-sm text-zinc-900/50 placeholder-zinc-400/60 focus:outline-none focus:ring-2 focus:ring-purple-600/20 focus:border-purple-600/40 transition"
                        />
                        <button type="button" onclick="togglePassword('confirm_password', this)"
                            class="absolute right-4 top-1/2 -translate-y-1/2 opacity-40 hover:opacity-70 transition-opacity">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                                <path d="M1.33 8S3.67 2.67 8 2.67 14.67 8 14.67 8 12.33 13.33 8 13.33 1.33 8 1.33 8z"/>
                                <circle cx="8" cy="8" r="2"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Change Password Button --}}
                <button type="button"
                    class="w-full h-12 flex items-center justify-center gap-2 bg-purple-600 hover:bg-purple-700 active:scale-[0.98] text-white rounded-2xl shadow-[0_4px_6px_-4px_rgba(147,51,234,0.3),0_10px_15px_-3px_rgba(147,51,234,0.2)] transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                        <rect x="2.67" y="7.33" width="10.66" height="7.34" rx="1"/>
                        <path d="M5.33 7.33V4.67a2.67 2.67 0 015.34 0v2.66"/>
                        <circle cx="8" cy="10.67" r="1"/>
                    </svg>
                    <span class="text-[10px] font-black uppercase tracking-wide">Change Password</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Update Settings Footer --}}
    <div class="flex justify-end">
        <button type="button"
            class="h-12 px-8 flex items-center gap-2.5 bg-purple-600 hover:bg-purple-700 active:scale-[0.98] text-white rounded-2xl shadow-[0_8px_10px_-6px_rgba(147,51,234,0.2),0_20px_25px_-5px_rgba(147,51,234,0.2)] transition-all duration-150">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                <path d="M2.67 2.67h8L13.33 6v7.33a1 1 0 01-1 1H3.67a1 1 0 01-1-1V3.67a1 1 0 011-1z"/>
                <path d="M5.33 13.33V8.67h5.34v4.66"/>
                <path d="M5.33 2.67v3h4"/>
            </svg>
            <span class="text-xs font-bold uppercase tracking-wider">Update Settings</span>
        </button>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';

        // Swap eye icon
        btn.querySelector('svg').innerHTML = isPassword
            ? `<path d="M2 2l12 12M6.71 6.71A3 3 0 0011.29 11.29M9.88 9.88A3 3 0 016.71 6.71" stroke="currentColor"/>
               <path d="M1.33 8S3.67 2.67 8 2.67c1.1 0 2.13.28 3.04.77M14.67 8S12.33 13.33 8 13.33c-1.1 0-2.13-.28-3.04-.77" stroke="currentColor"/>`
            : `<path d="M1.33 8S3.67 2.67 8 2.67 14.67 8 14.67 8 12.33 13.33 8 13.33 1.33 8 1.33 8z"/><circle cx="8" cy="8" r="2"/>`;
    }
</script>
@endpush