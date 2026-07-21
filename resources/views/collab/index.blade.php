@extends('layouts.app') 

@section('title', 'Collab')

@section('content')
    <div x-data="collabModal()">
        {{-- HEADER --}}

        <div class="bg-primary rounded-b-4xl px-8 py-6 flex flex-col lg:flex-row gap-4 justify-between shadow-md">
            <div>
                <h1 class="font-montserrat text-white text-4xl font-bold">Collaborations</h1>
                <h3 class="font-montserrat text-white/80 text-md mt-2">Collab with other users to complete a project together.</h3>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-end items-center">

                {{-- Search Bar --}} 
                <form method="GET" class="relative">

                    {{-- Simpan Hasil Sort Dulu --}}
                    <input type="hidden"
                        name="sort"
                        value="{{ request('sort', 'deadline') }}"
                    >

                    {{-- Simpan Hasil Direction Dulu --}}
                    <input type="hidden"
                        name="direction"
                        value="{{ request('direction', 'desc') }}"
                    >
                    
                    <div class="absolute pl-4 mt-2.5">
                        <x-lucide-search class="w-5 text-white"/>
                    </div>

                    <input type="text"
                        name="search"
                        value="{{ request('search') }}" 
                        placeholder="Search collabs..."
                        class="w-80 md:w-90 py-2 rounded-xl text-white text-md bg-white/10 font-montserrat pl-12 focus:outline-none transition-all duration-300"
                        onchange="this.form.submit()"
                    >
                </form>
            </div>
        </div>

        {{-- Collab STATISTICS --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 px-8 py-6">

            {{-- Active Collabs --}}

            <div class="rounded-3xl bg-background shadow-sm flex flex-col p-4 gap-1 items-center">
                <div class="flex gap-3">
                    <div class="w-10 h-10 rounded-3xl bg-pastel-green-background flex justify-center items-center">
                        <x-lucide-folder-open class="w-5 text-pastel-green-text"/> 
                    </div>
                    <p class="text-text-primary text-3xl font-montserrat font-semibold">??</p>
                </div>
                <p class="text-text-primary text-sm font-montserrat">Active Collabs</p>
            </div>
            
            {{-- Collabs Completed --}}

            <div class="rounded-3xl bg-background shadow-sm flex flex-col p-4 gap-1 items-center">
                <div class="flex gap-3">
                    <div class="w-10 h-10 rounded-3xl bg-pastel-blue-background flex justify-center items-center">
                        <x-lucide-folder-check class="w-5 text-pastel-blue-text"/> 
                    </div>
                    <p class="text-text-primary text-3xl font-montserrat font-semibold">??</p>
                </div>
                <p class="text-text-primary text-sm font-montserrat">Collabs Completed</p>
            </div>

            {{-- Points Gained --}}

            <div class="rounded-3xl bg-background shadow-sm flex flex-col p-4 gap-1 items-center col-span-2 md:col-span-1">
                <div class="flex gap-3">
                    <div class="w-10 h-10 rounded-3xl bg-pastel-yellow-background flex justify-center items-center">
                        <x-lucide-hand-coins class="w-5 text-pastel-yellow-text"/> 
                    </div>
                    <p class="text-text-primary text-3xl font-montserrat font-semibold">??</p>
                </div>
                <p class="text-text-primary text-sm font-montserrat">Points Gained</p>
            </div>
        </div>

        {{-- Active Collabs --}}

        <h1 class="font-montserrat text-text-primary text-2xl font-bold px-8">
            Your Active Collabs
        </h1>

        @if ($activeCollabTasks->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4 items-start px-8">
                @foreach ($activeCollabTasks as $task)
                    @include('collab.active-collab-card', [
                        'task' => $task,
                    ])
                @endforeach
            </div>
            @if ($activeCollabTasksCount > 3)
                <div class="px-8 mt-4 flex justify-end">
                    <a href="{{ route('collab.active') }}"
                        class="font-montserrat font-semibold text-primary hover:underline flex items-center gap-2">
                        View All ({{ $activeCollabTasksCount }})
                        <x-lucide-arrow-right class="w-4 h-4"/>
                    </a>
                </div>
            @endif

        @else
            @if(request()->filled('search'))
                <div class="mx-8 mt-4 rounded-3xl bg-background p-8 text-center shadow-sm">
                    <x-lucide-users class="w-10 h-10 mx-auto text-text-secondary mb-3"/>
                    <h2 class="font-montserrat font-semibold text-text-primary">
                        No active collaborations found
                    </h2>
                    <p class="font-montserrat text-sm text-text-secondary mt-2">
                        No active collaborations match 
                        <span class="font-semibold">"{{ request('search') }}"</span>
                    </p>
                </div>
            @else
                <div class="mx-8 mt-4 rounded-3xl bg-background p-8 text-center shadow-sm">
                    <x-lucide-users class="w-10 h-10 mx-auto text-text-secondary mb-3"/>
                    <h2 class="font-montserrat font-semibold text-text-primary">
                        No active collaborations
                    </h2>
                    <p class="font-montserrat text-sm text-text-secondary mt-2">
                        Join a collaboration below to start working with other teams.
                    </p>
                </div>
            @endif
        @endif

        {{-- All Collabs --}}

        <div class="flex justify-between items-center px-8 mt-10">
            <h1 class="font-montserrat text-text-primary text-2xl font-bold">All Available Collabs</h1>
            
            @if ($allCollabTasks->count() > 0)
                <div class="relative gap-4">

                    {{-- SORT BUTTON --}}
                    <form method="GET" class="flex gap-3">

                        <input
                            id="directionInput"
                            type="hidden"
                            name="direction"
                            value="{{ request('direction', 'desc') }}"
                        >

                        <button
                            type="submit"
                            name="direction"
                            value="{{ request('direction') === 'asc' ? 'desc' : 'asc' }}"
                            onclick="document.getElementById('directionInput').disabled = true"
                            class="bg-background rounded-2xl p-2 shadow-sm hover:bg-surface transition-colors cursor-pointer"
                        >
                            <x-lucide-arrow-up-down class="w-5 h-5 text-text-primary"/>
                        </button>

                        {{-- Sort Dropdown --}}
                        <select
                            name="sort"
                            onchange="this.form.submit()"
                            class="bg-background rounded-3xl pr-7 pl-4 shadow-sm font-montserrat text-sm text-text-primary hover:bg-surface transition-colors focus:outline-none cursor-pointer appearance-none"
                        >
                            
                            <option value="deadline" class="outline-none"
                                {{ request('sort') === 'deadline' ? 'selected' : '' }}>
                                {{ __('main.proj.sort-due') }}
                            </option>

                            <option value="alphabetical"
                                {{ request('sort') === 'alphabetical' ? 'selected' : '' }}>
                                {{ __('main.proj.sort-alpha') }}
                            </option>

                            <option value="progress"
                                {{ request('sort') === 'progress' ? 'selected' : '' }}>
                                {{ __('main.proj.sort-progress') }}
                            </option>
                        </select>

                        <x-lucide-chevron-down class="w-3.5 h-3.5 absolute right-2 top-1/2 -translate-y-1/2 text-text-primary"/>

                    </form>
                </div>
            @endif
        </div>

        {{-- Display All Collaborable Tasks --}}

        @if ($allCollabTasks->count() == 0)
            @if (request()->filled('search'))
                <div class="mx-8 mt-4 rounded-3xl bg-background p-8 text-center shadow-sm mb-8">
                    <x-lucide-users class="w-10 h-10 mx-auto text-text-secondary mb-3"/>
                    <h2 class="font-montserrat font-semibold text-text-primary">
                        No open collaborations found
                    </h2>
                    <p class="font-montserrat text-sm text-text-secondary mt-2">
                        No open collaborations match 
                        <span class="font-semibold">"{{ request('search') }}"</span>
                    </p>
                </div>
            @else
                <div class="mx-8 mt-4 rounded-3xl bg-background p-8 text-center shadow-sm mb-8">
                    <x-lucide-users class="w-10 h-10 mx-auto text-text-secondary mb-3"/>
                    <h2 class="font-montserrat font-semibold text-text-primary">
                        No open collaborations
                    </h2>
                    <p class="font-montserrat text-sm text-text-secondary mt-2">
                        Wait for other users to enable collaborations and see them here.
                    </p>
                </div>
            @endif
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4 items-start px-8 mb-8">
                @foreach ($allCollabTasks as $task)
                    @include('collab.all-collab-card', [
                        'task' => $task,
                    ]) 
                @endforeach
            </div>
        @endif

        {{-- Active Collab Task Details --}}

        <div
            x-show="show"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-6"
        >

            {{-- Green Accent --}}
            <div
                class="absolute -top-24 left-3/4
                    h-64 w-86
                    -translate-x-1/2
                    rounded-full
                    bg-green-300/15
                    blur-3xl"
            ></div>

            <div
                @click.outside="close()"
                class="bg-background rounded-3xl shadow-xl
                    w-full max-w-2xl
                    max-h-[90vh]
                    flex flex-col
                    overflow-hidden"
            >
                <!-- HEADER -->
                <div
                    class="flex items-center justify-between
                        px-6 py-5
                        border-b-2 border-border
                        shrink-0"
                >

                    <div class="flex items-center gap-3">

                        <div
                            class="
                                flex justify-center items-center
                                w-10 h-10
                                rounded-2xl
                                border-2
                                border-green-600
                                bg-mark-completed
                                shadow-[0_10px_30px_rgba(34,197,94,.18)]
                            "
                        >
                            <x-lucide-handshake
                                class="w-5 h-5 text-green-600"
                            />
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold font-montserrat text-text-primary">
                                Collaboration Details
                            </h2>
                            <p class="text-sm text-text-secondary font-montserrat">
                                View task collaboration information.
                            </p>
                        </div>
                    </div>


                    <button
                        @click="close()"
                        class="
                            w-11 h-11
                            rounded-full
                            hover:bg-surface
                            transition
                            hover:rotate-90
                            flex items-center justify-center
                            cursor-pointer
                        "
                    >
                        <x-lucide-x class="w-5 h-5"/>
                    </button>
                </div>

                <!-- BODY -->
                <div
                    class="
                        flex-1 overflow-y-auto
                        px-6 py-5
                        font-montserrat
                        space-y-6
                    "
                >
                    <!-- Task -->
                    <div>
                        <p class="text-xs font-semibold uppercase text-text-secondary">
                            Task
                        </p>
                        <div
                            class="
                                mt-2
                                bg-surface
                                rounded-2xl
                                px-5 py-4
                            "
                        >
                            <h3
                                class="
                                    font-semibold
                                    text-lg
                                    text-text-primary
                                "
                                x-text="collaboration.title"
                            ></h3>
                        </div>
                    </div>

                    <!-- Reward + Limit -->
                    <div class="grid md:grid-cols-2 gap-4">

                        <!-- Reward -->
                        <div
                            class="
                                bg-surface
                                rounded-2xl
                                p-5
                            "
                        >

                            <div class="flex items-center gap-2 mb-3">
                                <x-lucide-coins class="w-5 h-5 text-primary"/>
                                <p class="font-semibold text-text-primary">
                                    Reward
                                </p>
                            </div>

                            <div
                                class="
                                    bg-background
                                    rounded-xl
                                    px-4 py-3
                                "
                            >
                                <p
                                    class="text-text-secondary"
                                    x-text="collaboration.go_collab_reward ?? 'No reward provided.'"
                                ></p>
                            </div>
                        </div>

                        <!-- Limit -->
                        <div
                            class="
                                bg-surface
                                rounded-2xl
                                p-5
                            "
                        >
                            <div class="flex items-center gap-2 mb-3">
                                <x-lucide-users class="w-5 h-5 text-primary"/>
                                <p class="font-semibold text-text-primary">
                                    Collaborator Limit
                                </p>
                            </div>

                            <div
                                class="
                                    bg-background
                                    rounded-xl
                                    px-4 py-3
                                "
                            >
                                <p
                                    class="text-text-secondary"
                                    x-text="collaboration.go_collab_limit + ' collaborators'"
                                ></p>
                            </div>
                        </div>
                    </div>

                    <!-- External Collaborators -->
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <x-lucide-user-round-check
                                class="w-5 h-5 text-primary"
                            />
                            <p class="font-semibold text-text-primary">
                                Assigned Collaborators
                            </p>
                        </div>

                        <div
                            class="
                                bg-surface
                                rounded-2xl
                                p-5
                                space-y-3
                            "
                        >
                            <template
                                x-for="member in collaboration.collaborators"
                                :key="member.id"
                            >
                                <div
                                    class="
                                        flex items-center gap-3
                                        bg-background
                                        rounded-xl
                                        p-3
                                    "
                                >
                                    <img
                                        :src="member.avatar"
                                        class="
                                            w-9 h-9
                                            rounded-full
                                            object-cover
                                        "
                                    >
                                    <div>
                                        <p
                                            class="
                                                text-text-primary
                                                font-medium
                                            "
                                            x-text="member.name"
                                        ></p>
                                        <p
                                            class="
                                                text-sm
                                                text-text-secondary
                                            "
                                            x-text="member.email"
                                        ></p>
                                    </div>
                                </div>
                            </template>

                            <template
                                x-if="!collaboration.collaborators.length"
                            >
                                <p
                                    class="
                                        text-center
                                        text-text-secondary
                                        py-5
                                    "
                                >
                                    No external collaborators assigned.
                                </p>
                            </template>
                        </div>
                    </div>

                    <!-- Collaboration Notes -->
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <x-lucide-notebook-pen
                                class="w-5 h-5 text-primary"
                            />
                            <p class="font-semibold text-text-primary">
                                Collaboration Notes
                            </p>
                        </div>

                        <div
                            class="
                                rounded-2xl
                                bg-surface
                                px-5 py-4
                                min-h-28
                            "
                        >
                            <p
                                class="
                                    leading-7
                                    whitespace-pre-line
                                    text-text-secondary
                                "
                                x-text="
                                    collaboration.go_collab_description ||
                                    'No collaboration notes provided.'
                                "
                            ></p>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div
                    class="
                        border-t-2 border-border
                        px-6 py-5
                        font-montserrat
                        flex justify-end
                    "
                >
                    <button
                        @click="close()"
                        class="
                            px-6 py-2
                            rounded-2xl
                            border-2
                            border-border
                            hover:bg-surface
                            transition
                            text-text-primary
                            cursor-pointer
                        "
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>

        {{-- Mark Active Collab Task as Completed --}}
        <div
            x-show="showCompleteModal"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-6"
        >
            <div
                class="absolute -top-24 left-3/4
                    h-64 w-86
                    -translate-x-1/2
                    rounded-full
                    bg-green-300/15
                    blur-3xl"
            ></div>

            <div
                @click.outside="closeComplete()"
                class="bg-background
                    rounded-3xl
                    shadow-xl
                    w-full
                    max-w-2xl
                    max-h-[90vh]
                    flex
                    flex-col
                    overflow-hidden"
            >

                <!-- HEADER -->
                <div
                    class="flex items-center justify-between
                        px-6 py-5
                        border-b-2 border-border
                        shrink-0"
                >
                    <div class="flex items-center gap-3">
                        <div
                            class="flex justify-center items-center
                                w-10 h-10
                                rounded-2xl
                                border-2
                                border-green-600
                                bg-mark-completed
                                shadow-[0_10px_30px_rgba(34,197,94,.18)]"
                        >
                            <x-lucide-badge-check
                                class="w-5 h-5 text-green-600"
                            />
                        </div>

                        <div>

                            <h1
                                class="font-montserrat
                                    text-2xl
                                    font-bold
                                    text-text-primary"
                            >
                                Submit for Review
                            </h1>

                            <p
                                class="text-sm
                                    font-montserrat
                                    text-text-secondary"
                            >
                                Submit your completed work for leader verification.
                            </p>
                        </div>
                    </div>

                    <button
                        @click="closeComplete()"
                        class="w-12 h-12
                            rounded-full
                            hover:bg-surface
                            flex
                            items-center
                            justify-center
                            transition
                            cursor-pointer"
                    >
                        <x-lucide-x
                            class="w-5 h-5 text-text-primary"
                        />
                    </button>
                </div>

                <!-- BODY -->
                <div
                    class="flex-1
                        overflow-y-auto
                        px-6
                        py-5
                        space-y-5"
                >
                    <!-- Collaboration -->
                    <div
                        class="bg-surface
                            rounded-2xl
                            p-5"
                    >
                        <p
                            class="text-xs
                                font-semibold
                                uppercase
                                tracking-wider
                                text-text-secondary"
                        >
                            Task
                        </p>

                        <h2
                            class="mt-2
                                text-xl
                                font-bold
                                font-montserrat
                                text-text-primary"
                            x-text="collaboration.title"
                        ></h2>

                        <div class="flex gap-2 mt-4">
                            <span
                                class="px-3
                                    py-1
                                    rounded-full
                                    text-white
                                    text-xs
                                    font-semibold
                                    capitalize"
                                :class="
                                    collaboration.priority === 'high'
                                    ? 'bg-red-accent'
                                    : collaboration.priority === 'Medium'
                                    ? 'bg-yellow-accent'
                                    : 'bg-quartiary'
                                "
                                x-text="
                                    collaboration.priority === 'high'
                                    ? 'Priority: High'
                                    : collaboration.priority === 'Medium'
                                    ? 'Priority: Medium'
                                    : 'Priority: Low'
                                "
                            ></span>

                            <span
                                class="px-3
                                    py-1
                                    rounded-full
                                    bg-background
                                    text-text-primary
                                    text-xs"
                                x-text="
                                    collaboration.go_collab_reward + ' Credit Point'
                                "
                            ></span>
                        </div>
                    </div>

                    <!-- Team Submission -->
                    <div
                        class="bg-mark-completed
                            rounded-2xl
                            p-5
                            font-montserrat"
                    >
                        <div class="flex gap-4">
                            <div
                                class="w-10
                                    h-10
                                    rounded-xl
                                    bg-white/60
                                    flex
                                    items-center
                                    justify-center
                                    shrink-0"
                            >
                                <x-lucide-users
                                    class="w-5 h-5 text-green-700"
                                />
                            </div>

                            <div>
                                <h3
                                    class="font-semibold
                                        text-text-primary"
                                >
                                    Team Submission
                                </h3>

                                <p
                                    class="text-sm
                                        text-text-secondary
                                        mt-1
                                        leading-6"
                                >
                                    This submission represents the work completed by the
                                    collaborators. Once submitted, the task will enter
                                    <strong>Pending Review</strong> until the project
                                    leader approves or rejects it.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t-2 border-border"></div>

                    <!-- Upload -->
                    <div
                        class="bg-surface
                            rounded-2xl
                            p-5
                            font-montserrat
                            space-y-4"
                    >
                        <div class="flex items-center gap-2">
                            <x-lucide-image-plus
                                class="w-5 h-5 text-green-600"
                            />
                            <h3 class="font-semibold text-text-primary">
                                Proof of Completion
                            </h3>
                        </div>

                        <label
                            class="border-2
                                border-dashed
                                border-border
                                rounded-2xl
                                h-60
                                cursor-pointer
                                hover:border-primary
                                transition
                                flex
                                flex-col
                                justify-center
                                items-center
                                bg-background
                                overflow-hidden"
                        >
                            <template x-if="!submissionForm.preview">
                                <div class="flex flex-col items-center">
                                    <x-lucide-upload-cloud
                                        class="w-12 h-12 text-text-secondary"
                                    />
                                    <p class="mt-4 font-semibold text-text-primary">
                                        Click to upload an image
                                    </p>
                                    <p class="text-sm text-text-secondary">
                                        PNG • JPG • JPEG
                                    </p>
                                </div>
                            </template>
                            <template x-if="submissionForm.preview">

                                <img
                                    :src="submissionForm.preview"
                                    class="w-full h-full object-cover"
                                />
                            </template>
                            <input
                                type="file"
                                accept="image/*"
                                class="hidden"
                                @change="previewSubmissionImage"
                            >
                        </label>
                    </div>

                    <!-- Link -->
                    <div
                        class="bg-surface
                            rounded-2xl
                            p-5
                            font-montserrat
                            space-y-4"
                    >
                        <div class="flex items-center gap-2">
                            <x-lucide-link
                                class="w-5 h-5 text-green-600"
                            />
                            <h3 class="font-semibold text-text-primary">
                                Submission Link
                            </h3>
                        </div>

                        <input
                            type="url"
                            x-model="submissionForm.link"
                            placeholder="https://github.com/your-project"
                            class="w-full
                                rounded-2xl
                                bg-background
                                px-5
                                py-3
                                outline-none
                                text-text-primary
                                border
                                border-border
                                focus:border-primary"
                        >
                    </div>

                    <!-- Notes -->
                    <div
                        class="bg-surface
                            rounded-2xl
                            p-5
                            font-montserrat
                            space-y-4"
                    >
                        <div class="flex items-center gap-2">
                            <x-lucide-square-pen
                                class="w-5 h-5 text-green-600"
                            />
                            <h3 class="font-semibold text-text-primary">
                                Additional Notes
                            </h3>
                        </div>

                        <textarea
                            rows="5"
                            x-model="submissionForm.notes"
                            placeholder="Describe what has been completed..."
                            class="w-full
                                rounded-2xl
                                bg-background
                                px-5
                                py-4
                                resize-none
                                text-text-primary
                                border
                                border-border
                                focus:border-primary"
                        ></textarea>
                    </div>
                </div>

                <!-- FOOTER -->
                <div
                    class="flex
                        justify-end
                        gap-3
                        px-6
                        py-5
                        border-t-2
                        border-border
                        font-montserrat"
                >

                    <button
                        @click="closeComplete()"
                        class="px-6
                            py-3
                            rounded-2xl
                            border-2
                            border-border
                            hover:bg-surface
                            transition
                            text-text-primary"
                    >
                        Cancel
                    </button>

                    <button
                        @click="submitTask()"
                        :disabled="!submissionForm.image && !submissionForm.link"
                        :class="(!submissionForm.image && !submissionForm.link)
                            ? 'opacity-50 cursor-not-allowed'
                            : ''"
                        class="px-7
                            py-3
                            rounded-2xl
                            bg-quartiary
                            hover:bg-quartiary-hover
                            text-white
                            transition"
                    >
                        <div class="flex items-center gap-2">
                            <x-lucide-send class="w-4 h-4"/>
                            <span>
                                Submit for Review
                            </span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        {{-- Show Submission Detail Modal --}}
        <div
            x-show="showSubmissionModal"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-6"
        >
            {{-- Green Accent --}}
            <div
                class="absolute -top-24 left-3/4
                    h-64 w-86
                    -translate-x-1/2
                    rounded-full
                    bg-green-300/15
                    blur-3xl"
            ></div>

            <div
                @click.outside="closeSubmission()"
                class="bg-background
                    rounded-3xl
                    shadow-xl
                    w-full max-w-2xl
                    max-h-[90vh]
                    flex flex-col
                    overflow-hidden"
            >
                <!-- HEADER -->
                <div
                    class="flex items-center justify-between
                        px-6 py-5
                        border-b-2 border-border
                        shrink-0"
                >
                    <div class="flex items-center gap-3">
                        <div
                            class="flex justify-center items-center
                                w-10 h-10
                                rounded-2xl
                                border-2
                                border-green-600
                                bg-mark-completed
                                shadow-[0_10px_30px_rgba(34,197,94,.18)]"
                        >
                            <x-lucide-view
                                class="w-5 h-5 text-green-600"
                            />
                        </div>

                        <div>
                            <h2
                                class="text-2xl
                                    font-bold
                                    font-montserrat
                                    text-text-primary"
                            >
                                Submission Details
                            </h2>
                            <p
                                class="text-sm
                                    text-text-secondary
                                    font-montserrat"
                            >
                                Review the collaborator's submitted work.
                            </p>
                        </div>
                    </div>

                    <button
                        @click="closeSubmission()"
                        class="w-11 h-11
                            rounded-full
                            hover:bg-surface
                            transition
                            z-101
                            text-text-primary
                            hover:rotate-90
                            flex
                            items-center
                            justify-center
                            cursor-pointer"
                    >
                        <x-lucide-x class="w-5 h-5"/>
                    </button>
                </div>

                <!-- BODY -->
                <div
                    class="flex-1
                        overflow-y-auto
                        px-6
                        py-5
                        font-montserrat
                        space-y-6"
                >
                    <!-- Task -->
                    <div>
                        <p
                            class="text-xs
                                font-semibold
                                uppercase
                                text-text-secondary"
                        >
                            Task
                        </p>

                        <div
                            class="mt-2
                                bg-surface
                                rounded-2xl
                                px-5
                                py-4"
                        >

                            <h3
                                class="font-semibold
                                    text-lg
                                    text-text-primary"
                                x-text="submission.title"
                            ></h3>
                        </div>
                    </div>

                    <!-- Submission Info -->
                    <div class="grid md:grid-cols-2 gap-4">

                        <!-- Submitter -->
                        <div
                            class="bg-surface
                                rounded-2xl
                                p-5"
                        >
                            <div class="flex items-center gap-2 mb-3">
                                <x-lucide-user
                                    class="w-5 h-5 text-primary"
                                />
                                <p class="font-semibold text-text-primary">
                                    Submitted By
                                </p>
                            </div>

                            <div
                                class="flex items-center gap-3
                                    bg-background
                                    rounded-xl
                                    p-2"
                            >
                                <img
                                    :src="submission.submitter_avatar || '/images/default-avatar.png'"
                                    class="w-8 h-8 rounded-full object-cover"
                                >
                                <p
                                    class="text-text-secondary"
                                    x-text="submission.submitter"
                                ></p>
                            </div>
                        </div>

                        <!-- Submitted Date -->
                        <div
                            class="bg-surface
                                rounded-2xl
                                p-5"
                        >
                            <div class="flex items-center gap-2 mb-3">
                                <x-lucide-calendar-days
                                    class="w-5 h-5 text-primary"
                                />
                                <p class="font-semibold text-text-primary">
                                    Submitted At
                                </p>
                            </div>
                            <div
                                class="flex items-center
                                    bg-background
                                    rounded-xl
                                    py-2
                                    px-4
                                    min-h-12"
                            >
                                <p
                                    class="text-text-secondary"
                                    x-text="submission.submitted_at"
                                ></p>
                            </div>
                        </div>
                    </div>

                    <!-- Proof Image -->
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <x-lucide-image
                                class="w-5 h-5 text-primary"
                            />
                            <p class="font-semibold text-text-primary">
                                Proof Image
                            </p>
                        </div>

                        <template x-if="submission.proof_image">
                            <img
                                :src="'/storage/' + submission.proof_image"
                                class="rounded-3xl
                                    w-full
                                    max-h-96
                                    object-cover
                                    border
                                    border-border"
                            >
                        </template>

                        <template x-if="!submission.proof_image">
                            <div
                                class="rounded-2xl
                                    bg-surface
                                    py-10
                                    text-center
                                    text-text-secondary"
                            >
                                No proof image provided.
                            </div>
                        </template>
                    </div>

                    <!-- Submission Link -->
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <x-lucide-link
                                class="w-5 h-5 text-primary"
                            />
                            <p class="font-semibold text-text-primary">
                                Submission Link
                            </p>
                        </div>

                        <template x-if="submission.proof_link">
                            <a
                                :href="submission.proof_link"
                                target="_blank"
                                class="block
                                    rounded-2xl
                                    bg-surface
                                    px-5
                                    py-4
                                    text-primary
                                    hover:underline
                                    break-all"
                                x-text="submission.proof_link"
                            ></a>
                        </template>

                        <template x-if="!submission.proof_link">
                            <div
                                class="rounded-2xl
                                    bg-surface
                                    py-6
                                    text-center
                                    text-text-secondary"
                            >
                                No submission link.
                            </div>
                        </template>
                    </div>

                    <!-- Notes -->
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <x-lucide-notebook-pen
                                class="w-5 h-5 text-primary"
                            />
                            <p class="font-semibold text-text-primary">
                                Notes
                            </p>
                        </div>

                        <div
                            class="rounded-2xl
                                bg-surface
                                px-5
                                py-4
                                min-h-28"
                        >
                            <p
                                class="leading-7
                                    whitespace-pre-line
                                    text-text-secondary"
                                x-text="submission.notes || 'No notes provided.'"
                            ></p>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div
                    class="border-t-2
                        border-border
                        px-6
                        py-5
                        font-montserrat
                        flex
                        justify-end
                        gap-3"
                >

                    <!-- Leader Actions -->
                    <template x-if="reviewMode">
                        <div class="flex gap-3">
                            <button
                                @click="rejectSubmission()"
                                class="px-6
                                    py-2
                                    rounded-2xl
                                    bg-red-accent
                                    hover:bg-red-700
                                    text-white
                                    transition
                                    cursor-pointer"
                            >
                                Reject
                            </button>
                            <button
                                @click="approveSubmission()"
                                class="px-6
                                    py-2
                                    rounded-2xl
                                    bg-quartiary
                                    hover:bg-emerald-700
                                    text-white
                                    transition
                                    cursor-pointer"
                            >
                                Approve
                            </button>
                        </div>
                    </template>

                    <button
                        @click="closeSubmission()"
                        class="px-6
                            py-2
                            rounded-2xl
                            border-2
                            border-border
                            hover:bg-surface
                            transition
                            text-text-primary
                            cursor-pointer"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
