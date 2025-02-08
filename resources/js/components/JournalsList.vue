<template>
    <div>
        <h1>
            {{ clientName }}'s Journal
            <a
                :href="`/clients/${client.id}/journals/create`"
                class="float-right btn btn-primary"
                >+ New Journal</a
            >
        </h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Date Created</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="journal in journals" :key="journal.id">
                    <td>{{ journal.created_at }}</td>
                    <td>{{ journal.notes }}</td>
                    <td>
                        <button
                            class="btn btn-danger btn-sm"
                            @click="deleteJournal(journal)"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "JournalsList",

    props: ["journals", "client"],

    methods: {
        async deleteJournal(journal) {
            try {
                await axios.delete(
                    `/clients/${this.client.id}/journals/${journal.id}`
                );
                this.journals = this.journals.filter(j => j.id !== journal.id);
                window.alert("Journal deleted");
            } catch (error) {
                window.alert("An error occurred while deleting the client");
            }
        }
    },
    computed: {
        clientName() {
            return this.client.name;
        }
    }
};
</script>
