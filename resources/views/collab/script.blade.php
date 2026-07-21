<script>

function openJoinModal(
    id,
    title,
    description,
    deadline,
    leader,
    members,
    reward
){
    document.getElementById("joinTitle").innerText = title;
    document.getElementById("joinDescription").innerText = description;
    document.getElementById("joinDeadline").innerText = deadline || "-";
    document.getElementById("joinLeader").innerText = leader;
    document.getElementById("joinMembers").innerText = members;
    document.getElementById("joinReward").innerText = reward;

    document.getElementById("joinForm").action =
        "/collab/" + id + "/join";

    document.getElementById("joinCollabModal")
        .classList.remove("hidden");
}

function closeJoinModal() {
    document.getElementById("joinCollabModal")
        .classList.add("hidden");
}

window.addEventListener("click", function(e){

    const joinModal = document.getElementById("joinCollabModal");

    if(e.target === joinModal){
        closeJoinModal();
    }

});

const searchInput =
    document.getElementById("searchCollab");

const filterInput =
    document.getElementById("filterCollab");

function filterCards() {

    const keyword =
        searchInput.value.toLowerCase();

    const filter =
        filterInput.value;

    document
        .querySelectorAll(".collab-card")
        .forEach(card => {

            const searchable =
                card.dataset.title +
                " " +
                card.dataset.description +
                " " +
                card.dataset.leader;

            let visible =
                searchable.includes(keyword);

            if (filter === "available") {

                visible =
                    visible &&
                    card.dataset.full === "false";

            }

            if (filter === "joined") {

                visible =
                    visible &&
                    card.dataset.joined === "true";

            }

            if (filter === "owner") {

                visible =
                    visible &&
                    card.dataset.owner === "true";

            }

            if (filter === "full") {

                visible =
                    visible &&
                    card.dataset.full === "true";

            }

            card.style.display =
                visible
                ? ""
                : "none";

        });

}

if (searchInput && filterInput) {

    searchInput.addEventListener("keyup", filterCards);

    filterInput.addEventListener("change", filterCards);

}

</script>