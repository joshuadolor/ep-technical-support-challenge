<template>
    <div>
        <h1 class="mb-6">Clients -> {{ client.name }}</h1>

        <div class="flex">
            <div class="w-1/3 mr-5">
                <div class="w-full bg-white rounded p-4">
                    <h2>Client Info</h2>
                    <table>
                        <tbody>
                            <tr>
                                <th class="text-gray-600 pr-3">Name</th>
                                <td>{{ client.name }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Email</th>
                                <td>{{ client.email }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Phone</th>
                                <td>{{ client.phone }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Address</th>
                                <td>
                                    {{ client.address }}<br />{{
                                        client.postcode + " " + client.city
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-2/3">
                <div>
                    <button
                        class="btn"
                        :class="{
                            'btn-primary': currentTab == 'bookings',
                            'btn-default': currentTab != 'bookings'
                        }"
                        @click="switchTab('bookings')"
                    >
                        Bookings
                    </button>
                    <button
                        class="btn"
                        :class="{
                            'btn-primary': currentTab == 'journals',
                            'btn-default': currentTab != 'journals'
                        }"
                        @click="switchTab('journals')"
                    >
                        Journals
                    </button>
                </div>

                <!-- Bookings -->
                <div
                    class="bg-white rounded p-4"
                    v-if="currentTab == 'bookings'"
                >
                    <h3 class="mb-3">List of client bookings</h3>

                    <div class="mb-3">
                        <button
                            class="btn mr-2"
                            :class="{
                                'btn-primary': bookingFilter === 'active',
                                'btn-default': bookingFilter !== 'active'
                            }"
                            @click="bookingFilter = 'active'"
                        >
                            Active Bookings
                        </button>
                        <button
                            class="btn"
                            :class="{
                                'btn-primary': bookingFilter === 'past',
                                'btn-default': bookingFilter !== 'past'
                            }"
                            @click="bookingFilter = 'past'"
                        >
                            Past Bookings
                        </button>
                    </div>

                    <template v-if="bookings && bookings.length > 0">
                        <table>
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="booking in bookings"
                                    :key="booking.id"
                                    class="border-b border-gray-200"
                                >
                                    <td>
                                        {{ booking.startDate }}
                                        <div>to</div>
                                        {{ booking.endDate }}
                                    </td>
                                    <td>{{ booking.notes }}</td>
                                    <td>
                                        <button
                                            class="btn btn-danger btn-sm"
                                            @click="deleteBooking(booking)"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </template>

                    <template v-else>
                        <p class="text-center">The client has no bookings.</p>
                    </template>
                </div>

                <!-- Journals -->
                <div
                    class="bg-white rounded p-4"
                    v-if="currentTab == 'journals'"
                >
                    <h3 class="mb-3">List of client journals</h3>

                    <template v-if="journals && journals.length > 0">
                        <table>
                            <thead>
                                <tr>
                                    <th>Created At</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="journal in journals"
                                    :key="journal.id"
                                >
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
                    </template>

                    <template v-else>
                        <p class="text-center">The client has no journals.</p>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Booking from "../model/Booking";

export default {
    name: "ClientShow",

    props: ["client"],

    data() {
        return {
            currentTab: "bookings",
            journals: [],
            bookings: [],
            bookingFilter: "active"
        };
    },

    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },

        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        },

        async deleteJournal(journal) {
            try {
                await axios.delete(
                    `/clients/${this.client.id}/journals/${journal.id}`
                );

                this.journals = this.journals.filter(j => j.id != journal.id);

                window.alert("Journal deleted");
            } catch (error) {
                window.alert("An error occurred while deleting the journal");
            }
        },
        async fetchBookings() {
            const start = this.bookingFilter == "active" ? null : new Date();
            const end = this.bookingFilter == "past" ? null : new Date();

            const response = await axios.get(
                `/clients/${this.client.id}/bookings`,
                {
                    params: {
                        start,
                        end
                    }
                }
            );
            this.bookings =
                response?.data.map(booking => new Booking(booking)) || [];
        }
    },

    watch: {
        client: {
            deep: true,
            handler(newClient) {
                this.journals = newClient.journals;
            },
            immediate: true
        },
        currentTab: {
            immediate: true,
            handler(newTab) {
                if (newTab == "bookings") {
                    this.fetchBookings(this.bookingFilter);
                }
            }
        },
        bookingFilter: {
            handler(newFilter) {
                this.fetchBookings(newFilter);
            }
        }
    }
};
</script>
