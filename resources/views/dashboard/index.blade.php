@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<div class="p-4 md:p-8 pt-6 max-w-7xl mx-auto bg-linear-to-r from-surface to-background-gradient">
    <div id="dashboard-header" class="bg-background rounded-4xl p-6 mb-8 shadow-sm border border-border flex justify-between items-center">
        <div class="flex items-center gap-4">
            <img src="{{ auth()->check() ? auth()->user()->avatar_url : asset('images/profile.jpg') }}" alt="Profile" class="w-14 h-14 rounded-full object-cover shadow-sm border-[3px] border-border">
            <div>
                <h1 class="font-montserrat text-2xl font-bold text-text-primary">
                    Welcome Back, <span class="text-primary">@auth {{ auth()->user()->username }} @endauth</span>
                </h1>
                <p class="font-montserrat text-sm text-text-secondary mt-0.5">Start making progress and collab</p>
            </div>
        </div>
        
        <div class="relative">
            <button id="notif-btn" class="p-3 bg-background shadow-sm rounded-full border border-border hover:bg-surface transition-colors focus:outline-none">
                <x-lucide-bell class="w-6 h-6 text-text-primary" />
            </button>
            <div id="notif-dropdown" class="hidden absolute right-0 mt-3 w-72 bg-background border border-border shadow-lg rounded-2xl p-5 z-50 font-montserrat">
                <div class="flex justify-between items-center mb-3 border-b border-border pb-2">
                    <p class="font-bold text-sm text-text-primary">Notifications</p>
                    <span class="text-xs bg-primary text-white px-2 py-0.5 rounded-full">0 New</span>
                </div>
                <p class="text-xs text-text-secondary text-center py-4">You have no new notifications.</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

        <div class="lg:col-span-2 flex flex-col gap-8">
            
            <div id="dashboard-stats" class="bg-primary rounded-4xl p-6 shadow-md">
                <div class="flex items-center justify-between text-white mb-4">
                    <div class="flex items-center gap-3">
                        <x-lucide-notepad-text class="w-7 h-7 text-white" />
                        <h2 class="text-2xl font-bold font-montserrat text-white">
                            Account Statistics
                        </h2>
                    </div>
                    <button id="share-btn" class="focus:outline-none hover:opacity-70 transition-opacity cursor-pointer" title="Download Statistics">
                        <x-lucide-share-2 class="w-5 h-5" />
                    </button>
                </div>

                <div class="bg-surface rounded-3xl px-6 py-5 grid grid-cols-2 md:grid-cols-4 gap-2 divide-y md:divide-y-0 md:divide-x divide-border shadow-inner">
                    <div class="flex flex-col items-center justify-center">
                        <div class="flex items-center gap-1.5 text-primary font-montserrat font-semibold text-3xl">
                            <x-lucide-zap class="w-6 h-6 fill-current" /> {{ $statistics['login_streak']['current'] }}
                        </div>
                        <p class="font-montserrat font-semibold text-text-primary text-sm mt-1">Login Streak</p>
                        <p class="text-xs text-text-secondary font-montserrat mt-0.5"><span class="font-bold text-text-primary">{{ $statistics['login_streak']['best'] }}</span> Best</p>
                    </div>
                    <div class="flex flex-col items-center justify-center pt-4 md:pt-0">
                        <div class="flex items-center gap-1.5 text-primary font-montserrat font-semibold text-3xl">
                            <x-lucide-file-text class="w-6 h-6" /> {{ $statistics['projects_completed'] }}
                        </div>
                        <p class="font-montserrat font-semibold text-text-primary text-sm mt-1">Projects</p>
                        <p class="text-xs text-text-secondary font-montserrat mt-0.5">Completed</p>
                    </div>
                    <div class="flex flex-col items-center justify-center pt-4 md:pt-0">
                        <div class="flex items-center gap-1.5 text-primary font-montserrat font-semibold text-3xl">
                            <x-lucide-users class="w-6 h-6" /> {{ $statistics['collabs_completed'] }}
                        </div>
                        <p class="font-montserrat font-semibold text-text-primary text-sm mt-1">Collabs</p>
                        <p class="text-xs text-text-secondary font-montserrat mt-0.5">Completed</p>
                    </div>
                    <div class="flex flex-col items-center justify-center pt-4 md:pt-0">
                        <div class="flex items-center gap-1.5 text-primary font-montserrat font-semibold text-3xl">
                            <x-lucide-coins class="w-6 h-6" /> {{ $statistics['points']['current'] }}
                        </div>
                        <p class="font-montserrat font-semibold text-text-primary text-sm mt-1">Points</p>
                        <p class="text-xs text-text-secondary font-montserrat mt-0.5"><span class="font-bold text-text-primary">{{ $statistics['points']['highest'] }}</span> Highest</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col">
                <div class="flex items-center gap-3 mb-4">
                    <x-lucide-bar-chart-3 class="w-7 h-7 text-primary" />
                    <h2 class="text-2xl font-bold font-montserrat text-text-primary">
                        Task Contribution Statistics
                    </h2>
                </div>
                <div class="bg-background rounded-3xl p-6 shadow-sm border border-border flex flex-col justify-between">
                    <div class="flex justify-end gap-3 mb-4" id="chart-tabs">
                        <button data-range="weekly" class="chart-tab bg-surface border border-border text-text-primary text-xs font-montserrat font-bold px-4 py-1.5 rounded-full transition-colors focus:outline-none">Weekly</button>
                        <button data-range="monthly" class="chart-tab active bg-border shadow-sm text-text-primary text-xs font-montserrat font-bold px-4 py-1.5 rounded-full transition-colors focus:outline-none">Monthly</button>
                        <button data-range="annually" class="chart-tab bg-surface border border-border text-text-primary text-xs font-montserrat font-bold px-4 py-1.5 rounded-full transition-colors focus:outline-none">Annually</button>
                    </div>
                    
                    <div class="flex h-56 md:h-64">
                        {{-- Y AXIS --}}
                        <div id="chart-y-axis" class="flex flex-col justify-between text-xs font-montserrat font-medium text-text-secondary text-right w-10 shrink-0 pr-3 -my-[6px] leading-none"></div>

                        {{-- PLOT AREA --}}
                        <div class="relative flex-1 h-full">
                            <div class="absolute inset-0 bg-surface rounded-2xl overflow-hidden">
                                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                                    {{-- Guiding lines sit behind the data --}}
                                    <g id="chart-grid"></g>
                                    <polygon id="chart-polygon" points="" fill="var(--color-primary)" opacity="0.12" class="transition-all duration-500" />
                                    <polyline id="chart-polyline" points="" fill="none" stroke="var(--color-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" class="transition-all duration-500" />
                                    {{-- X and Y axis lines drawn last so they stay crisp --}}
                                    <g id="chart-axes"></g>
                                </svg>
                            </div>
                            {{-- Markers live outside the clipped box so edge points stay round and whole --}}
                            <div id="chart-dots" class="absolute inset-0 pointer-events-none"></div>
                        </div>
                    </div>

                    {{-- X AXIS (spacer keeps labels aligned with the plot area) --}}
                    <div class="flex mt-2">
                        <div class="w-10 shrink-0"></div>
                        <div id="chart-x-axis" class="flex justify-between flex-1 text-xs font-montserrat font-medium text-text-secondary"></div>
                    </div>
                </div>
            </div>

        </div>

        <div class="lg:col-span-1 flex flex-col h-full">
            <div class="row flex items-center gap-3 mb-4">
                <x-lucide-clock class="w-7 h-7 text-primary" />
                <h2 class="text-2xl font-bold font-montserrat text-text-primary">
                    Current Projects
                </h2>
            </div>
            <div class="flex flex-col gap-4">

                @forelse ($projects->take(3) as $proj)
                    <a href="/projects/{{$proj->id}}" class="block bg-background rounded-3xl p-5 shadow-sm border border-border relative overflow-hidden group hover:shadow-md hover:-translate-y-0.5 transition-all">
                        <div class="absolute left-4 top-5 bottom-5 w-1 rounded-full" style="background-color: {{ $proj->accent ?? '#14452F' }}"></div>

                        <div class="pl-4">
                            <div class="row gap-2 flex items-center">
                                <div class="p-1.5 rounded-xl flex justify-center items-center shrink-0" style="background-color: {{ $proj->accent }}">
                                    <x-dynamic-component
                                        :component="'lucide-' . ($proj->icon ?: 'folder')"
                                        class="w-3.5 h-3.5 text-text-contrast"
                                    />
                                </div>
                                <h3 class="font-montserrat font-semibold text-text-primary text-xl group-hover:text-primary transition-colors truncate">{{ $proj->title }}</h3>
                            </div>
                            <p class="font-montserrat text-sm text-text-primary mt-1.5 line-clamp-2 leading-relaxed">{{ $proj->description }}</p>

                            <div class="mt-5 flex items-center justify-between text-sm font-montserrat font-semibold text-text-primary mb-2">
                                <span>Progress:</span>
                                <span>{{ $proj->progress ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-border h-1.5 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-1000" style="width: {{ $proj->progress ?? 0 }}%; background-color: {{ $proj->accent ?? '#14452F' }}"></div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="bg-background rounded-3xl p-6 text-center shadow-sm border border-border">
                        <p class="font-montserrat text-sm text-text-secondary">No active projects yet.</p>
                    </div>
                @endforelse

                <a href="/projects" class="mt-1 w-full bg-primary hover:bg-primary-hover text-white py-2.5 rounded-full flex items-center justify-center gap-2 font-montserrat font-bold text-sm transition-colors shadow-md">
                    <x-lucide-eye class="w-5 h-5" /> All Projects
                </a>
            </div>
        </div>
    </div>

    <div class="w-full">
        <div class="flex items-center gap-3 mb-2">
            <x-lucide-clipboard-clock class="w-7 h-7 text-primary" />
            <h2 class="text-2xl font-bold font-montserrat text-text-primary">
                Task Reminder
            </h2>
        </div>
        <div class="font-montserrat text-base text-text-secondary mb-5">Keep your project on plan. Finish nearly overdue and past deadline tasks.</div>

        @forelse ($taskReminders as $task)
            @if ($loop->first)
                <div class="columns-1 md:columns-2 lg:columns-3 gap-6 space-y-6">
            @endif
                @php
                    $priorityClass = match ($task['priority']) {
                        'high' => 'bg-red-accent',
                        'medium' => 'bg-yellow-accent',
                        default => 'bg-quartiary',
                    };
                    $isCritical = $task['type'] === 'critical';
                @endphp

                <a href="{{ route('projects.tasks', $task['project_id']) }}" class="block bg-background rounded-3xl p-5 pl-9 shadow-sm relative w-full hover:shadow-md hover:-translate-y-0.5 transition-all break-inside-avoid group">

                    {{-- Floating Left Accent Line --}}
                    <div class="absolute left-4 top-6 bottom-7 w-1 rounded-full {{ $isCritical ? 'bg-red-accent' : 'bg-yellow-accent' }}"></div>

                    {{-- HEADER ROW --}}
                    <div class="flex justify-between items-center mb-3 shrink-0">

                        {{-- Top Left: Priority --}}
                        <div class="{{ $priorityClass }} px-3 py-1 rounded-lg flex items-center justify-center shadow-2xs">
                            <span class="font-montserrat text-white text-xs font-semibold uppercase tracking-wider leading-none">
                                {{ $task['priority'] }}
                            </span>
                        </div>

                        {{-- Top Right: Urgency --}}
                        <div class="{{ $isCritical ? 'text-pastel-red-text' : 'text-pastel-yellow-text' }} flex flex-row gap-2.5 items-center">
                            <div class="{{ $isCritical ? 'bg-pastel-red-background' : 'bg-pastel-yellow-background' }} px-3 py-1 rounded-lg flex items-center justify-center">
                                <span class="font-montserrat text-xs font-semibold leading-none">{{ $task['urgency'] }}</span>
                            </div>
                            @if ($isCritical)
                                <x-lucide-alert-circle class="w-5 h-5" />
                            @else
                                <x-lucide-clock class="w-5 h-5" />
                            @endif
                        </div>

                    </div>

                    {{-- PROJECT --}}
                    <div class="flex items-center gap-2 mb-3 shrink-0">
                        <div class="p-1 rounded-lg flex justify-center items-center shrink-0" style="background-color: {{ $task['project_accent'] }}">
                            <x-dynamic-component
                                :component="'lucide-' . $task['project_icon']"
                                class="w-3.5 h-3.5 text-text-contrast"
                            />
                        </div>
                        <span class="font-montserrat text-text-secondary text-sm truncate">{{ $task['project_name'] }}</span>
                    </div>

                    {{-- TITLE --}}
                    <div class="pr-2 flex flex-col grow">
                        <h2 class="text-text-primary text-xl font-semibold font-montserrat leading-snug group-hover:text-primary transition-colors">
                            {{ $task['title'] }}
                        </h2>
                    </div>

                    {{-- DUE DATE & COUNTDOWN ROW --}}
                    <div class="flex flex-row items-center justify-between mt-4 mb-3 shrink-0">
                        <div class="flex flex-row gap-1.5 items-center">
                            <x-lucide-calendar class="w-3.5 h-3.5 text-text-secondary"/>
                            <p class="font-montserrat text-text-secondary text-sm">Due {{ $task['due_date'] }}</p>
                        </div>
                        <p class="font-montserrat text-xs font-bold whitespace-nowrap ml-2 {{ $isCritical ? 'text-red-accent' : 'text-yellow-accent' }}">
                            {{ $task['countdown'] }}
                        </p>
                    </div>

                    {{-- View button --}}
                    <div class="text-text-primary w-full py-1.5 border-2 border-gray-100 shadow-sm rounded-full flex items-center justify-center gap-2 font-semibold text-sm group-hover:bg-surface transition-colors font-montserrat shrink-0">
                        View
                        <x-lucide-eye class="w-4 h-4 text-text-secondary" />
                    </div>
                </a>
            @if ($loop->last)
                </div>
            @endif
        @empty
            <div class="bg-background rounded-3xl p-6 text-center shadow-sm border border-border">
                <p class="font-montserrat text-sm text-text-secondary">Nothing due in the next few days. You're all caught up.</p>
            </div>
        @endforelse
    </div>

</div>

<!-- <x-footer /> -->

<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Logika Dropdown Notifikasi
    const notifBtn = document.getElementById('notif-btn');
    const notifDropdown = document.getElementById('notif-dropdown');
    
    notifBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        notifDropdown.classList.toggle('hidden');
    });
    
    document.addEventListener('click', (e) => {
        if (notifBtn && notifDropdown && !notifBtn.contains(e.target) && !notifDropdown.contains(e.target)) {
            notifDropdown.classList.add('hidden');
        }
    });

    // 2. Logika Tab Grafik - digerakkan oleh data asli dari database
    const contribution = @json($contribution);

    const chartTabs = document.querySelectorAll('.chart-tab');
    const chartPolygon = document.getElementById('chart-polygon');
    const chartPolyline = document.getElementById('chart-polyline');
    const chartGrid = document.getElementById('chart-grid');
    const chartAxes = document.getElementById('chart-axes');
    const chartDots = document.getElementById('chart-dots');
    const chartYAxis = document.getElementById('chart-y-axis');
    const chartXAxis = document.getElementById('chart-x-axis');

    // Number of horizontal bands; also the number of y-axis labels minus one.
    const DIVISIONS = 5;

    // The viewBox is stretched to fit the container (preserveAspectRatio="none"),
    // so every stroke uses non-scaling-stroke to keep an even, consistent weight.
    const stroke = (x1, y1, x2, y2, color, width, dashed) =>
        `<line x1="${x1}" y1="${y1}" x2="${x2}" y2="${y2}" stroke="${color}" stroke-width="${width}"` +
        `${dashed ? ' stroke-dasharray="4 3"' : ''} vector-effect="non-scaling-stroke" />`;

    const renderChart = (range) => {
        const data = contribution[range];
        if (!data) return;

        const max = Math.max(data.max, 1);
        const divisor = Math.max(data.values.length - 1, 1);

        const points = data.values.map((value, i) => ({
            x: (i / divisor) * 100,
            y: 100 - (value / max) * 100,
            value,
            label: data.labels[i],
        }));

        const pointString = points
            .map(p => `${p.x.toFixed(2)},${p.y.toFixed(2)}`)
            .join(' ');

        chartPolygon.setAttribute('points', `0,100 ${pointString} 100,100`);
        chartPolyline.setAttribute('points', pointString);

        // Guiding lines: one per y-axis step, plus one rising from each data point.
        const horizontal = Array.from({ length: DIVISIONS + 1 }, (_, i) =>
            stroke(0, (i / DIVISIONS) * 100, 100, (i / DIVISIONS) * 100, 'var(--color-light-border)', 1, true)
        ).join('');

        const vertical = points
            .map(p => stroke(p.x.toFixed(2), 0, p.x.toFixed(2), 100, 'var(--color-light-border)', 1, true))
            .join('');

        chartGrid.innerHTML = horizontal + vertical;

        // Solid axes along the left and bottom edges, darker than the grid so
        // the hierarchy stays readable.
        chartAxes.innerHTML =
            stroke(0, 0, 0, 100, 'var(--color-text-secondary)', 1.5, false) +
            stroke(0, 100, 100, 100, 'var(--color-text-secondary)', 1.5, false);

        // Markers are HTML rather than SVG circles, which would be squashed
        // into ellipses by the stretched viewBox.
        chartDots.innerHTML = points
            .map(p =>
                `<span class="absolute w-2.5 h-2.5 rounded-full bg-primary border-2 border-background shadow-2xs" ` +
                `style="left:${p.x.toFixed(2)}%;top:${p.y.toFixed(2)}%;transform:translate(-50%,-50%)" ` +
                `title="${p.label}: ${p.value}"></span>`
            )
            .join('');

        chartYAxis.innerHTML = Array.from({ length: DIVISIONS + 1 }, (_, i) =>
            `<span>${Math.round((data.max * (DIVISIONS - i)) / DIVISIONS)}</span>`
        ).join('');

        chartXAxis.innerHTML = data.labels
            .map(label => `<span>${label}</span>`)
            .join('');
    };

    // Draw the default range on load.
    renderChart('monthly');

    chartTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            chartTabs.forEach(t => {
                t.classList.remove('bg-border', 'shadow-sm', 'active');
                t.classList.add('bg-surface', 'border', 'border-border');
            });

            tab.classList.remove('bg-surface', 'border', 'border-border');
            tab.classList.add('bg-border', 'shadow-sm', 'active');

            renderChart(tab.dataset.range);
        });
    });

    // 3. Logika Share Statistics
    const shareBtn = document.getElementById('share-btn');

    shareBtn?.addEventListener('click', () => {
        document.body.style.cursor = 'wait';
        
        const exportDiv = document.createElement('div');
        exportDiv.style.position = 'absolute';
        exportDiv.style.left = '-9999px';
        exportDiv.style.top = '-9999px';
        exportDiv.style.width = '800px'; 
        exportDiv.style.padding = '32px';
        exportDiv.style.backgroundColor = getComputedStyle(document.body).getPropertyValue('--color-background') || '#FFFFFF'; 
        
        const headerClone = document.getElementById('dashboard-header').cloneNode(true);
        const statsClone = document.getElementById('dashboard-stats').cloneNode(true);
        
        headerClone.querySelector('button')?.remove();
        headerClone.querySelector('.relative')?.remove();
        
        exportDiv.appendChild(headerClone);
        
        const spacer = document.createElement('div');
        spacer.style.height = '24px';
        exportDiv.appendChild(spacer);
        
        exportDiv.appendChild(statsClone);
        document.body.appendChild(exportDiv);

        html2canvas(exportDiv, { backgroundColor: null, scale: 2 }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'Progrest_Statistics.jpg';
            link.href = canvas.toDataURL('image/jpeg', 1.0);
            link.click();

            document.body.removeChild(exportDiv);
            document.body.style.cursor = 'default';
        }).catch(err => {
            console.error("Gagal mendownload gambar:", err);
            document.body.style.cursor = 'default';
        });
    });
});
</script>
@endsection
