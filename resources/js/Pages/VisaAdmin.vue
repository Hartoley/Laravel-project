<template>
    <div class="min-h-screen flex flex-col bg-gray-50">
        <Adminheader />

        <main class="flex-1 p-6 mt-[12vh]">
            <div id="visaApplication" class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">
                    Visa Applications Management
                </h1>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse border border-gray-300 rounded-lg">
                        <thead class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white">
                            <tr>
                                <th class="py-3 px-4 text-sm uppercase font-semibold">
                                    Email
                                </th>
                                <th class="py-3 px-4 text-sm uppercase font-semibold">
                                    Full Name
                                </th>
                                <th class="py-3 px-4 text-sm uppercase font-semibold">
                                    Residence
                                </th>
                                <th class="py-3 px-4 text-sm uppercase font-semibold">
                                    Status
                                </th>
                                <th class="py-3 px-4 text-sm uppercase font-semibold">
                                    Actions
                                </th>
                                <th class="py-3 px-4 text-sm uppercase font-semibold">
                                    Companions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in visApplicants" :key="index"
                                class="bg-white border-b hover:bg-gray-100">
                                <td @click="showApplicationDetails(item)" class="py-3 px-4 text-gray-700">
                                    {{ item.email }}
                                </td>
                                <td @click="showApplicationDetails(item)" class="py-3 px-4 text-gray-700">
                                    {{ item.first_name }} {{ item.surname }}
                                </td>
                                <td @click="showApplicationDetails(item)" class="py-3 px-4 text-gray-700">
                                    {{ item.residence }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="py-1 px-3 rounded-full text-xs font-semibold capitalize" :class="{
                                        'bg-green-100 text-green-600':
                                            item.status === 'Accepted',
                                        'bg-yellow-100 text-yellow-600':
                                            item.status === 'Pending',
                                        'bg-red-100 text-red-600':
                                            item.status === 'Rejected',
                                    }">
                                        {{ item.status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 flex space-x-2">
                                    <button v-if="item.status === 'Pending'"
                                        class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded text-sm"
                                        @click="accept(item.id)">
                                        Accept
                                    </button>
                                    <button v-if="item.status === 'Pending'"
                                        class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-sm"
                                        @click="reject(item.id)">
                                        Reject
                                    </button>
                                    <span v-else class="text-gray-500 italic">
                                        No actions available
                                    </span>
                                </td>
                                <td class="py-3 px-4" v-if="item.travel_companion.length > 0">
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded text-sm"
                                        @click="partner(item.transaction_id)">
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

                <div v-if="showCompanion" class="mt-8 bg-gray-100 p-4 rounded-lg shadow-lg">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        Companions for Application
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse border border-gray-300 rounded-lg">
                            <thead class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white">
                                <tr>
                                    <th class="py-3 px-4 text-sm uppercase font-semibold">
                                        Name
                                    </th>
                                    <th class="py-3 px-4 text-sm uppercase font-semibold">
                                        Relationship
                                    </th>
                                    <th class="py-3 px-4 text-sm uppercase font-semibold">
                                        Status
                                    </th>
                                    <th class="py-3 px-4 text-sm uppercase font-semibold">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(companion, index) in companions" :key="index"
                                    class="bg-white border-b hover:bg-gray-100">
                                    <td class="py-3 px-4 text-gray-700">
                                        {{ companion.name }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">
                                        {{ companion.relationship }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="py-1 px-3 rounded-full text-xs font-semibold capitalize" :class="{
                                            'bg-yellow-100 text-yellow-600':
                                                companion.status ===
                                                'Pending',
                                            'bg-green-100 text-green-600':
                                                companion.status ===
                                                'Accepted',
                                            'bg-red-100 text-red-600':
                                                companion.status ===
                                                'Rejected',
                                        }">
                                            {{ companion.status }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 flex space-x-2">
                                        <button v-if="
                                            companion.status === 'Pending'
                                        " class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded text-sm"
                                            @click="
                                                acceptCompanion(companion.id)
                                                ">
                                            Accept
                                        </button>
                                        <button v-if="
                                            companion.status === 'Pending'
                                        " class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-sm"
                                            @click="
                                                rejectCompanion(companion.id)
                                                ">
                                            Reject
                                        </button>
                                        <span v-else class="text-gray-500 italic">
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
        <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center mt-[10vh]">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full overflow-auto" style="max-height: 83vh;">
                <h2 class="text-xl font-bold mb-4">Application Details</h2>
                <div class="space-y-2">
                    <p><strong>Email:</strong> {{ selectedApplication.email }}</p>
                    <p>
                        <strong>Name:</strong>
                        {{ selectedApplication.first_name }} {{ selectedApplication.surname }}
                    </p>
                    <p><strong>Residence:</strong> {{ selectedApplication.residence }}</p>
                    <p><strong>Status:</strong> {{ selectedApplication.status }}</p>
                    <p><strong>Country of Visitation:</strong> {{ selectedApplication.selectedCountry }}</p>
                    <p><strong>Marital Status:</strong> {{ selectedApplication.marital_status }}</p>
                    <p><strong>National ID:</strong> {{ selectedApplication.national_identity_number }}</p>
                    <p><strong>Travel Document:</strong> {{ selectedApplication.travel_document }}</p>
                    <p><strong>Journey Purpose:</strong> {{ selectedApplication.journey_purpose }}</p>
                    <p><strong>Arrival:</strong> {{ selectedApplication.arrival }}</p>
                    <p><strong>Departure:</strong> {{ selectedApplication.departure }}</p>
                    <div v-if="selectedApplication.travel_companion.length > 0">
                        <p><strong>Travel Companions:</strong></p>
                        <ul class="list-disc pl-6 space-y-1">
                            <li v-for="comp in selectedApplication.travel_companion" :key="comp.name">
                                <strong>Name:</strong> {{ comp.name }},
                                <strong>Relationship:</strong> {{ comp.relationship }}
                            </li>
                        </ul>
                    </div>
                    <div v-else>
                        <p><strong>Travel Companions:</strong> No companions added</p>
                    </div>
                </div>
                <div class="mt-4 flex justify-end space-x-2">
                    <button class="bg-gray-500 hover:bg-gray-600 text-white py-1 px-4 rounded"
                        @click="showModal = false">
                        Close
                    </button>
                </div>
            </div>
        </div>


        <div class="min-h-screen flex flex-col bg-gray-50">
            <main class="flex-1 p-6 mt-[12vh]">
                <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-4">
                        Tours Applications Management
                    </h1>

                    <!-- Displaying user tours -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse border border-gray-300 rounded-lg">
                            <thead class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white">
                                <tr>
                                    <th class="py-3 px-4 text-sm uppercase font-semibold">
                                        Email
                                    </th>
                                    <th class="py-3 px-4 text-sm uppercase font-semibold">
                                        Full Name
                                    </th>
                                    <th class="py-3 px-4 text-sm uppercase font-semibold">
                                        Tour Name
                                    </th>
                                    <th class="py-3 px-4 text-sm uppercase font-semibold">
                                        Status
                                    </th>
                                    <th class="py-3 px-4 text-sm uppercase font-semibold">
                                        Payment Proof
                                    </th>
                                    <th class="py-3 px-4 text-sm uppercase font-semibold">
                                        Actions
                                    </th>
                                    <th class="py-3 px-4 text-sm uppercase font-semibold">
                                        Price
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(tour, index) in userTours" :key="index"
                                    class="bg-white border-b hover:bg-gray-100">
                                    <td class="py-3 px-4 text-gray-700">
                                        {{ tour.email }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">
                                        {{ tour.first_name }} {{ tour.surname }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">
                                        {{ tour.tourName }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="py-1 px-3 rounded-full text-xs font-semibold capitalize" :class="{
                                            'bg-yellow-100 text-yellow-600':
                                                tour.paymentStatus ===
                                                'pending',
                                            'bg-green-100 text-green-600':
                                                tour.paymentStatus ===
                                                'approved',
                                            'bg-red-100 text-red-600':
                                                tour.paymentStatus ===
                                                'declined',
                                        }">
                                            {{ tour.paymentStatus }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <img v-if="tour.paymentImage" :src="'/storage/' + tour.paymentImage
                                            " alt="Payment Proof" class="w-16 h-16 object-cover cursor-pointer" @click="
                                                openModal(tour.paymentImage)
                                                " />
                                        <span v-else class="text-gray-500 italic">No proof uploaded</span>
                                    </td>
                                    <td class="py-3 px-4 flex space-x-2">
                                        <button v-if="
                                            tour.paymentStatus === 'pending'
                                        " class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded text-sm"
                                            @click="approvePayment(tour.id)">
                                            Approve
                                        </button>
                                        <button v-if="
                                            tour.paymentStatus === 'pending'
                                        " class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-sm"
                                            @click="declinePayment(tour.id)">
                                            Decline
                                        </button>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">
                                        <span v-if="matchedTour(tour)">
                                            {{ matchedTour(tour).price }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal for full image view -->
                    <div v-if="isModalOpen"
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                        @click="closeModal">
                        <div class="flex justify-center items-center max-w-full max-h-full">
                            <img :src="modalImage" alt="Full View" class="max-w-[90%] max-h-[90%] object-contain" />
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <Footer />
    </div>
</template>

<script>
import axios from "axios";
import Header from "./Header.vue";
import Footer from "./Footer.vue";
import Adminheader from "./Adminheader.vue";

export default {
    components: { Adminheader, Header, Footer },

    data() {
        return {
            visApplicants: [],
            companions: [],
            showCompanion: false,
            userTours: [],
            currentTours: [],
            allTours: [],
            isModalOpen: false,
            modalImage: "",
            selectedApplication: null,
            showModal: false,
        };
    },
    mounted() {
        this.fetchApplications();
        this.fetchAllTours();
        this.fetching();
    },
    methods: {

        showApplicationDetails(application) {
            this.selectedApplication = application;
            this.showModal = true;
        },

        openModal(image) {
            this.modalImage = "/storage/" + image;
            this.isModalOpen = true;
        },

        closeModal() {
            this.isModalOpen = false;
            this.modalImage = "";
        },
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
            if (this.companions.length > 0) {
                this.showCompanion = true;
            } else {
                this.selectedApplication = null;
                this.showModal = false;
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
            }
        },


        matchedTour(tour) {
            const matched = this.allTours.find(
                (item) => item.tour_name === tour.tourName
            );
            return matched ? matched : null;
        },

        approvePayment(tourId) {
            axios
                .post(route("approve.payment"), { id: tourId })
                .then((response) => {
                    alert(response.data.message);
                    this.fetchAllTours();
                })
                .catch((error) => {
                    console.error("Error approving payment:", error);
                    alert("Failed to approve payment.");
                });
        },

        declinePayment(tourId) {
            axios
                .post(route("decline.payment"), { id: tourId })
                .then((response) => {
                    alert(response.data.message);
                    this.fetchAllTours();
                })
                .catch((error) => {
                    console.error("Error declining payment:", error);
                    alert("Failed to decline payment.");
                });
        },
    },
};
</script>
