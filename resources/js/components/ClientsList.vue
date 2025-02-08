<template>
    <div>
        <h1>
            Clients
            <a href="/clients/create" class="float-right btn btn-primary"
                >+ New Client</a
            >
        </h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Number of Bookings</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="client in clients" :key="client.id">
                    <td>{{ client.name }}</td>
                    <td>{{ client.email }}</td>
                    <td>{{ client.phone }}</td>
                    <td>{{ client.bookings_count }}</td>
                    <td>
                        <a
                            class="btn btn-primary btn-sm"
                            :href="`/clients/${client.id}`"
                            >View</a
                        >
                        <a
                            class="btn btn-info btn-sm"
                            :href="`/clients/${client.id}/journals`"
                            >View Journals</a
                        >
                        <button
                            class="btn btn-danger btn-sm"
                            @click="deleteClient(client)"
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
    name: "ClientsList",

    props: ["clients"],

    methods: {
        async deleteClient(client) {
            try {
                await axios.delete(`/clients/${client.id}`);
                this.clients = this.clients.filter(c => c.id !== client.id);
                window.alert("Client deleted");
            } catch (error) {
                window.alert("An error occurred while deleting the client");
            }
        }
    }
};
</script>
