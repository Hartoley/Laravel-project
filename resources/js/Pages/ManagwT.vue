<template>
    <Adminheader />
    <div class="w-full min-h-[5vh]"></div>

    <!-- Spinner Overlay -->
    <div
        v-if="loading"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
        <div class="flex flex-col items-center">
            <svg
                class="animate-spin h-16 w-16 text-white"
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
                    d="M4 12a8 8 0 018-8v8H4zm2 5.291A7.969 7.969 0 014 12h6v5.291z"
                ></path>
            </svg>
            <p class="text-white mt-4">Loading, please wait...</p>
        </div>
    </div>

    <div
        id="holidays"
        class="w-full flex flex-col items-center justify-center bg-gradient-to-t from-[rgb(0,83,176)] via-[rgb(0,98,242)] to-[rgb(112,194,239)] py-12 px-6"
    >
        <p class="text-2xl font-bold text-white mb-8">Manage Tours</p>
        <div
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6 w-full max-w-7xl"
        >
            <!-- Tour Card -->
            <div
                v-for="(tour, index) in tours"
                :key="index"
                class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transform transition duration-300 hover:scale-105 border border-gray-200"
            >
                <!-- Image Section -->
                <img
                    class="w-full h-48 object-cover"
                    :src="'/storage/' + tour.images"
                    alt="Tour Image"
                />

                <!-- Card Content -->
                <div class="p-4">
                    <p class="text-lg font-semibold text-gray-800">
                        {{ tour.tour_name }}
                    </p>
                    <p class="text-sm text-gray-600 my-2">
                        {{ tour.tour_decs }}
                    </p>
                    <p class="text-xl font-bold text-blue-600">
                        {{ tour.tour_prices }}
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="p-4 pt-0 flex space-x-4">
                    <button
                        class="w-full py-2 text-center text-white bg-green-500 hover:bg-green-600 rounded-md transition"
                        @click="editTour(tour)"
                    >
                        Edit
                    </button>
                    <button
                        class="w-full py-2 text-center text-white bg-red-500 hover:bg-red-600 rounded-md transition"
                        @click="deleteTour(tour.id)"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div
        v-if="isEditing"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
        <div class="bg-white rounded-lg shadow-md p-6 w-[70%] max-w-lg">
            <h2 class="text-2xl font-bold mb-4">Edit Tour</h2>
            <form @submit.prevent="updateTour">
                <div class="mb-4">
                    <label class="block font-semibold mb-2">Tour Name</label>
                    <input
                        type="text"
                        v-model="currentTour.tour_name"
                        class="w-full border rounded-md px-4 py-2"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-2">Description</label>
                    <textarea
                        v-model="currentTour.tour_decs"
                        class="w-full border rounded-md px-4 py-2"
                        required
                    ></textarea>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-2">Price</label>
                    <input
                        type="number"
                        v-model="currentTour.tour_prices"
                        class="w-full border rounded-md px-4 py-2"
                        required
                    />
                </div>
                <div class="flex space-x-4">
                    <button
                        type="submit"
                        class="w-full py-2 text-center text-white bg-blue-500 hover:bg-blue-600 rounded-md transition"
                    >
                        Update
                    </button>
                    <button
                        type="button"
                        @click="isEditing = false"
                        class="w-full py-2 text-center text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-md transition"
                    >
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
    <Footer />
</template>

<script>
import Header from "./Header.vue";
import axios from "axios";
import Footer from "./Footer.vue";
import Adminheader from "./Adminheader.vue";

export default {
    components: {
        Adminheader,
        Header,
        Footer,
    },
    data() {
        return {
            tours: [],
            loading: false,
            isEditing: false,
            currentTour: {},
        };
    },
    methods: {
        fetching() {
            this.loading = true;
            axios
                .get(route("tour.fetch"))
                .then((res) => {
                    this.tours = res.data;
                    this.loading = false;
                })
                .catch((err) => {
                    console.error(err);
                    this.loading = false;
                });
        },
        deleteTour(id) {
            if (confirm("Are you sure you want to delete this tour?")) {
                axios
                    .delete(route("tour.delete", id))
                    .then((res) => {
                        alert("Tour deleted successfully!");
                        this.fetching();
                    })
                    .catch((err) => {
                        console.error(err);
                        alert("Failed to delete tour.");
                    });
            }
        },
        editTour(tour) {
            this.currentTour = { ...tour };
            this.isEditing = true;
        },
        updateTour() {
            axios
                .put(
                    route("tour.update", this.currentTour.id),
                    this.currentTour
                )
                .then((res) => {
                    alert("Tour updated successfully!");
                    this.isEditing = false;
                    this.fetching();
                })
                .catch((err) => {
                    console.error(err);
                    alert("Failed to update tour.");
                });
        },
    },
    mounted() {
        this.fetching();
    },
};
</script>
