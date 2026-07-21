<div
    id="joinCollabModal"
    class="hidden fixed inset-0 z-[999] bg-black/50 backdrop-blur-sm flex items-center justify-center">

    <div class="bg-white rounded-3xl w-full max-w-2xl mx-4">

        <div class="flex justify-between items-center border-b p-6">

            <h2 class="text-2xl font-bold">
                Collaboration Details
            </h2>

            <button
                onclick="closeJoinModal()"
                class="text-2xl">

                &times;

            </button>

        </div>

        <div class="p-8 space-y-6">
        
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Collaboration Title
                </label>
            
                <div
                    id="joinTitle"
                    class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 font-medium">
                </div>
            </div>
        
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Description
                </label>
            
                <div
                    id="joinDescription"
                    class="w-full min-h-[110px] rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 whitespace-pre-line">
                </div>
            </div>
        
            <div class="grid grid-cols-2 gap-5">
            
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Deadline
                    </label>
                
                    <div
                        id="joinDeadline"
                        class="rounded-xl border border-gray-300 bg-gray-50 px-4 py-3">
                    </div>
                </div>
            
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Members
                    </label>
                
                    <div
                        id="joinMembers"
                        class="rounded-xl border border-gray-300 bg-gray-50 px-4 py-3">
                    </div>
                </div>
            
            </div>
        
            <div class="grid grid-cols-2 gap-5">
            
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Leader
                    </label>
                
                    <div
                        id="joinLeader"
                        class="rounded-xl border border-gray-300 bg-gray-50 px-4 py-3">
                    </div>
                </div>
            
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Reward
                    </label>
                
                    <div
                        id="joinReward"
                        class="rounded-xl border border-gray-300 bg-gray-50 px-4 py-3">
                    </div>
                </div>
            
            </div>
        
        </div>
        <div class="border-t p-6 flex justify-end">

            <form
                id="joinForm"
                method="POST">
                
                @csrf
                
                <button
                    type="submit"
                    class="bg-primary hover:bg-primary/90 transition
                           text-white font-semibold
                           rounded-full px-8 py-3">
                
                    Join Collaboration
                
                </button>
            
            </form>
        
        </div>

    </div>

</div>