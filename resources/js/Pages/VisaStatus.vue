<template>
    <div class="min-h-screen flex flex-col bg-gray-50">
        <Header />

        <div
            class="min-h-[100vh] flex-1 flex items-center justify-center relative"
        >
            <div v-if="loading" class="flex flex-col items-center space-y-4">
                <div
                    class="w-16 h-16 border-4 border-blue-500 border-dotted rounded-full animate-spin"
                ></div>
                <p class="text-gray-500 font-medium">
                    Loading your visa status...
                </p>
            </div>

            <div v-else class="w-full max-w-5xl px-4 py-10 overflow-y-auto">
                <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">
                    Visa Application Status
                </h1>

                <div
                    v-if="visApplicants.length > 0"
                    class="overflow-hidden rounded-lg shadow-lg"
                >
                    <table
                        class="table-auto w-full bg-white border border-gray-300 rounded-lg"
                    >
                        <thead
                            class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white"
                        >
                            <tr>
                                <th
                                    class="py-4 px-6 text-left text-sm font-semibold uppercase"
                                >
                                    Full Name
                                </th>
                                <th
                                    class="py-4 px-6 text-left text-sm font-semibold uppercase"
                                >
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in visApplicants"
                                :key="index"
                                class="hover:bg-gray-100 transition-all border-b cursor-pointer"
                                @click="openVisitorModal(item)"
                            >
                                <td class="py-4 px-6 text-gray-700">
                                    {{ item.first_name }} {{ item.surname }}
                                </td>
                                <td class="py-4 px-6 text-gray-600 capitalize">
                                    <span
                                        class="py-1 px-3 rounded-full text-xs font-medium"
                                        :class="{
                                            'bg-green-100 text-green-600':
                                                item.status === 'approved',
                                            'bg-yellow-100 text-yellow-600':
                                                item.status === 'pending',
                                            'bg-red-100 text-red-600':
                                                item.status === 'rejected',
                                        }"
                                    >
                                        {{ item.status }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div
                    v-else
                    class="text-center text-gray-500 font-semibold py-20"
                >
                    No visa applications found.
                </div>
            </div>
        </div>

        <!-- Modal Section -->
        <div
            v-if="selectedVisitor"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        >
            <div
                class="bg-white w-[90%] md:w-[50%] p-6 rounded-lg shadow-lg relative"
            >
                <button
                    @click="closeVisitorModal"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700"
                >
                    ✖
                </button>
                <h2 class="text-xl font-bold mb-4 text-gray-800">
                    Visitor Details
                </h2>
                <p class="text-gray-600 mb-4">
                    <strong>Email:</strong> {{ selectedVisitor.email }}
                </p>
                <p class="text-gray-600 mb-4">
                    <strong>Surname:</strong> {{ selectedVisitor.surname }}
                </p>
                <p class="text-gray-600 mb-4">
                    <strong>First Name:</strong>
                    {{ selectedVisitor.first_name }}
                </p>
                <p class="text-gray-600 mb-4">
                    <strong>Residence:</strong> {{ selectedVisitor.residence }}
                </p>
                <p class="text-gray-600 mb-4">
                    <strong>Marital Status:</strong>
                    {{ selectedVisitor.marital_status }}
                </p>
                <p class="text-gray-600 mb-4">
                    <strong>National ID:</strong>
                    {{ selectedVisitor.national_identity_number }}
                </p>
                <p class="text-gray-600 mb-4">
                    <strong>Travel Document:</strong>
                    {{ selectedVisitor.travel_document }}
                </p>
                <p class="text-gray-600 mb-4">
                    <strong>Journey Purpose:</strong>
                    {{ selectedVisitor.journey_purpose }}
                </p>
                <p class="text-gray-600 mb-4">
                    <strong>Arrival:</strong> {{ selectedVisitor.arrival }}
                </p>
                <p class="text-gray-600 mb-4">
                    <strong>Departure:</strong> {{ selectedVisitor.departure }}
                </p>
                <p class="text-gray-600 mb-4">
                    <strong>Status:</strong> {{ selectedVisitor.status }}
                </p>
            </div>
        </div>

        <Footer />
    </div>
</template>

<script>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
import axios from "axios";

export default {
    components: {
        Header,
        Footer,
    },
    data() {
        return {
            loading: true,
            visApplicants: [],
            selectedVisitor: null,
        };
    },
    methods: {
        fetchApplications() {
            this.loading = true;
            axios
                .get(route("user.fetch_application"))
                .then((res) => {
                    this.visApplicants = res.data.applications;
                    this.loading = false;
                })
                .catch((err) => {
                    console.error("Error fetching applications:", err);
                    this.loading = false;
                });
        },
        openVisitorModal(visitor) {
            this.selectedVisitor = visitor;
        },
        closeVisitorModal() {
            this.selectedVisitor = null;
        },
    },
    mounted() {
        this.fetchApplications();
    },
};
</script>
