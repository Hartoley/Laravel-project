<template>
    <Header></Header>
    <div v-if="visApplicants.length > 0" class="w-full overflow-x-auto">
        <table class="w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm">
                    <th class="py-3 px-4 text-left">Full Name</th>
                    <th class="py-3 px-4 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(item, index) in visApplicants"
                    :key="index"
                    class="border-b text-[15px] hover:bg-gray-100 cursor-pointer"
                    @click="openVisitorModal(item)"
                >
                    <td class="py-2 px-4">
                        {{ item.first_name }} {{ item.surname }}
                    </td>
                    <td class="py-2 px-4">{{ item.status }}</td>
                </tr>
            </tbody>
        </table>
    </div>

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
                <strong>First Name:</strong> {{ selectedVisitor.first_name }}
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

    <Footer></Footer>
</template>

<script>
import Header from "./Header.vue";
import axios from "axios";
import Footer from "./Footer.vue";

export default {
    components: {
        Header,
        Footer,
    },
    data() {
        return {
            tours: [],

            visApplicants: [],
            companions: [],
            selectedVisitor: null,
        };
    },
    methods: {
        prevSlide() {
            this.currentIndex =
                (this.currentIndex - 1 + this.images.length) %
                this.images.length;
            this.updateCarousel();
        },
        nextSlide() {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
            this.updateCarousel();
        },
        updateCarousel() {
            const carousel = this.$refs.carousel;
            carousel.style.transform = `translateX(${
                this.currentIndex * -100
            }%)`;
        },
        fetching() {
            axios
                .get(route("tour.fetch"))
                .then((res) => {
                    console.log(res);
                    this.tours = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },

        openVisitorModal(visitor) {
            this.selectedVisitor = visitor;
        },
        // Close the modal
        closeVisitorModal() {
            this.selectedVisitor = null;
        },

        startAutoSlide() {
            this.slideInterval = setInterval(() => {
                this.nextSlide();
            }, 1500);
        },
        stopAutoSlide() {
            clearInterval(this.slideInterval);
        },

        bookTour(id) {
            console.log(id);
            window.location.href = `/bookTour/${id}`;
        },

        fetchingCompanions() {
            axios
                .get(route("fetch.Companions"))
                .then((res) => {
                    // console.log(res);
                    this.companions = res.data;
                })
                .catch((err) => {
                    // console.log(err);
                });
        },

        fetchApplications() {
            axios
                .get(route("user.fetch_application"))
                .then((res) => {
                    console.log(res);
                    this.visApplicants = res.data.applications;
                    console.log("visa applicants", this.visApplicants);
                    console.log(Array.isArray(this.visApplicants));
                    console.log(this.visApplicants.length);
                    status = this.visApplicants.status;
                })
                .catch((err) => {
                    console.log("user error", err);
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
    },

    mounted() {
        this.fetching();
        this.updateCarousel();
        this.startAutoSlide();
        this.fetchApplications();
        this.fetchingCompanions();
    },
    beforeDestroy() {
        this.stopAutoSlide();
    },
};
</script>
