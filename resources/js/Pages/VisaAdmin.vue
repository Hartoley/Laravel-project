<template>
    <div class="min-h-screen flex flex-col bg-gray-50">
        <Header />

        <main class="flex-1 p-6 mt-[12vh]">
            <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">
                    Visa Applications Management
                </h1>

                <div class="overflow-x-auto">
                    <table
                        class="w-full text-left border-collapse border border-gray-300 rounded-lg"
                    >
                        <thead
                            class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white"
                        >
                            <tr>
                                <th
                                    class="py-3 px-4 text-sm uppercase font-semibold"
                                >
                                    Email
                                </th>
                                <th
                                    class="py-3 px-4 text-sm uppercase font-semibold"
                                >
                                    Full Name
                                </th>
                                <th
                                    class="py-3 px-4 text-sm uppercase font-semibold"
                                >
                                    Residence
                                </th>
                                <th
                                    class="py-3 px-4 text-sm uppercase font-semibold"
                                >
                                    Status
                                </th>
                                <th
                                    class="py-3 px-4 text-sm uppercase font-semibold"
                                >
                                    Actions
                                </th>
                                <th
                                    class="py-3 px-4 text-sm uppercase font-semibold"
                                >
                                    Companions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in visApplicants"
                                :key="index"
                                class="bg-white border-b hover:bg-gray-100"
                            >
                                <td class="py-3 px-4 text-gray-700">
                                    {{ item.email }}
                                </td>
                                <td class="py-3 px-4 text-gray-700">
                                    {{ item.first_name }} {{ item.surname }}
                                </td>
                                <td class="py-3 px-4 text-gray-700">
                                    {{ item.residence }}
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="py-1 px-3 rounded-full text-xs font-semibold capitalize"
                                        :class="{
                                            'bg-green-100 text-green-600':
                                                item.status === 'Accepted',
                                            'bg-yellow-100 text-yellow-600':
                                                item.status === 'Pending',
                                            'bg-red-100 text-red-600':
                                                item.status === 'Rejected',
                                        }"
                                    >
                                        {{ item.status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 flex space-x-2">
                                    <button
                                        v-if="item.status === 'Pending'"
                                        class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded text-sm"
                                        @click="accept(item.id)"
                                    >
                                        Accept
                                    </button>
                                    <button
                                        v-if="item.status === 'Pending'"
                                        class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-sm"
                                        @click="reject(item.id)"
                                    >
                                        Reject
                                    </button>
                                    <span v-else class="text-gray-500 italic">
                                        No actions available
                                    </span>
                                </td>
                                <td
                                    class="py-3 px-4"
                                    v-if="item.travel_companion.length > 0"
                                >
                                    <button
                                        class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded text-sm"
                                        @click="partner(item.transaction_id)"
                                    >
                                        View Companions
                                    </button>
                                </td>
                                <td v-else class="mb-4">
                                    No companions added.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div
                    v-if="showCompanion"
                    class="mt-8 bg-gray-100 p-4 rounded-lg shadow-lg"
                >
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        Companions for Application
                    </h2>
                    <div class="overflow-x-auto">
                        <table
                            class="w-full text-left border-collapse border border-gray-300 rounded-lg"
                        >
                            <thead
                                class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white"
                            >
                                <tr>
                                    <th
                                        class="py-3 px-4 text-sm uppercase font-semibold"
                                    >
                                        Name
                                    </th>
                                    <th
                                        class="py-3 px-4 text-sm uppercase font-semibold"
                                    >
                                        Relationship
                                    </th>
                                    <th
                                        class="py-3 px-4 text-sm uppercase font-semibold"
                                    >
                                        Status
                                    </th>
                                    <th
                                        class="py-3 px-4 text-sm uppercase font-semibold"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(companion, index) in companions"
                                    :key="index"
                                    class="bg-white border-b hover:bg-gray-100"
                                >
                                    <td class="py-3 px-4 text-gray-700">
                                        {{ companion.name }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">
                                        {{ companion.relationship }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <span
                                            class="py-1 px-3 rounded-full text-xs font-semibold capitalize"
                                            :class="{
                                                'bg-yellow-100 text-yellow-600':
                                                    companion.status ===
                                                    'Pending',
                                                'bg-green-100 text-green-600':
                                                    companion.status ===
                                                    'Accepted',
                                                'bg-red-100 text-red-600':
                                                    companion.status ===
                                                    'Rejected',
                                            }"
                                        >
                                            {{ companion.status }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 flex space-x-2">
                                        <button
                                            v-if="
                                                companion.status === 'Pending'
                                            "
                                            class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded text-sm"
                                            @click="
                                                acceptCompanion(companion.id)
                                            "
                                        >
                                            Accept
                                        </button>
                                        <button
                                            v-if="
                                                companion.status === 'Pending'
                                            "
                                            class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-sm"
                                            @click="
                                                rejectCompanion(companion.id)
                                            "
                                        >
                                            Reject
                                        </button>
                                        <span
                                            v-else
                                            class="text-gray-500 italic"
                                        >
                                            No actions available
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <Footer />
    </div>
</template>

<script>
import axios from "axios";
import Header from "./Header.vue";
import Footer from "./Footer.vue";

export default {
    components: { Header, Footer },

    data() {
        return {
            visApplicants: [],
            companions: [],
            showCompanion: false,
            userTours: [],
            currentTours: [],
            allTours: [],
        };
    },
    mounted() {
        this.fetchApplications();
        this.fetchAllTours();
        this.fetching();
    },
    methods: {
        fetchApplications() {
            axios
                .get(route("all.fetch_application"))
                .then((res) => {
                    // console.log(res);
                    this.visApplicants = res.data.applications;
                    // console.log(this.visApplicants);
                    status = this.visApplicants.status;
                })
                .catch((err) => {
                    console.log(err);
                });
        },

        fetchAllTours() {
            axios
                .get(route("fetchMyuser.tour"))
                .then((res) => {
                    console.log(res);
                    this.userTours = res.data.tours;
                    console.log("This is my user tours", this.userTours);
                })
                .catch((err) => {
                    console.log(err);
                });
        },

        accept(id) {
            console.log(id);
            axios
                .post(route("accept.applications"), { id: id })
                .then((response) => {
                    alert(response.data.message);
                    this.fetchApplications();
                })
                .catch((error) => {
                    console.error("Error accepting application:", error);
                    alert("Failed to accept application.");
                });
        },

        fetching() {
            axios
                .get(route("tour.fetch"))
                .then((res) => {
                    this.allTours = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },

        reject(id) {
            console.log(id);
            axios
                .post(route("reject.applications"), { id: id })
                .then((response) => {
                    alert(response.data.message);
                    this.fetchApplications();
                })
                .catch((error) => {
                    console.error("Error accepting application:", error);
                    alert("Failed to accept application.");
                });
        },

        rejectCompanion(id) {
            console.log(id);
            axios
                .post(route("reject.companions"), { id: id })
                .then((response) => {
                    alert(response.data.message);
                    this.fetchApplications();
                    this.partner();
                })
                .catch((error) => {
                    console.error("Error accepting application:", error);
                    alert("Failed to accept application.");
                });
        },

        acceptCompanion(id) {
            console.log(id);
            axios
                .post(route("accept.companions"), { id: id })
                .then((response) => {
                    alert(response.data.message);
                    this.fetchApplications();
                })
                .catch((error) => {
                    console.error("Error accepting application:", error);
                    alert("Failed to accept application.");
                });
        },

        partner(id) {
            console.log(id);
            axios
                .post(route("user.fetch_companion"), { id: id })
                .then((response) => {
                    if (Array.isArray(response.data.companions)) {
                        this.companions = [
                            ...this.companions,
                            ...response.data.companions,
                        ];
                        console.log(this.companions);
                        this.showCompanion = true;
                    } else {
                        alert("No companions found for this ID.");
                    }
                })
                .catch((error) => {
                    console.log(error);
                    alert("Failed to fetch companions.");
                });
        },
    },
};
</script>
