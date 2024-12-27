<template>
    <Header></Header>
    <div class="max-w-4xl mx-auto p-6 mt-[10vh]">
        <h1 class="text-3xl font-bold text-center text-blue-700 mb-4">
            Thanks For Submitting Your Booking
        </h1>
        <p class="text-center text-gray-600 mb-8">
            We have received your booking and will call you shortly. To complete
            your booking automatically and secure your spot, you can also make
            payments using the following payment options.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-100 p-6 rounded-md shadow-md">
                <h2 class="text-xl font-bold text-blue-700 mb-2">
                    Naira Bank Transfer
                </h2>
                <p>
                    <span class="font-semibold">Account Name:</span> Keena
                    Travel Agency
                </p>
                <p>
                    <span class="font-semibold">Account Number:</span>
                    2098412817
                </p>
                <p>
                    <span class="font-semibold">Bank Name:</span> United Bank Of
                    Africa (UBA)
                </p>
                <p class="mt-4 text-gray-600">
                    After payments use the following contact information below
                    to confirm your transaction to enable us to process your
                    booking.
                </p>
            </div>

            <div class="bg-gray-100 p-6 rounded-md shadow-md">
                <h2 class="text-xl font-bold text-blue-700 mb-2">
                    Pay with Paystack
                </h2>
                <p class="mb-4">
                    You can complete online payment using your Naira Master,
                    Visa, or Verve card securely with Paystack using the button
                    below.
                </p>
                <button
                    @click="pay"
                    class="bg-blue-700 text-white py-2 px-4 rounded shadow hover:bg-blue-800"
                >
                    Pay With Paystack
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto p-6 bg-gray-100 rounded-md shadow-md mt-8">
        <h2 class="text-2xl font-bold text-blue-700 mb-4">
            Upload Proof of Payment
        </h2>

        <div class="space-y-4">
            <div class="mb-4">
                <label
                    for="payment-proof"
                    class="block text-sm font-medium mb-2"
                    >Upload Payment Proof</label
                >
                <input
                    type="file"
                    id="payment-proof"
                    @change="handleFileUpload($event, tourId)"
                    class="w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded-md"
                />
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button
                    class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-md"
                    type="submit"
                    @click="submitPaymentProof(tourId)"
                >
                    Submit Proof
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto p-6 bg-gray-100 rounded-md shadow-md mt-8">
        <h2 class="text-2xl font-bold text-blue-700 mb-4">Contact Us</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <svg
                        class="w-6 h-6 text-blue-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 12H8m8-8H8m8 8v8m-8-8v8"
                        />
                    </svg>
                    <a
                        href="mailto:holidays@aspomtravels.com"
                        class="text-gray-700 hover:text-blue-700"
                        >holidays@keenatravels.com</a
                    >
                </div>

                <div class="flex items-center space-x-2">
                    <svg
                        class="w-6 h-6 text-green-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 5h12M9 9h9m0 0l-4.5 6m4.5-6L9 21M9 21l3-9-3-3"
                        />
                    </svg>
                    <a
                        href="tel:+2349082212663"
                        class="text-gray-700 hover:text-blue-700"
                        >+2349082212663</a
                    >,
                    <a
                        href="tel:+2348172699865"
                        class="text-gray-700 hover:text-blue-700"
                        >+2348172699865</a
                    >
                </div>

                <div class="flex items-center space-x-2">
                    <svg
                        class="w-6 h-6 text-blue-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 17l4-4m0 0l4 4m-4-4v12"
                        />
                    </svg>
                    <p class="text-gray-700">
                        3rd Floor Brasas’r Place, 69 Admiralty Way, Lekki Phase
                        1, Lagos.
                    </p>
                </div>

                <div class="flex items-center space-x-2">
                    <svg
                        class="w-6 h-6 text-pink-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12l2 2m0 0l2-2m-2 2V9"
                        />
                    </svg>
                    <a
                        href="https://instagram.com/aspomtravels"
                        class="text-gray-700 hover:text-blue-700"
                        >@aspomtravels</a
                    >
                </div>
            </div>

            <div class="flex justify-center">
                <a
                    href="https://wa.me/2349082212663"
                    class="bg-blue-700 text-white px-4 py-2 rounded-md hover:bg-blue-800"
                >
                    Complete Payment On WhatsApp
                </a>
            </div>
        </div>

        <div class="mt-8 text-center text-gray-500">
            <p>
                Powered by:
                <span class="font-semibold">Aspom Travel Agency</span>
            </p>
            <p>All Rights Reserved</p>
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
    props: {
        email: String,
        tourName: String,
        id: {
            type: [String, Number],
            required: true,
        },
    },

    data() {
        return {
            fileUploads: {},
            allTours: [],
            tourId: this.id,
        };
    },

    computed: {},

    methods: {
        pay() {
            axios
                .post(route("pay"))
                .then((response) => {
                    const url = response.data.url;
                    if (url) {
                        window.location.href = url;
                    } else {
                        alert("Payment URL not found. Please try again.");
                    }
                })
                .catch((error) => {
                    console.error(
                        "Error during payment:",
                        error.response?.data || error.message
                    );
                    alert("Payment initiation failed. Please try again.");
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

        handleFileUpload(event, tourId) {
            const file = event.target.files[0];
            if (file) {
                this.fileUploads[tourId] = file;
            }
        },

        submitPaymentProof() {
            const formData = new FormData();
            formData.append("file", this.fileUploads[this.tourId]);
            formData.append("tourId", this.tourId);

            console.log(...formData.entries());

            axios
                .post(route("submit.payment.proof"), formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                })
                .then((response) => {
                    console.log(
                        "Payment submitted successfully:",
                        response.data
                    );
                })
                .catch((error) => {
                    console.error("Error submitting payment proof:", error);
                });
        },
    },

    mounted() {
        this.fetching();
        console.log(this.tourId);
    },
};
</script>
