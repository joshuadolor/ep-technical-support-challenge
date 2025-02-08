<template>
    <div>
        <h1 class="mb-6">{{ clientName }}'s Journal -> Add New Journal</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Notes</label>
                <input
                    type="text"
                    id="name"
                    class="form-control"
                    v-model="journal.notes"
                />
            </div>

            <div class="text-right">
                <a
                    :href="`/clients/${client.id}/journals`"
                    class="btn btn-default"
                    >Cancel</a
                >
                <button @click="storeClient" class="btn btn-primary">
                    Create
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ClientForm",

    data() {
        return {
            journal: {
                notes: ""
            }
        };
    },

    props: ["client"],

    computed: {
        clientName() {
            return this.client.name;
        }
    },

    methods: {
        storeClient() {
            axios
                .post(`/clients/${this.client.id}/journals`, this.journal)
                .then(data => {
                    window.location.href = data.data.url;
                });
        }
    }
};
</script>
