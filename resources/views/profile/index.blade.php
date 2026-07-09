@extends('layouts.app')

@section('title', 'Profile')

@section('content')

@php
    $currentUser = auth()->user();

    $avatarUrl = $currentUser->avatar
        ? (str_starts_with($currentUser->avatar, 'http')
            ? $currentUser->avatar
            : asset('storage/' . $currentUser->avatar))
        : asset('images/profile.jpg');

    $bannerUrl = $currentUser->banner
        ? (str_starts_with($currentUser->banner, 'http')
            ? $currentUser->banner
            : asset('storage/' . $currentUser->banner))
        : asset('images/Checker_BG.png');

    $taskHelped = [
        [
            'project' => 'AquaVerse',
            'task' => 'Design Quiz Interface',
            'date' => '18 Jun 2026',
            'point' => '+5',
            'color' => '#8B3F3F'
        ],
        [
            'project' => 'PetPal',
            'task' => 'Manage Schema Integration',
            'date' => '20 Jun 2026',
            'point' => '+3',
            'color' => '#B89A3D'
        ],
        [
            'project' => 'CookEase',
            'task' => 'Add Menu Seeder',
            'date' => '21 Jun 2026',
            'point' => '+4',
            'color' => '#2F6D92'
        ],
    ];

    $taskCreated = [
        [
            'project' => 'TravelMate',
            'task' => 'Integrate OAuth2',
            'date' => '22 Jun 2026',
            'point' => '-8',
            'color' => '#23824F'
        ]
    ];
@endphp

