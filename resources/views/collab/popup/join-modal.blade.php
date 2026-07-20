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

        <div class="p-6 space-y-4">

            <h3
                id="joinTitle"
                class="text-xl font-bold">

            </h3>

            <p
                id="joinDescription">

            </p>

            <p>

                Deadline :

                <span id="joinDeadline"></span>

            </p>

            <p>

                Leader :

                <span id="joinLeader"></span>

            </p>

            <p>

                Members :

                <span id="joinMembers"></span>

            </p>

            <p>

                Reward :

                <span id="joinReward"></span>

            </p>

        </div>

        <div class="border-t p-6 flex justify-end">

            <form
                id="joinForm"
                method="POST">

                @csrf

                <button
                    class="bg-primary text-white rounded-full px-6 py-2">

                    Join Collaboration

                </button>

            </form>

        </div>

    </div>

</div>