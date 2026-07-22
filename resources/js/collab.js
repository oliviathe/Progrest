window.collabModal = function () {
    return {

        show: false,
        showCompleteModal: false,
        showSubmissionModal: false,
        reviewMode: false,

        collaboration: {
            id: null,
            title: '',
            description: '',
            image: '',
            priority: '',
            status: '',
            deadline: '',

            project: '',
            project_icon: '',

            leader: '',
            leader_avatar: '',

            collaborators: [],

            go_collab_description: '',
            go_collab_reward: 0,
            go_collab_limit: 0,
        },

        submission: {
            id: null,
            task_id: null,

            title: '',
            submitter: '',
            submitter_avatar: '',
            submitted_at: '',

            proof_image: '',
            proof_link: '',
            notes: '',
            status: '',
        },

        submissionForm: {
            image: null,
            preview: '',
            link: '',
            notes: '',
        },

        /*
        |--------------------------------------------------------------------------
        | Collaboration Details
        |--------------------------------------------------------------------------
        */

        open(collaboration) {

            this.collaboration = structuredClone(collaboration);

            this.show = true;
        },

        close() {

            this.show = false;

            this.showCompleteModal = false;
            this.showSubmissionModal = false;
            this.reviewMode = false;

            this.resetSubmission();

            this.submission = {
                id: null,
                task_id: null,

                title: '',
                submitter: '',
                submitter_avatar: '',
                submitted_at: '',

                proof_image: '',
                proof_link: '',
                notes: '',
                status: '',
            };

            this.collaboration = {
                id: null,
                title: '',
                description: '',
                image: '',
                priority: '',
                status: '',
                deadline: '',

                project: '',
                project_icon: '',

                leader: '',
                leader_avatar: '',

                collaborators: [],

                go_collab_description: '',
                go_collab_reward: 0,
                go_collab_limit: 0,
            };
        },

        /*
        |--------------------------------------------------------------------------
        | Submit Completion
        |--------------------------------------------------------------------------
        */

        openComplete(collaboration) {

            this.collaboration = structuredClone(collaboration);

            this.resetSubmission();

            this.show = false;
            this.showCompleteModal = true;
        },

        closeComplete() {

            this.resetSubmission();

            this.showCompleteModal = false;
        },

        previewSubmissionImage(event) {

            const file = event.target.files[0];

            if (!file) return;

            this.submissionForm.image = file;
            this.submissionForm.preview =
                URL.createObjectURL(file);
        },

        resetSubmission() {

            if (this.submissionForm.preview) {
                URL.revokeObjectURL(
                    this.submissionForm.preview
                );
            }

            this.submissionForm = {
                image: null,
                preview: '',
                link: '',
                notes: '',
            };
        },

        async submitTask() {

            try {

                const formData = new FormData();

                if (this.submissionForm.image) {
                    formData.append(
                        'proof_image',
                        this.submissionForm.image
                    );
                }

                formData.append(
                    'proof_link',
                    this.submissionForm.link
                );

                formData.append(
                    'notes',
                    this.submissionForm.notes
                );

                const response = await fetch(
                    `/tasks/${this.collaboration.id}/submit`,
                    {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN':
                                document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: formData,
                    }
                );

                const data = await response.json();

                if (!response.ok) {

                    console.error(data);

                    alert('Unable to submit task.');

                    return;
                }

                this.close();

                location.reload();

            } catch (error) {

                console.error(error);

                alert('Unable to submit task.');
            }
        },

        /*
        |--------------------------------------------------------------------------
        | Submission Viewer
        |--------------------------------------------------------------------------
        */

        openSubmission(submission) {

            this.reviewMode = false;

            this.submission = structuredClone(submission);

            this.show = false;
            this.showSubmissionModal = true;
        },

        openReview(submission) {

            this.reviewMode = true;

            this.submission = structuredClone(submission);

            this.show = false;
            this.showSubmissionModal = true;
        },

        closeSubmission() {

            this.submission = {
                id: null,
                task_id: null,

                title: '',
                submitter: '',
                submitter_avatar: '',
                submitted_at: '',

                proof_image: '',
                proof_link: '',
                notes: '',
                status: '',
            };

            this.reviewMode = false;

            this.showSubmissionModal = false;
        },

        /*
        |--------------------------------------------------------------------------
        | Review Submission
        |--------------------------------------------------------------------------
        */

        async approveSubmission() {

            try {

                const response = await fetch(
                    `/submissions/${this.submission.id}/approve`,
                    {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN':
                                document.querySelector('meta[name="csrf-token"]').content, 
                            'Accept': 'application/json',
                        },
                    }
                );

                const data = await response.json();

                if (!response.ok) {

                    console.error(data);

                    alert('Unable to approve submission.');

                    return;
                }

                this.closeSubmission();

                location.reload();

            } catch (error) {

                console.error(error);

                alert('Unable to approve submission.');
            }
        },

        async rejectSubmission() {

            try {

                const response = await fetch(
                    `/submissions/${this.submission.id}/reject`,
                    {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN':
                                document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    }
                );

                const data = await response.json();

                if (!response.ok) {

                    console.error(data);

                    alert('Unable to reject submission.');

                    return;
                }

                this.closeSubmission();

                location.reload();

            } catch (error) {

                console.error(error);

                alert('Unable to reject submission.');
            }
        },
    }
}