<div class="p-4 md:p-8 max-w-7xl mx-auto bg-linear-to-r from-surface to-background-gradient">
    <div class="bg-background rounded-4xl overflow-hidden shadow-sm border border-border mb-8">
        <!-- COVER -->
        <div class="relative h-36 overflow-visible">
            <img
                src="{{ $bannerUrl }}"
                alt="Cover"
                class="absolute inset-0 w-full h-full object-cover"
            >
            <!-- EDIT -->
            <button
                onclick="document.getElementById('editProfileModal').classList.remove('hidden')"
                class="absolute top-5 right-5 bg-primary hover:bg-primary-hover text-white px-5 py-2 rounded-full font-montserrat font-semibold flex items-center gap-2 shadow-md"
            >
                <x-lucide-pencil class="w-4 h-4" />
                Edit Profile
            </button>
        </div>
        <!-- PROFILE CONTENT -->
        <div class="relative px-10 pb-5">
            <!-- AVATAR -->
            <div class="absolute left-10 -top-14">
                <img
                    src="{{ $avatarUrl }}"
                    class="w-48 h-48 rounded-full object-cover border-[6px] border-background shadow-lg"
                >
            </div>
            <!-- POINTS -->
            <div class="absolute right-10 top-6 bg-background-gradient pb-2 rounded-xl">
                <div class="flex items-center gap-3 flex-col">
                    <div class="bg-primary text-white rounded-t-lg px-4 py-2">
                        <span class="font-parkinsans text-3xl font-bold">
                            123
                        </span>
                    </div>
                    <span class="font-montserrat text-lg font-semibold text-text-primary">
                        Points
                    </span>
                </div>
            </div>

            <!-- PROFILE INFO -->
            <div class="pt-6.5 ml-54">
                <h1 class="font-parkinsans text-3xl font-bold text-text-primary">
                    {{ auth()->user()->username }}
                </h1>
                <p class="font-montserrat text-lg text-text-secondary mt-px">
                    {{ auth()->user()->name }}
                </p>
                <div class="flex flex-wrap items-center gap-5 mt-2 text-text-secondary">
                    @php
                        $u = auth()->user();
                        $place = collect([$u->city, $u->country])->filter()->implode(', ');
                    @endphp
                    @if ($place)
                        <div class="flex items-center gap-2">
                            <x-lucide-map-pin class="w-4 h-4" />
                            {{ $place }}
                        </div>
                    @endif
                    <div class="flex items-center gap-2">
                        <x-lucide-calendar class="w-4 h-4" />
                        Joined {{ auth()->user()->created_at?->format('M Y') ?? 'Jan 2026' }}
                    </div>
                </div>
                <p class="mt-2 max-w-lg font-montserrat text-text-secondary whitespace-pre-line">{{ auth()->user()->about ?: 'No bio yet.' }}</p>
            </div>
        </div>

        <!-- STATS -->
        <div class="px-8 pb-4">
            <div class="grid grid-cols-2 md:grid-cols-4 bg-card border border-border rounded-3xl overflow-hidden">
                <div class="flex flex-col items-center py-3">
                    <div class="row flex gap-1.5 mb-1">
                        <div class="bg-primary p-2 rounded-xl flex items-center justify-center">
                            <x-lucide-folder-git class="w-4 h-4 text-text-contrast"/>
                        </div>
                        <span class="font-parkinsans text-3xl font-bold text-text-primary">4</span>
                    </div>
                    <span class="text-text-secondary">
                        Projects Joined
                    </span>
                </div>
                <div class="flex flex-col items-center py-3 border-l border-border">
                    <div class="row flex gap-1.5 mb-1">
                        <div class="bg-primary p-2 rounded-xl flex items-center justify-center">
                            <x-lucide-clipboard-list class="w-4 h-4 text-text-contrast"/>
                        </div>
                        <span class="font-parkinsans text-3xl font-bold text-text-primary">4</span>
                    </div>
                    <span class="text-text-secondary">
                        Tasks Completed
                    </span>
                </div>
                <div class="flex flex-col items-center py-3 border-l border-border">
                    <div class="row flex gap-1.5 mb-1">
                        <div class="bg-primary p-2 rounded-xl flex items-center justify-center">
                            <x-lucide-users class="w-4 h-4 text-text-contrast"/>
                        </div>
                        <span class="font-parkinsans text-3xl font-bold text-text-primary">4</span>
                    </div>
                    <span class="text-text-secondary">
                        Collaborations
                    </span>
                </div>
                <div class="flex flex-col items-center py-3 border-l border-border">
                    <div class="row flex gap-1.5 mb-1">
                        <div class="bg-primary p-2 rounded-xl flex items-center justify-center">
                            <x-lucide-star class="w-4 h-4 text-text-contrast"/>
                        </div>
                        <span class="font-parkinsans text-3xl font-bold text-text-primary">4</span>
                    </div>
                    <span class="text-text-secondary">
                        Total Points
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- ABOUT -->
        <div class="bg-background rounded-4xl p-7 shadow-sm border border-border flex flex-col justify-between">

            <div>

                <div class="flex justify-between items-center mb-5">
                    <h2 class="font-parkinsans text-2xl font-semibold text-text-primary">
                        More About Me
                    </h2>
                    <x-lucide-lightbulb class="w-6 h-6 text-primary"/>
                </div>

                <p class="font-montserrat text-text-secondary leading-relaxed text-sm whitespace-pre-line">{{ auth()->user()->more_about ?: 'No description provided yet.' }}</p>

            </div>

            <div class="mt-12 flex flex-col gap-5">

                @unless (auth()->user()->hide_email)
                    <div class="flex items-center gap-3 text-text-secondary">
                        <x-lucide-mail class="w-5 h-5 text-primary" />

                        <span class="font-montserrat text-sm">
                            {{ auth()->user()->email }}
                        </span>
                    </div>
                @endunless

                @if (auth()->user()->linkedin)
                    <div class="flex items-center gap-3 text-text-secondary">
                        <x-lucide-linkedin class="w-5 h-5 text-primary" />

                        <span class="font-montserrat text-sm">
                            {{ auth()->user()->linkedin }}
                        </span>
                    </div>
                @endif

            </div>
        </div>

        <!-- TASK HELPED -->
        <div class="bg-background rounded-4xl p-6 shadow-sm border border-border">

            <div class="flex items-center justify-between mb-5">

                <h2 class="font-parkinsans text-2xl font-semibold text-text-primary">
                    Tasks Helped
                </h2>

                <div class="bg-primary text-white px-3 py-1 rounded-lg font-parkinsans font-bold text-2xl leading-none">
                    12
                </div>

            </div>

            <div class="flex flex-col gap-4">

                @foreach($taskHelped as $task)

                    <div
                        class="relative overflow-hidden rounded-3xl p-3 shadow-sm text-white"
                        style="background-color: {{ $task['color'] }}"
                    >

                        <!-- Top Section -->
                        <div class="flex gap-3 mb-4 row justify-between items-center">
                            <div class="flex row gap-3 items-center">
                                <div class="w-8 h-8 rounded-xl bg-white/15 backdrop-blur-sm flex items-center justify-center">
                                    <x-lucide-list-todo class="w-4 h-4" />
                                </div>
                                <h3 class="font-parkinsans text-xl font-bold leading-tight">
                                    {{ $task['project'] }}
                                </h3>
                            </div>
                            <div class="w-8 h-8 rounded-xl bg-white/20 backdrop-blur-sm border border-white/20 flex items-center justify-center">
                                <span class="font-montserrat font-semibold text-sm">
                                    {{ $task['point'] }}
                                </span>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="w-full h-px bg-white/35 rounded-lg mb-4"></div>

                        <!-- Task Description -->
                        <p class="font-montserrat text-sm leading-relaxed text-white/90">
                            {{ $task['task'] }}
                        </p>

                        <!-- Footer -->
                        <div class="flex items-center justify-between mt-4">
                            
                            <div class="flex items-center gap-2 text-white/80">
                                <x-lucide-calendar class="w-4 h-4" />
                                <span class="text-sm font-montserrat">
                                    {{ $task['date'] }}
                                </span>
                            </div>

                            <div class="px-3 py-1 rounded-full bg-white/15 border border-white/10 flex items-center">
                                <span class="text-xs font-semibold font-montserrat">
                                    Pending
                                </span>
                            </div>

                        </div>
                    </div>

                @endforeach

            </div>
        </div>

        <!-- TASK CREATED -->
        <div class="bg-background rounded-4xl p-6 shadow-sm border border-border">

            <div class="flex items-center justify-between mb-5">

                <h2 class="font-parkinsans text-2xl font-semibold text-text-primary">
                    Tasks Created
                </h2>

                <div class="bg-primary text-white px-3 py-1 rounded-lg font-parkinsans font-bold text-2xl leading-none">
                    1
                </div>

            </div>

            <div class="flex flex-col gap-4">

                @foreach($taskCreated as $task)

                    <div
                        class="relative overflow-hidden rounded-3xl p-3 shadow-sm text-white"
                        style="background-color: {{ $task['color'] }}"
                    >

                        <!-- Top Section -->
                        <div class="flex gap-3 mb-4 row justify-between items-center">
                            <div class="flex row gap-3 items-center">
                                <div class="w-8 h-8 rounded-xl bg-white/15 backdrop-blur-sm flex items-center justify-center">
                                    <x-lucide-list-todo class="w-4 h-4" />
                                </div>
                                <h3 class="font-parkinsans text-xl font-bold leading-tight">
                                    {{ $task['project'] }}
                                </h3>
                            </div>
                            <div class="w-8 h-8 rounded-xl bg-white/20 backdrop-blur-sm border border-white/20 flex items-center justify-center">
                                <span class="font-montserrat font-semibold text-sm">
                                    {{ $task['point'] }}
                                </span>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="w-full h-px bg-white/35 rounded-lg mb-4"></div>

                        <!-- Task Description -->
                        <p class="font-montserrat text-sm leading-relaxed text-white/90">
                            {{ $task['task'] }}
                        </p>

                        <!-- Footer -->
                        <div class="flex items-center justify-between mt-4">
                            
                            <div class="flex items-center gap-2 text-white/80">
                                <x-lucide-calendar class="w-4 h-4" />
                                <span class="text-sm font-montserrat">
                                    {{ $task['date'] }}
                                </span>
                            </div>

                            <div class="px-3 py-1 rounded-full bg-white/15 border border-white/10 flex items-center">
                                <span class="text-xs font-semibold font-montserrat">
                                    Pending
                                </span>
                            </div>

                        </div>
                    </div>

                @endforeach

            </div>

        </div>

    </div>

