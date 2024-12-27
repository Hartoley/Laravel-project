<template>
    <Header></Header>
    <form
        @submit.prevent="createTour"
        enctype="multipart/form-data"
        class="max-w-md mt-[10vh] mx-auto p-4 pt-6 md:p-6 lg:p-12"
    >
        <h1 class="text-3xl font-bold mb-4">Create a Tour</h1>
        <div>
            <!-- Upload Image -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium mb-2"
                    >Upload Image</label
                >
                <input
                    type="file"
                    @change="pickfile($event)"
                    id="image"
                    class="w-full p-2 pl-10 text-sm text-gray-700"
                />
            </div>

            <!-- Tour Name -->
            <div class="mb-4">
                <label for="tour-name" class="block text-sm font-medium mb-2"
                    >Tour Name</label
                >
                <input
                    type="text"
                    id="tour-name"
                    v-model="tourName"
                    class="w-full p-2 pl-10 text-sm text-gray-700"
                />
            </div>

            <!-- Tour Description -->
            <div class="mb-4">
                <label
                    for="tour-description"
                    class="block text-sm font-medium mb-2"
                    >Tour Description</label
                >
                <input
                    type="text"
                    id="tour-description"
                    v-model="tourDescription"
                    class="w-full p-2 pl-10 text-sm text-gray-700"
                />
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium mb-2"
                    >Price</label
                >
                <input
                    type="text"
                    id="price"
                    v-model="price"
                    class="w-full p-2 pl-10 text-sm text-gray-700"
                />
            </div>

            <!-- Destination -->
            <div class="mb-4">
                <label for="destination" class="block text-sm font-medium mb-2"
                    >Destination</label
                >
                <input
                    type="text"
                    id="destination"
                    v-model="destination"
                    class="w-full p-2 pl-10 text-sm text-gray-700"
                />
            </div>

            <!-- Tour Date -->
            <div class="mb-4">
                <label for="tour-date" class="block text-sm font-medium mb-2"
                    >Tour Duration</label
                >
                <input
                    type="text"
                    id="tour-date"
                    v-model="tourDate"
                    class="w-full p-2 pl-10 text-sm text-gray-700"
                />
            </div>

            <!-- Boarding Date -->
            <div class="mb-4">
                <label
                    for="boarding-date"
                    class="block text-sm font-medium mb-2"
                    >Boarding Date</label
                >
                <input
                    type="date"
                    id="boarding-date"
                    v-model="boardingDate"
                    class="w-full p-2 pl-10 text-sm text-gray-700"
                />
            </div>

            <!-- Boarding Time -->
            <div class="mb-4">
                <label
                    for="boarding-time"
                    class="block text-sm font-medium mb-2"
                    >Boarding Time</label
                >
                <input
                    type="time"
                    id="boarding-time"
                    v-model="boardingTime"
                    class="w-full p-2 pl-10 text-sm text-gray-700"
                />
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button
                    class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded"
                    type="submit"
                    :disabled="loading"
                >
                    <span v-if="loading">Submitting...</span>
                    <span v-else>Create Tour</span>
                </button>
            </div>
        </div>
    </form>
    <Footer></Footer>
</template>

<script>
import axios from "axios";
import Header from "./Header.vue";
import Footer from "./Footer.vue";

export default {
    components: {
        Header,
        Footer,
    },
    data() {
        return {
            tourName: "",
            tourDescription: "",
            price: "",
            destination: "",
            tourDate: "",
            boardingDate: "",
            boardingTime: "",
            img: null,
            tours: JSON.parse(localStorage.getItem("Tours")) || [],
            loading: false,
        };
    },
    methods: {
        pickfile(e) {
            console.log(e.target.files[0]);
            this.img = e.target.files[0];
        },
        createTour() {
            this.loading = true;
            let formData = new FormData();
            formData.append("tour_name", this.tourName);
            formData.append("tour_prices", this.price);
            formData.append("tour_decs", this.tourDescription);
            formData.append("destination", this.destination);
            formData.append("tourDuration", this.tourDate);
            formData.append("boarding_date", this.boardingDate);
            formData.append("boarding_time", this.boardingTime);
            formData.append("images", this.img);

            axios
                .post(route("tour.create"), formData)
                .then((res) => {
                    console.log(res);
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err);
                    this.loading = false;
                });
        },
    },
};
</script>
