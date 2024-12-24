<template>
    <Header></Header>
    <div class="container mx-auto mt-[15vh] px-4">
        <h1
            class="text-3xl sm:text-4xl font-bold text-center mb-10 text-blue-600"
        >
            My Booked Tours
        </h1>

        <div v-if="loading" class="flex justify-center items-center h-[50vh]">
            <svg
                class="animate-spin h-10 w-10 text-blue-600"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
            >
                <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                ></circle>
                <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 018-8v8H4z"
                ></path>
            </svg>
        </div>

        <div
            v-if="!loading && enrichedTours.length > 0"
            class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-6"
        >
            <div
                v-for="(tour, index) in enrichedTours"
                :key="index"
                class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform hover:scale-105"
            >
                <img
                    :src="'/storage/' + tour.tourImage"
                    :alt="`Image of ${tour.tourName}`"
                    class="w-full h-48 object-cover"
                />
                <div class="p-4">
                    <h3 class="text-lg font-bold text-blue-600 mb-2">
                        {{ tour.tourName }}
                    </h3>
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold">Destination:</span>
                        {{ tour.destination }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold">Duration:</span>
                        {{ tour.tourDuration }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold">Price:</span> ₦{{
                            tour.tour_prices
                        }}
                    </p>
                </div>
                <div class="p-4 bg-gray-100 flex flex-col gap-2">
                    <span
                        class="px-3 py-1 text-sm font-bold rounded self-start"
                        :class="
                            tour.isPaid
                                ? 'bg-green-500 text-white'
                                : 'bg-red-500 text-white'
                        "
                    >
                        {{ tour.isPaid ? "Paid" : "Not Paid" }}
                    </span>
                    <div
                        v-if="tour.paymentStatus === 'Approved'"
                        class="flex justify-between"
                    >
                        <button
                            @click="downloadTicket(tour)"
                            class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-bold py-2 px-4 rounded"
                        >
                            Download Ticket
                        </button>
                    </div>
                    <div v-else class="text-red-500 text-sm text-center">
                        Payment not approved yet. Kindly wait while your payment
                        is approved.
                    </div>
                    <div v-if="!tour.isPaid">
                        <label class="text-sm text-gray-600 mb-1 block"
                            >Upload Payment Proof:</label
                        >
                        <input
                            type="file"
                            accept="image/*"
                            @change="handleFileUpload($event, tour.id)"
                            class="text-sm mb-2"
                        />
                        <button
                            @click="submitPaymentProof(tour.id)"
                            class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-bold py-2 px-4 rounded"
                        >
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-else-if="!loading" class="text-center text-gray-600 mt-10">
            <p>No tours found. Book a holiday to see your trips here!</p>
        </div>
    </div>
    <Footer></Footer>
</template>

<script>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
import axios from "axios";
import jsPDF from "jspdf";

export default {
    components: {
        Header,
        Footer,
    },
    data() {
        return {
            allTours: [],
            tours: [],
            defaultImage: "https://via.placeholder.com/300x200?text=Tour+Image",
            fileUploads: {},
            loading: true,
        };
    },
    computed: {
        enrichedTours() {
            return this.tours.map((tour) => {
                const matchedTour = this.allTours.find(
                    (item) => item.tour_name === tour.tourName
                );
                return {
                    ...tour,
                    destination: matchedTour?.destination || "Unknown",
                    tour_prices: matchedTour?.tour_prices || "N/A",
                    tourDuration: matchedTour?.tourDuration || "N/A",
                    instructions:
                        tour.instructions || matchedTour?.instructions || "N/A",
                    customerName: `${tour.first_name || ""} ${
                        tour.surname || ""
                    }`.trim(),
                    tourImage: matchedTour?.images || this.defaultImage,
                };
            });
        },
    },
    methods: {
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
        fetchTours() {
            this.loading = true;
            axios
                .get(route("usertour.fetch"))
                .then((res) => {
                    console.log(res);

                    this.tours = res.data.tours || [];
                })
                .catch((err) => {
                    console.error("Error fetching tours:", err);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        handleFileUpload(event, tourId) {
            const file = event.target.files[0];
            if (file) {
                this.fileUploads[tourId] = file;
            }
        },
        submitPaymentProof(tourId) {
            if (!this.fileUploads[tourId]) {
                alert("Please upload a file before submitting.");
                return;
            }

            const tour = this.enrichedTours.find((t) => t.id === tourId);
            if (!tour) {
                alert("Tour not found.");
                return;
            }

            const formData = new FormData();
            formData.append("file", this.fileUploads[tourId]);
            formData.append("tourId", tourId);

            console.log(...formData.entries());

            axios
                .post(route("submit.payment.proof"), formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                })
                .then((res) => {
                    alert(
                        res.data.message ||
                            "Payment proof submitted successfully!"
                    );
                    this.fetchTours();
                })
                .catch((err) => {
                    console.error("Error response:", err.response?.data);
                    alert(
                        err.response?.data?.message ||
                            "Failed to submit payment proof."
                    );
                });
        },
        downloadTicket(tour) {
            const doc = new jsPDF();
            doc.setFontSize(18);
            doc.text("Tour Ticket", 105, 20, null, null, "center");
            doc.setFontSize(12);
            doc.text(`Tour Name: ${tour.tourName}`, 20, 40);
            doc.text(`Name: ${tour.first_name} ${tour.surname}`, 20, 50);
            doc.text(`Email: ${tour.email}`, 20, 60);
            doc.text(`Mobile: ${tour.mobileNum}`, 20, 70);
            doc.text(`Instructions: ${tour.instructions || "N/A"}`, 20, 80);
            doc.save(`${tour.tourName}_Ticket.pdf`);
        },
    },
    mounted() {
        this.fetchTours();
        this.fetching();
    },
};
</script>
