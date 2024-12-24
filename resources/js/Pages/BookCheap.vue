<template>
    <Header></Header>
    <div
        class="w-full bg-purple-600 bg-[url('https://i.pinimg.com/736x/6c/12/86/6c1286a1895046fdb0dd8b9ff8c5db42.jpg')] bg-cover bg-center bg-no-repeat h-screen flex items-center justify-center text-white"
    >
        <div
            class="w-5/6 h-4/6 bg-[rgb(248,248,248)] rounded-xl flex p-5 gap-5 flex-col"
        >
            <div
                class="flex items-center justify-between space-x-4 p-4 w-2/3 bg-white rounded-lg shadow"
            >
                <div class="flex items-center space-x-6">
                    <label class="flex items-center text-gray-800 font-medium">
                        <input
                            type="radio"
                            name="tripType"
                            value="one-way"
                            class="mr-2 accent-blue-500"
                        />
                        One Way
                    </label>
                    <label class="flex items-center text-gray-800 font-medium">
                        <input
                            type="radio"
                            name="tripType"
                            value="round-trip"
                            class="mr-2 accent-blue-500"
                            checked
                        />
                        Round Trip
                    </label>
                    <label class="flex items-center text-gray-800 font-medium">
                        <input
                            type="radio"
                            name="tripType"
                            value="multi-city"
                            class="mr-2 accent-blue-500"
                        />
                        Multi City
                    </label>
                </div>

                <div>
                    <select
                        class="border border-gray-300 rounded-md p-2 w-[10vw] text-gray-800 shadow-sm focus:ring-2 focus:ring-blue-500"
                    >
                        <option>Economy</option>
                        <option>Business</option>
                        <option>First Class</option>
                    </select>
                </div>
            </div>
            <div
                class="p-6 bg-white rounded-lg shadow-md w-full max-w-4xl mx-auto"
            >
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Other fields -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1"
                            >From</label
                        >
                        <input
                            type="text"
                            placeholder="Select City"
                            @click="toggleDropdown('from')"
                            class="w-full border border-gray-300 rounded-md p-3 text-gray-800 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-1"
                            >To</label
                        >
                        <input
                            type="text"
                            placeholder="Select City"
                            @click="toggleDropdown('to')"
                            class="w-full border border-gray-300 rounded-md p-3 text-gray-800 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-1"
                            >Departure</label
                        >
                        <input
                            type="date"
                            class="w-full border border-gray-300 rounded-md p-3 text-gray-800 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>
                    <!-- Passenger dropdown -->
                    <div class="relative">
                        <label class="block text-gray-700 font-medium mb-1"
                            >Passenger</label
                        >
                        <div
                            class="w-full border border-gray-300 rounded-md p-3 text-gray-800 cursor-pointer"
                            @click="togglePassengerDropdown"
                        >
                            {{ passengerText }}
                        </div>
                        <!-- Dropdown -->
                        <div
                            v-if="showPassengerDropdown"
                            class="absolute z-10 bg-white border border-gray-300 rounded-md shadow-md mt-2 p-4 w-full"
                        >
                            <div class="mb-4">
                                <h3 class="font-semibold text-gray-700">
                                    Adults 12y+
                                </h3>
                                <p class="text-sm text-gray-500">
                                    On the day of travel
                                </p>
                                <div class="flex items-center mt-2 space-x-2">
                                    <button
                                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-1 px-3 rounded"
                                        @click="decrement('adults')"
                                    >
                                        -
                                    </button>
                                    <span class="text-lg font-semibold">
                                        {{ adults }}
                                    </span>
                                    <button
                                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-1 px-3 rounded"
                                        @click="increment('adults')"
                                    >
                                        +
                                    </button>
                                </div>
                            </div>
                            <div class="mb-4">
                                <h3 class="font-semibold text-gray-700">
                                    Children (2y - 12y)
                                </h3>
                                <p class="text-sm text-gray-500">
                                    On the day of travel
                                </p>
                                <div class="flex items-center mt-2 space-x-2">
                                    <button
                                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-1 px-3 rounded"
                                        @click="decrement('children')"
                                    >
                                        -
                                    </button>
                                    <span class="text-lg font-semibold">
                                        {{ children }}
                                    </span>
                                    <button
                                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-1 px-3 rounded"
                                        @click="increment('children')"
                                    >
                                        +
                                    </button>
                                </div>
                            </div>
                            <div class="mb-4">
                                <h3 class="font-semibold text-gray-700">
                                    Infants (Below 2y)
                                </h3>
                                <p class="text-sm text-gray-500">
                                    On the day of travel
                                </p>
                                <div class="flex items-center mt-2 space-x-2">
                                    <button
                                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-1 px-3 rounded"
                                        @click="decrement('infants')"
                                    >
                                        -
                                    </button>
                                    <span class="text-lg font-semibold">
                                        {{ infants }}
                                    </span>
                                    <button
                                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-1 px-3 rounded"
                                        @click="increment('infants')"
                                    >
                                        +
                                    </button>
                                </div>
                            </div>
                            <p v-if="errorMessage" class="text-red-500 text-sm">
                                {{ errorMessage }}
                            </p>
                            <div class="flex justify-end">
                                <button
                                    class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded"
                                    @click="applyPassengerSelection"
                                >
                                    Apply
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search Button -->
                <div class="mt-6 flex justify-center">
                    <button
                        class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-md"
                    >
                        SEARCH
                    </button>
                </div>
            </div>
        </div>
    </div>
    <Footer></Footer>
</template>

<script>
import Header from "./Header.vue";
import Footer from "./Footer.vue";

export default {
    components: {
        Header,
        Footer,
    },
    data() {
        return {
            showPassengerDropdown: false,
            adults: 1,
            children: 0,
            infants: 0,
            errorMessage: "",
        };
    },
    computed: {
        passengerText() {
            const total = this.adults + this.children + this.infants;
            return `${total} Passenger${total > 1 ? "s" : ""}`;
        },
    },
    methods: {
        togglePassengerDropdown() {
            this.showPassengerDropdown = !this.showPassengerDropdown;
        },
        increment(type) {
            if (this.adults + this.children + this.infants >= 9) {
                this.errorMessage =
                    "Number of total passengers must be between 1 and 9";
                return;
            }
            this.errorMessage = "";
            this[type]++;
        },
        decrement(type) {
            if (this[type] > 0) {
                this.errorMessage = "";
                this[type]--;
            }
        },
        applyPassengerSelection() {
            this.showPassengerDropdown = false;
        },
    },
};
</script>