</div>

<!-- EDIT PROFILE MODAL -->
<div
    id="editProfileModal"
    class="fixed inset-0 z-[999] hidden bg-black/40 backdrop-blur-sm"
>

    <!-- CENTER -->
    <div class="min-h-screen flex items-center justify-center p-4">

        <!-- MODAL -->
        <div
            class="w-full max-w-[850px] max-h-[90vh] flex flex-col bg-background rounded-[32px] overflow-hidden shadow-2xl"
        >

            <!-- HEADER -->
            <div class="bg-primary h-[70px] shrink-0 px-8 flex items-center justify-between">

                <div class="flex items-center gap-3 text-white">
                    <x-lucide-pencil class="w-6 h-6" />

                    <h2 class="font-parkinsans text-2xl font-bold">
                        Edit Profile
                    </h2>
                </div>

                <button
                    type="button"
                    onclick="document.getElementById('editProfileModal').classList.add('hidden')"
                    class="text-white"
                >
                    <x-lucide-x class="w-8 h-8" />
                </button>

            </div>

            <!-- FORM (wraps banner + fields so uploads submit together) -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="flex-1 flex flex-col min-h-0 overflow-hidden">
                @csrf

                <!-- Hidden file inputs -->
                <input type="file" id="avatarInput" name="avatar" accept="image/*" class="hidden">
                <input type="file" id="bannerInput" name="banner" accept="image/*" class="hidden">

            <!-- BANNER -->
            <div class="relative h-[100px] shrink-0">

                <img
                    id="bannerPreview"
                    src="{{ $bannerUrl }}"
                    alt=""
                    class="w-full h-full object-cover"
                >

                <div class="absolute inset-0 flex items-center justify-between px-6">

                    <!-- LEFT -->
                    <div class="flex items-center gap-4">

                        <img
                            id="avatarPreview"
                            src="{{ $avatarUrl }}"
                            alt=""
                            class="w-[65px] h-[65px] rounded-full border-4 border-background object-cover"
                        >

                    </div>

                    <!-- RIGHT -->
                    <div class="flex gap-3">

                        <button
                            type="button"
                            onclick="document.getElementById('avatarInput').click()"
                            class="bg-primary text-white px-5 py-2 rounded-full flex items-center gap-2 font-montserrat text-sm font-semibold"
                        >
                            <x-lucide-upload class="w-4 h-4" />
                            Upload Icon
                        </button>

                        <button
                            type="button"
                            onclick="document.getElementById('bannerInput').click()"
                            class="bg-primary text-white px-5 py-2 rounded-full flex items-center gap-2 font-montserrat text-sm font-semibold"
                        >
                            <x-lucide-upload class="w-4 h-4" />
                            Upload Banner
                        </button>

                    </div>

                </div>

            </div>

            <!-- FIELDS -->
            <div class="p-6 flex-1 overflow-y-auto min-h-0">

                <!-- ROW -->
                <div class="grid grid-cols-2 gap-6">

                    <div>
                        <label class="block mb-2 font-montserrat font-bold text-base">
                            Username
                        </label>

                        <input
                            type="text"
                            name="username"
                            required
                            value="{{ old('username', $currentUser->username) }}"
                            class="w-full h-12 border-2 border-border rounded-xl px-4"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 font-montserrat font-bold text-base">
                            Full Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            required
                            value="{{ old('name', $currentUser->name) }}"
                            class="w-full h-12 border-2 border-border rounded-xl px-4"
                        >
                    </div>

                </div>

                <!-- LOCATION (City + Country side by side) -->
                <div class="mt-5 grid grid-cols-2 gap-6">

                    <div>
                        <label class="block mb-2 font-montserrat font-bold text-base">
                            City
                            <span class="font-normal text-text-secondary">
                                (optional)
                            </span>
                        </label>

                        <input
                            type="text"
                            name="city"
                            value="{{ old('city', $currentUser->city) }}"
                            class="w-full h-12 border-2 border-border rounded-xl px-4"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 font-montserrat font-bold text-base">
                            Country
                            <span class="font-normal text-text-secondary">
                                (optional)
                            </span>
                        </label>

                        <input
                            type="text"
                            name="country"
                            value="{{ old('country', $currentUser->country) }}"
                            class="w-full h-12 border-2 border-border rounded-xl px-4"
                        >
                    </div>

                </div>

                <!-- ABOUT ME (short header bio) -->
                <div class="mt-5">

                    <label class="block mb-2 font-montserrat font-bold text-base">
                        About Me
                    </label>

                    <textarea
                        rows="2"
                        name="about"
                        required
                        class="w-full border-2 border-border rounded-xl p-4 resize-none"
                    >{{ old('about', $currentUser->about) }}</textarea>

                </div>

                <!-- MORE ABOUT ME (long description) -->
                <div class="mt-5">

                    <label class="block mb-2 font-montserrat font-bold text-base">
                        More About Me
                        <span class="font-normal text-text-secondary">
                            (optional)
                        </span>
                    </label>

                    <textarea
                        rows="4"
                        name="more_about"
                        class="w-full border-2 border-border rounded-xl p-4 resize-none"
                    >{{ old('more_about', $currentUser->more_about) }}</textarea>

                </div>

                <!-- FOOTER -->
                <div class="mt-5 flex justify-between items-end">

                    <div class="w-[45%]">

                        <label class="block mb-2 font-montserrat font-bold text-base">
                            LinkedIn
                            <span class="font-normal text-text-secondary">
                                (optional)
                            </span>
                        </label>

                        <input
                            type="text"
                            name="linkedin"
                            value="{{ old('linkedin', $currentUser->linkedin) }}"
                            class="w-full h-12 border-2 border-border rounded-xl px-4"
                        >

                    </div>

                    <div class="flex items-center gap-6">

                        <label class="flex items-center gap-2">

                            <input
                                type="checkbox"
                                name="hide_email"
                                value="1"
                                {{ old('hide_email', $currentUser->hide_email) ? 'checked' : '' }}
                                class="w-5 h-5"
                            >

                            <span class="font-montserrat text-base">
                                Hide E-mail Address
                            </span>

                        </label>

                        <button
                            type="submit"
                            class="bg-primary text-white px-8 py-3 rounded-full flex items-center gap-2 font-parkinsans text-xl font-bold"
                        >
                            <x-lucide-save class="w-5 h-5" />
                            Save
                        </button>

                    </div>

                </div>

            </div>
            <!-- /FIELDS -->

            </form>

        </div>

    </div>

</div>

<!-- SUCCESS TOAST -->
@if (session('success'))
    <div
        id="profileToast"
        class="fixed bottom-6 right-6 z-[1000] bg-primary text-white px-6 py-3 rounded-2xl shadow-lg font-montserrat font-semibold flex items-center gap-2"
    >
        <x-lucide-circle-check class="w-5 h-5" />
        {{ session('success') }}
    </div>
    <script>
        setTimeout(() => document.getElementById('profileToast')?.remove(), 4000);
    </script>
@endif

<script>
    // Live preview for avatar + banner uploads
    (function () {
        function bindPreview(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            if (!input || !preview) return;

            input.addEventListener('change', function () {
                const file = this.files && this.files[0];
                if (!file) return;
                preview.src = URL.createObjectURL(file);
            });
        }

        bindPreview('avatarInput', 'avatarPreview');
        bindPreview('bannerInput', 'bannerPreview');

        // Re-open the modal automatically if the server returned validation errors
        @if ($errors->any())
            document.getElementById('editProfileModal')?.classList.remove('hidden');
        @endif
    })();
</script>

@endsection