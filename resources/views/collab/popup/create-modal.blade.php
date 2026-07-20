<!-- Create Collaboration Modal -->
<div
    id="createCollabModal"
    class="hidden fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm">

    <!-- Modal -->
    <div class="relative w-full max-w-2xl mx-4 bg-background rounded-3xl shadow-2xl">

        <!-- Header -->
        <div class="flex items-center justify-between px-8 py-6 border-b border-gray-200">

            <div>
                <h2 class="text-3xl font-bold text-text-primary font-montserrat">
                    Create Collaboration
                </h2>

                <p class="text-text-secondary text-sm mt-1">
                    Create a new collaboration task.
                </p>
            </div>

            <button
                type="button"
                onclick="closeCreateModal()"
                class="w-10 h-10 rounded-full hover:bg-gray-100 transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 mx-auto"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"/>

                </svg>

            </button>

        </div>

        <!-- Form -->
        <form
            action="{{ route('collab.create') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="p-8 space-y-5">

                <!-- Task Title -->
                <div>

                    <label
                        class="block mb-2 text-sm font-semibold text-text-primary">

                        Task Title

                    </label>

                    <input
                        type="text"
                        name="title"
                        required
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary"
                        placeholder="Overall Home Page Concept">

                </div>

                <!-- Description -->

                <div>

                    <label
                        class="block mb-2 text-sm font-semibold text-text-primary">

                        Description

                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        required
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 resize-none focus:outline-none focus:ring-2 focus:ring-primary"
                        placeholder="Describe your collaboration..."></textarea>

                </div>

                <div class="mt-5">

                    <label class="block text-sm font-semibold mb-2">
                        Cover Image
                    </label>
                
                    <div class="flex items-center gap-4">
                    
                        <img
                            id="coverPreview"
                            src="{{ asset('images/project-cover.jpg') }}"
                            class="w-32 h-20 rounded-lg object-cover border">
                    
                        <input
                            type="file"
                            name="cover_image"
                            id="coverImage"
                            accept="image/*"
                            class="block w-full text-sm">
                    
                    </div>
                
                </div>

                <!-- Assign PIC -->

                <div>

                    <label
                        class="block mb-2 text-sm font-semibold text-text-primary">

                        Assign PIC

                    </label>

                    <input
                        type="text"
                        value="{{ auth()->user()->name }}"
                        readonly
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 bg-gray-100">

                </div>

                <!-- Deadline + Priority -->

                <div class="grid grid-cols-2 gap-5">

                    {{-- Deadline --}}
                    <div>
                    
                        <label class="block mb-2 text-sm font-semibold">
                            Deadline
                        </label>
                    
                        <input
                            type="date"
                            name="deadline"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3">
                    
                    </div>
                
                    {{-- Priority --}}
                    <div>
                    
                        <label class="block mb-2 text-sm font-semibold">
                            Priority
                        </label>
                    
                        <select
                            name="priority"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3">
                    
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                    
                        </select>
                    
                    </div>
                
                    {{-- Reward --}}
                    <div>
                    
                        <label class="block mb-2 text-sm font-semibold">
                            Reward (XP)
                        </label>
                    
                        <input
                            type="number"
                            name="reward"
                            value="100"
                            min="0"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3">
                    
                    </div>
                
                    {{-- Capacity --}}
                    <div>
                    
                        <label class="block mb-2 text-sm font-semibold">
                            Maximum Members
                        </label>
                    
                        <input
                            type="number"
                            name="capacity"
                            value="5"
                            min="2"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3">
                    
                    </div>
                
                </div>

            </div>

            <!-- Footer -->

            <div class="flex justify-end gap-4 px-8 py-6 border-t border-gray-200">

                <button
                    type="button"
                    onclick="closeCreateModal()"
                    class="px-6 py-2 rounded-full border border-gray-300 hover:bg-gray-100">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="px-6 py-2 rounded-full bg-primary text-white hover:bg-primary/90">

                    Go Collab!

                </button>

            </div>

        </form>

    </div>

</div>