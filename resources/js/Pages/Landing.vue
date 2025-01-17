<template>
    <Header></Header>
    <div class="container mx-auto mt-[15vh] px-4">
        <h1 class="text-3xl sm:text-4xl font-bold text-center mb-10 text-blue-600">
            My Booked Tours
        </h1>

        <div v-if="loading" class="flex justify-center items-center h-[50vh]">
            <svg class="animate-spin h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
        </div>

        <div v-if="!loading && enrichedTours.length > 0"
            class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-6">
            <div v-for="(tour, index) in enrichedTours" :key="index"
                class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform hover:scale-105">
                <img :src="'/storage/' + tour.tourImage" :alt="`Image of ${tour.tourName}`"
                    class="w-full h-48 object-cover" />
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
                    <span class="px-3 py-1 text-sm font-bold rounded self-start" :class="tour.isPaid
                        ? 'bg-green-500 text-white'
                        : 'bg-red-500 text-white'
                        ">
                        {{ tour.isPaid ? "Paid" : "Not Paid" }}
                    </span>
                    <div v-if="tour.paymentStatus === 'approved'" class="flex justify-between">
                        <button @click="downloadTicket(tour)"
                            class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-bold py-2 px-4 rounded">
                            Download Ticket
                        </button>
                    </div>
                    <div v-if="tour.paymentStatus === 'declined'" class="text-red-500 text-sm text-center">
                        Your payment has been declined. Please contact our support team via
                        <a href="https://wa.me/2348063123877?text=Hello+I+need+assistance+with+my+payment"
                            class="text-blue-500 hover:underline" target="_blank">
                            WhatsApp
                        </a>
                        for further assistance and review.
                    </div>

                    <div v-if="tour.paymentStatus === 'pending'" class="text-red-500 text-sm text-center">
                        Payment not approved yet. Kindly wait while your payment
                        is approved.
                    </div>
                    <div v-if="!tour.isPaid">
                        <label class="text-sm text-gray-600 mb-1 block">Upload Payment Proof:</label>
                        <input type="file" accept="image/*" @change="handleFileUpload($event, tour.id)"
                            class="text-sm mb-2" />
                        <button @click="submitPaymentProof(tour.id)"
                            class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-bold py-2 px-4 rounded">
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
                    customerName: `${tour.first_name || ""} ${tour.surname || ""
                        }`.trim(),
                    tourImage: matchedTour?.images || this.defaultImage,
                    boardingDate: matchedTour?.boarding_date,
                    boardingTime: matchedTour?.boarding_time,
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
            const doc = new jsPDF({
                orientation: "landscape", // Landscape for ticket format
                unit: "px", // Use pixels for easy sizing
                format: [300, 700], // Custom size for the ticket
            });

            // Add background color
            doc.setFillColor(240, 240, 240);
            doc.rect(0, 0, 700, 300, "F");

            // Add tour image
            const imageUrl = `/storage/${tour.tourImage}` || this.defaultImage;
            const imageWidth = 300;
            const imageHeight = 200;
            const imageX = 20;
            const imageY = 50;

            const addImageCallback = (imageData) => {
                doc.addImage(
                    imageData,
                    "JPEG",
                    imageX,
                    imageY,
                    imageWidth,
                    imageHeight
                );

                // Add title and details
                doc.setFont("helvetica", "bold");
                doc.setFontSize(24);
                doc.text("You're Going To", 340, 80);
                doc.setFontSize(28);
                doc.setTextColor(30, 144, 255); // Dodger Blue
                doc.text(tour.destination, 340, 110);

                // Add message
                doc.setFontSize(16);
                doc.setTextColor(50, 50, 50); // Dark Gray
                doc.text("Pack Your Bags and Fly With Me!", 340, 140);

                // Passenger Details
                doc.setFont("helvetica", "normal");
                doc.setFontSize(14);
                doc.setTextColor(80, 80, 80);
                doc.text(`Passenger Name: ${tour.customerName}`, 340, 170);
                doc.text(
                    `Date: ${new Date(tour.boardingDate).toLocaleDateString()}`,
                    340,
                    190
                );
                doc.text(
                    `Boarding Time: ${tour.boardingTime || "N/A"}`,
                    340,
                    210
                );

                doc.save(`${tour.tourName}_Ticket.pdf`);
            };

            const img = new Image();
            img.src = imageUrl;
            img.onload = () => {
                const canvas = document.createElement("canvas");
                canvas.width = imageWidth;
                canvas.height = imageHeight;
                const ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0, imageWidth, imageHeight);
                addImageCallback(canvas.toDataURL("image/jpeg"));
            };
        },
    },
    mounted() {
        this.fetchTours();
        this.fetching();
    },
};
</script>
