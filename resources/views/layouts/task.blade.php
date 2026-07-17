<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="icon" href="/images/progrest_p_logo_green.png">
    
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    <script>
        const isCollapsed = localStorage.getItem("sidebarCollapsed") === "true";

        if (isCollapsed) {
            document.documentElement.classList.add("sidebar-collapsed");
        }

        document.documentElement.classList.add("no-transition");
    </script>
    <style>
        #sidebar {
            width: 16rem;
            overflow: hidden;
            will-change: width; 
            z-index: 50; 
            position: fixed; 
        }
        .sidebar-collapsed .sidebar-theme {
            margin-top: 2rem; 
        }
        .sidebar-collapsed .sidebar-theme > .flex.flex-row {
            flex-direction: column;
            align-items: center;
        }
        .sidebar-collapsed #sidebar {
            width: 5rem;
        }
        .sidebar-collapsed .sidebar-text {
            display: none;
        }
        .sidebar-collapsed .sidebar-indicator {
            display: none;
        }
        .sidebar-collapsed .sidebar-item {
            justify-content: center !important;
        }
        .sidebar-collapsed #app-logo {
            display: none;
        }
        .sidebar-collapsed #app-logo-p {
            display: block;
        }
        .no-transition * {
            transition: none !important;
        }
        #sidebarFiller{
            width: 16rem;
        }
        .sidebar-collapsed #sidebarFiller {
            width: 5rem;
        }
        /* --- TAMBAHAN UNTUK THEME COLLAPSE --- */
        .sidebar-collapsed .sidebar-theme-title {
            text-align: center;
            font-size: 0.65rem; /* Mengecilkan teks "THEMES" agar pas di tengah */
            margin-bottom: 0.2rem;
        }
        .sidebar-collapsed .sidebar-expanded-theme {
            display: none !important; /* Sembunyikan 3 tombol saat collapse */
        }
        .sidebar-collapsed .sidebar-collapsed-theme {
            display: flex !important; /* Tampilkan 1 tombol siklus saat collapse */
        }
        .date-input::-webkit-calendar-picker-indicator {
            opacity: 0;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="flex min-h-screen bg-surface">
        
        <aside class="hidden md:flex md:shrink-0">
            <x-sidebar :menu="$menu"/>
            <div id="sidebarFiller"></div>
        </aside>
        
        <div class="flex flex-col flex-1 min-w-0">
            <x-hamburger :menu="$menu"/>
            
            <main class="flex-1 relative focus:outline-none">
                @yield('content')

                @include('components.footer')
            </main>
        </div>
    </div>

    {{-- OPENED PANEL OVERLAY --}}

    <div id="overlay" class="fixed inset-0 hidden bg-black/50 z-40"></div>

    {{-- SLIDE PANEL --}}

    <div id="panel" class="fixed flex flex-col top-0 right-0 z-50 h-full w-full max-w-lg
        translate-x-full bg-background shadow-2xl
        transition-transform duration-300 p-4 rounded-l-2xl">

            {{-- Aksen Hijau I  --}}
            <div class="absolute -top-24 left-1/2
                h-64 w-86 -translate-x-1/2
                rounded-full bg-emerald-300/15
                blur-3xl">
            </div>

            <!-- Aksen Hijau II -->
            <div class="absolute top-10 right-10
                        h-40 w-66 rounded-full
                        bg-green-200/15 blur-3xl">
            </div>

            <div class="flex flex-col items-end justify-between pb-4 mb-3">
                <button onclick="closePanel()" class="text-xl font-semibold hover:rotate-90 rotate-0 transition duration-300 text-text-primary">
                    ✕
                </button>
                <div class="flex gap-5 items-center w-full -mt-1">
                    <div class="flex justify-center items-center w-14 h-14 border-pastel-green-text bg-pastel-green-background border-2 p-2 rounded-2xl shadow-3xl shadow-[0_10px_30px_rgba(0,0,0,0.12)]">
                        <x-lucide-folder-plus class="w-8 text-pastel-green-text"/>
                    </div>
                    <div class="flex flex-col text-text-secondary text-sm max-w-70">
                        <p class="font-montserrat font-bold text-2xl text-text-primary">Create New Task</p>
                        <p>Create a New Task and Assign Team Members</p>
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto">
                <form method="POST" action="{{ route('projects.store') }}" class="flex flex-col gap-4">
                    @csrf
                    <div class="space-y-4 p-4 flex flex-col border-[1.5px] rounded-xl border-border">
                        <div class="flex flex-row gap-2 items-center">
                            <div class="shadow-2xl shadow-pastel-green-background">
                                <x-lucide-folder-git-2 class="w-5 text-pastel-green-text"/>
                            </div>
                            <p class="font-montserrat font-semibold text-[14px] text-text-primary">Task Details</p>
                        </div>

                        <div class="flex flex-col gap-1">
                            <p class="font-montserrat font-semibold text-[12px] text-text-primary">Task Title</p>

                            {{-- Task TITLE INPUT --}}

                            <input
                                x-model="title"
                                name="title"
                                type="text"
                                placeholder="e.g. User Interface Refinement"
                                class="w-full rounded-lg border-[1.5px] border-text-primary/50 px-3 py-2 text-sm text-text-primary placeholder:text-placeholder"
                            >
                        </div>

                        <div class="flex flex-col gap-1">
                            <p class="font-montserrat font-semibold text-[12px] text-text-primary">Task Description</p>

                            {{-- PROJECT DESCRIPTION INPUT --}}

                            <textarea
                                x-model="description"
                                name="description"
                                placeholder="Describe the overview and purpose of the task..."
                                class="w-full h-30 rounded-lg border-[1.5px] border-text-primary/50 px-3 py-2 text-sm text-text-primary placeholder:text-placeholder"
                            ></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">

                        {{-- APPEARANCE INPUT (COLOR THEME) --}}

                        <div class="space-y-4 p-4 flex flex-col border-[1.5px] rounded-xl border-border">
                            <div class="flex flex-row gap-2 items-center">
                                <div class="shadow-2xl shadow-pastel-green-background">
                                    <x-lucide-palette class="w-5 text-pastel-green-text"/>
                                </div>
                                <p class="font-montserrat font-semibold text-[14px] text-text-primary">Task Theme</p>
                            </div>

                            {{-- HIDDEN INPUT --}}

                            <input type="hidden" name="accent" id="selectedTheme" value="#0EA5A4">

                            {{-- COLOR OPTIONS --}}

                            <div class="grid grid-cols-2 min-[360px]:grid-cols-3 min-[480px]:grid-cols-4 place-items-center gap-y-4">
                                <button
                                    type="button"
                                    @click="accentColor = '#0EA5A4'"
                                    onclick="selectTheme('#0EA5A4', this)" 
                                    class="flex justify-center items-center theme-option w-7 h-7 rounded-full bg-cyan ring-4 ring-offset-2 ring-cyan/20"
                                >
                                    <x-lucide-check class="theme-check-icon w-4 text-text-contrast"/>
                                </button>
                                <button
                                    type="button"
                                    @click="accentColor = '#8B5A2B'"
                                    onclick="selectTheme('#8B5A2B', this)"
                                    class="flex justify-center items-center theme-option w-7 h-7 rounded-full bg-brown ring-brown/20"
                                >
                                    <x-lucide-check class="theme-check-icon w-4 text-text-contrast hidden"/>
                                </button>
                                <button
                                    type="button"
                                    @click="accentColor = '#7C2D8E'"
                                    onclick="selectTheme('#7C2D8E', this)"
                                    class="flex justify-center items-center theme-option w-7 h-7 rounded-full bg-purple ring-purple/20"
                                >
                                    <x-lucide-check class="theme-check-icon w-4 text-text-contrast hidden"/>
                                </button>
                                <button
                                    type="button"
                                    @click="accentColor = '#0056D2'"
                                    onclick="selectTheme('#0056D2', this)"
                                    class="flex justify-center items-center theme-option w-7 h-7 rounded-full bg-blue ring-blue/20"
                                >
                                    <x-lucide-check class="theme-check-icon w-4 text-text-contrast hidden"/>
                                </button>
                                <button
                                    type="button"
                                    @click="accentColor = '#F35C75'"
                                    onclick="selectTheme('#F35C75', this)"
                                    class="flex justify-center items-center theme-option w-7 h-7 rounded-full bg-pink ring-pink/20"
                                >
                                    <x-lucide-check class="theme-check-icon w-4 text-text-contrast hidden"/>
                                </button>
                                <button
                                    type="button"
                                    @click="accentColor = '#1F5D3A'"
                                    onclick="selectTheme('#1F5D3A', this)"
                                    class="flex justify-center items-center theme-option w-7 h-7 rounded-full bg-green ring-green/20"
                                >
                                    <x-lucide-check class="theme-check-icon w-4 text-text-contrast hidden"/>
                                </button>
                                <button
                                    type="button"
                                    @click="accentColor = '#F38D08'"
                                    onclick="selectTheme('#F38D08', this)"
                                    class="flex justify-center items-center theme-option w-7 h-7 rounded-full bg-orange ring-orange/20"
                                >
                                    <x-lucide-check class="theme-check-icon w-4 text-text-contrast hidden"/>
                                </button>
                                <button
                                    type="button"
                                    @click="accentColor = '#FFEB99'"
                                    onclick="selectTheme('#FFEB99', this)"
                                    class="flex justify-center items-center theme-option w-7 h-7 rounded-full bg-yellow ring-yellow/20"
                                >
                                    <x-lucide-check class="theme-check-icon w-4 text-text-contrast hidden"/>
                                </button>
                                <button
                                    type="button"
                                    @click="accentColor = '#000000'"
                                    onclick="selectTheme('#000000', this)"
                                    class="flex justify-center items-center theme-option w-7 h-7 rounded-full bg-black ring-black/20"
                                >
                                    <x-lucide-check class="theme-check-icon w-4 text-text-contrast hidden"/>
                                </button>
                                <button
                                    type="button"
                                    @click="accentColor = '#0F766E'"
                                    onclick="selectTheme('#0F766E', this)"
                                    class="flex justify-center items-center theme-option w-7 h-7 rounded-full bg-teal ring-teal/20"
                                >
                                    <x-lucide-check class="theme-check-icon w-4 text-text-contrast hidden"/>
                                </button>
                                <button
                                    type="button"
                                    @click="accentColor = '#84CC16'"
                                    onclick="selectTheme('#84CC16', this)"
                                    class="flex justify-center items-center theme-option w-7 h-7 rounded-full bg-lime ring-lime/20"
                                >
                                    <x-lucide-check class="theme-check-icon w-4 text-text-contrast hidden"/>
                                </button>
                                <button
                                    type="button"
                                    @click="accentColor = '#E11D48'"
                                    onclick="selectTheme('#E11D48', this)"
                                    class="flex justify-center items-center theme-option w-7 h-7 rounded-full bg-rose ring-rose/20"
                                >
                                    <x-lucide-check class="theme-check-icon w-4 text-text-contrast hidden"/>
                                </button>
                            </div>
                        </div>

                        {{-- HIDDEN INPUT KHUSUS ICON --}}

                        <input type="hidden" name="icon" id="selectedIcon" value="folder">

                        {{-- ICONS SELECTION INPUT --}}

                        <div class="space-y-4 p-4 flex flex-col border-[1.5px] rounded-xl border-border"
                        >
                            <div class="flex flex-col gap-3">

                                {{-- HEADER --}}
                                <div class="flex flex-row gap-2 items-center">
                                    <div class="shadow-2xl shadow-pastel-green-background">
                                        <x-lucide-loader-pinwheel class="w-5 text-pastel-green-text"/>
                                    </div>

                                    <p class="font-montserrat font-semibold text-[14px] text-text-primary">
                                        Task Icon
                                    </p>
                                </div>

                                {{-- DEFAULT ICONS --}}
                                <div class="grid grid-cols-2 min-[360px]:grid-cols-3 min-[480px]:grid-cols-4 place-items-center gap-y-4">

                                    <button type="button" 
                                        @click="icon = 'folder'"
                                        onclick="selectIcon('folder', this)"
                                        class="icon-option bg-quartiary/80 p-2 rounded-lg border border-border hover:bg-secondary transition">
                                        <x-lucide-folder class="icon-icon w-4 h-4 text-text-contrast"/>
                                    </button>

                                    <button type="button"
                                        @click="icon = 'clock'"
                                        onclick="selectIcon('clock', this)"
                                        class="icon-option bg-background p-2 rounded-lg border border-border hover:bg-secondary transition">
                                        <x-lucide-clock class="icon-icon w-4 h-4 text-text-secondary"/>
                                    </button>

                                    <button type="button"
                                        @click="icon = 'book-open'"
                                        onclick="selectIcon('book-open', this)"
                                        class="icon-option bg-background p-2 rounded-lg border border-border hover:bg-secondary transition">
                                        <x-lucide-book-open class="icon-icon w-4 h-4 text-text-secondary"/>
                                    </button>

                                    <button type="button"
                                        @click="icon = 'chart-column'"
                                        onclick="selectIcon('chart-column', this)"
                                        class="icon-option bg-background p-2 rounded-lg border border-border hover:bg-secondary transition">
                                        <x-lucide-chart-column class="icon-icon w-4 h-4 text-text-secondary"/>
                                    </button>

                                    <button type="button"
                                        @click="icon = 'trees'"
                                        onclick="selectIcon('trees', this)"
                                        class="icon-option bg-background p-2 rounded-lg border border-border hover:bg-secondary transition">
                                        <x-lucide-trees class="icon-icon w-4 h-4 text-text-secondary"/>
                                    </button>

                                    <button type="button"
                                        @click="icon = 'calendar'"
                                        onclick="selectIcon('calendar', this)"
                                        class="icon-option bg-background p-2 rounded-lg border border-border hover:bg-secondary transition">
                                        <x-lucide-calendar class="icon-icon w-4 h-4 text-text-secondary"/>
                                    </button>

                                    <button type="button"
                                        @click="icon = 'backpack'"
                                        onclick="selectIcon('backpack', this)"
                                        class="icon-option p-2 bg-background rounded-lg border border-border hover:bg-secondary transition">
                                        <x-lucide-backpack class="icon-icon w-4 h-4 text-text-secondary"/>
                                    </button>

                                    <button type="button"
                                        @click="icon = 'camera'"
                                        onclick="selectIcon('camera', this)"
                                        class="icon-option p-2 bg-background rounded-lg border border-border hover:bg-secondary transition">
                                        <x-lucide-camera class="icon-icon w-4 h-4 text-text-secondary"/>
                                    </button>

                                    <button type="button"
                                        @click="icon = 'shopping-cart'"
                                        onclick="selectIcon('shopping-cart', this)"
                                        class="icon-option p-2 bg-background rounded-lg border border-border hover:bg-secondary transition">
                                        <x-lucide-shopping-cart class="icon-icon w-4 h-4 text-text-secondary"/>
                                    </button>

                                    <button type="button"
                                        @click="icon = 'gamepad-2'"
                                        onclick="selectIcon('gamepad-2', this)"
                                        class="icon-option p-2 bg-background rounded-lg border border-border hover:bg-secondary transition">
                                        <x-lucide-gamepad-2 class="icon-icon w-4 h-4 text-text-secondary"/>
                                    </button>

                                    <button type="button"
                                        @click="icon = 'cat'"
                                        onclick="selectIcon('cat', this)"
                                        class="icon-option p-2 bg-background rounded-lg border border-border hover:bg-secondary transition">
                                        <x-lucide-cat class="icon-icon w-4 h-4 text-text-secondary"/>
                                    </button>

                                    <button type="button"
                                        @click="icon = 'cooking-pot'"
                                        onclick="selectIcon('cooking-pot', this)"
                                        class="icon-option bg-background p-2 rounded-lg border border-border hover:bg-secondary transition">
                                        <x-lucide-cooking-pot class="icon-icon w-4 h-4 text-text-secondary"/>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Task TIMELINE INPUT --}}

                    <div class="space-y-4 p-4 flex flex-col border-[1.5px] rounded-xl border-border">
                        <div class="flex flex-row gap-2 items-center">
                            <div class="shadow-2xl shadow-pastel-green-background">
                                <x-lucide-calendar-clock class="w-5 text-pastel-green-text"/>
                            </div>
                            <p class="font-montserrat font-semibold text-[14px] text-text-primary">Timeline</p>
                        </div>

                        <div class="flex flex-col gap-1">
                            <p class="font-montserrat font-semibold text-[12px] text-text-primary">Due date (Optional)</p>

                            <div class="relative">

                                {{-- CUSTOM ICON --}}
                                <x-lucide-calendar
                                    class="absolute right-4 top-1/2 -translate-y-1/2
                                        w-4.5 h-4.5 text-text-primary pointer-events-none"
                                />

                                <input
                                    type="date"
                                    x-model="deadline"
                                    name="deadline"
                                    class="date-input w-full rounded-lg
                                        border-[1.5px] border-text-primary/50
                                        bg-background
                                        px-3 py-2.5
                                        text-sm placeholder:text-sm
                                        text-text-primary"
                                >
                            </div>
                        </div>
                    </div>

                    {{-- Task Detail Input --}}

                    <div class="space-y-4 p-4 flex flex-col border-[1.5px] rounded-xl border-border">
                        <div class="flex flex-row gap-2 items-center">
                            <div class="shadow-2xl shadow-pastel-green-background">
                                <x-lucide-calendar-clock class="w-5 text-pastel-green-text"/>
                            </div>
                            <p class="font-montserrat font-semibold text-[14px] text-text-primary">Details</p>
                        </div>

                        <div class="flex flex-col gap-1">
                            <p class="font-montserrat font-semibold text-[12px] text-text-primary">Task Status</p>

                            <div class="relative">

                                {{-- CUSTOM ICON --}}
                                <x-lucide-info
                                    class="absolute right-4 top-1/2 -translate-y-1/2
                                        w-4.5 h-4.5 text-text-primary pointer-events-none"
                                />

                                <div
                                    x-data="{ status: 'pending' }"
                                    class="relative inline-grid grid-cols-2 rounded-lg bg-gray-100 p-1">

                                    <div
                                        class="absolute left-1 top-1 h-[calc(100%-8px)] w-[calc(50%-4px)] rounded-md bg-primary-hover transition-transform duration-300"
                                        :class="status === 'in_progress' ? 'translate-x-full' : ''">
                                    </div>

                                    <label
                                        @click="status = 'pending'"
                                        :class="status === 'pending' ? 'text-white' : 'text-black'"
                                        class="relative z-10 px-6 py-2 cursor-pointer text-center">
                                        <input type="radio" name="status" value="pending" class="hidden font-montserrat" checked>
                                        Pending
                                    </label>

                                    <label
                                        @click="status = 'in_progress'"
                                        :class="status === 'in_progress' ? 'text-white' : 'text-black'"
                                        class="relative z-10 px-6 py-2 cursor-pointer text-center">
                                        <input type="radio" name="status" value="in_progress" class="hidden font-montserrat">
                                        In Progress
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <p class="font-montserrat font-semibold text-[12px] text-text-primary">Task Priority</p>

                            <div class="relative">

                                {{-- CUSTOM ICON --}}
                                <x-lucide-chart-no-axes-column-increasing
                                    class="absolute right-4 top-1/2 -translate-y-1/2
                                        w-4.5 h-4.5 text-text-primary pointer-events-none"
                                />

                                <div
                                    x-data="{ priority: 'medium' }"
                                    class="relative inline-grid grid-cols-3 rounded-lg bg-gray-100 p-1 w-72">

                                    <!-- Sliding Indicator -->
                                    <div
                                        class="absolute left-1 top-1 h-[calc(100%-8px)] w-[calc((100%-8px)/3)] rounded-md bg-primary-hover transition-all duration-300"
                                        :style="{
                                            transform:
                                                priority === 'low'
                                                    ? 'translateX(0%)'
                                                    : priority === 'medium'
                                                        ? 'translateX(100%)'
                                                        : 'translateX(200%)'
                                        }">
                                    </div>

                                    <!-- Low -->
                                    <label
                                        @click="priority = 'low'"
                                        :class="priority === 'low' ? 'text-white' : 'text-black'"
                                        class="relative z-10 cursor-pointer py-2 text-center">
                                        <input type="radio" name="priority" value="low" class="hidden font-montserrat">
                                        Low
                                    </label>

                                    <!-- Medium -->
                                    <label
                                        @click="priority = 'medium'"
                                        :class="priority === 'medium' ? 'text-white' : 'text-black'"
                                        class="relative z-10 cursor-pointer py-2 text-center">
                                        <input type="radio" name="priority" value="medium" class="hidden font-montserrat" checked>
                                        Medium
                                    </label>

                                    <!-- High -->
                                    <label
                                        @click="priority = 'high'"
                                        :class="priority === 'high' ? 'text-white' : 'text-black'"
                                        class="relative z-10 cursor-pointer py-2 text-center">
                                        <input type="radio" name="priority" value="high" class="hidden font-montserrat">
                                        High
                                    </label>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}

                    <button
                        type="submit"
                        class="flex items-center justify-center w-full rounded-2xl bg-primary  
                        hover:bg-primary-hover gap-3 py-3 text-text-contrast font-montserrat 
                        text-sm mb-1.5"
                    >
                        <x-lucide-rocket class="w-5 text-text-contrast"/>
                        Create Task
                    </button>

                </form>
            </div>

    </div>

    <script>
    function taskModal() {
        return {
            show: false,
            task: {},

            open(task) {
                this.task = task;
                this.show = true;
            },

            close() {
                this.show = false;
            }
        }
    }
    </script>
</body>
</html>