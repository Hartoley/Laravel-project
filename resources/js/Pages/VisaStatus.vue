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

                <div class="grid grid-cols-3 gap-4 mb-8">
                    <div class="bg-green-100 p-4 rounded-lg text-center">
                        <h2 class="text-lg font-semibold text-green-700">
                            Approved
                        </h2>
                        <p class="text-2xl font-bold">{{ approvedCount }}</p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-lg text-center">
                        <h2 class="text-lg font-semibold text-yellow-700">
                            Pending
                        </h2>
                        <p class="text-2xl font-bold">{{ pendingCount }}</p>
                    </div>
                    <div class="bg-red-100 p-4 rounded-lg text-center">
                        <h2 class="text-lg font-semibold text-red-700">
                            Rejected
                        </h2>
                        <p class="text-2xl font-bold">{{ rejectedCount }}</p>
                    </div>
                </div>

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
                                <th
                                    class="py-4 px-6 text-left text-sm font-semibold uppercase"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in visApplicants"
                                :key="index"
                                class="hover:bg-gray-100 transition-all border-b"
                            >
                                <td class="py-4 px-6 text-gray-700">
                                    {{ item.first_name }} {{ item.surname }}
                                </td>
                                <td class="py-4 px-6 text-gray-600 capitalize">
                                    <span
                                        class="py-1 px-3 rounded-full text-xs font-medium"
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
                                <td class="py-4 px-6">
                                    <button
                                        v-if="item.status === 'Accepted'"
                                        class="text-blue-500 hover:underline"
                                        @click="downloadVisa(item)"
                                    >
                                        Download Proof
                                    </button>
                                    <button
                                        v-if="item.status === 'Pending'"
                                        class="text-yellow-500 hover:underline"
                                        @click="contactSupport(item)"
                                    >
                                        Contact Support
                                    </button>
                                    <button
                                        v-if="item.status === 'Rejected'"
                                        class="text-red-500 hover:underline"
                                        @click="reapply(item)"
                                    >
                                        Reapply
                                    </button>
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

        <div
            v-if="downloadingVisa"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        >
            <div
                class="bg-white w-[90%] md:w-[50%] p-6 rounded-lg shadow-lg relative"
            >
                <button
                    @click="closeDownloadModal"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700"
                >
                    ✖
                </button>
                <h2 class="text-xl font-bold mb-4 text-gray-800">
                    Download Proof
                </h2>
                <p class="text-gray-600 mb-4">
                    You are about to download the visa document for
                    <strong
                        >{{ downloadingVisa.first_name }}
                        {{ downloadingVisa.surname }}</strong
                    >.
                </p>
                <button
                    @click="generateVisaDocument"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-md"
                >
                    Confirm Download
                </button>
            </div>
        </div>

        <!-- Toast Notification -->
        <div
            v-if="showToast"
            class="fixed top-5 right-5 bg-green-500 text-white py-2 px-4 rounded-lg shadow-lg transition-all"
        >
            <p>{{ toastMessage }}</p>
        </div>

        <div class="min-h-screen bg-gray-100 py-12 px-6 sm:px-12">
            <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-6">
                <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">
                    Visa Approval and Delivery Instructions
                </h1>
                <div class="text-lg text-gray-700">
                    <!-- Conditional Section Based on Visa Status -->
                    <!-- <p class="mb-4">
                         Congratulations! Your
                        visa application has been successfully approved. Please
                        read through the following instructions carefully to
                        ensure the smooth delivery of your visa and travel
                        documents. @else Your visa is still under review. We
                        will notify you once it has been approved. In the
                        meantime, please ensure all details are accurate and
                        check back later for updates. @endif
                    </p> -->

                    <!-- Visa Details Section -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                            1. Visa Approval and Collection
                        </h2>
                        <p class="mb-4">
                            Once your visa has been approved, we will begin
                            processing your documents for delivery. It is
                            crucial that the information provided during the
                            application process, such as your full name,
                            passport number, and contact details, are accurate
                            to avoid delays or errors. @else Once approved, we
                            will begin the processing and shipment of your visa.
                            Ensure all your details are accurate to avoid
                            delays.
                        </p>
                        <p class="mb-4">
                            Please ensure you have completed the following steps
                            before the visa is dispatched:
                        </p>
                        <ul class="list-disc pl-5 mb-4">
                            <li class="mb-2">
                                Confirm your mailing address is correct.
                            </li>
                            <li class="mb-2">
                                Ensure all payment has been settled and
                                confirmed.
                            </li>
                            <li class="mb-2">
                                Provide any additional documentation if
                                requested by the consulate.
                            </li>
                        </ul>
                        <p class="mb-4">
                            If any of the above steps are pending, your visa may
                            experience a delay in being dispatched. @else Once
                            your visa is approved, these steps will be necessary
                            to begin the dispatch process.
                        </p>
                    </div>

                    <!-- Waybill and Delivery Information -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                            2. Waybill Information
                        </h2>
                        <p class="mb-4">
                            After the visa approval, we will create a waybill
                            for the safe delivery of your visa and travel
                            documents. The waybill will contain your personal
                            information, including your delivery address and
                            tracking details. @else Once your visa is approved,
                            we will prepare the waybill and share tracking
                            information with you.
                        </p>
                        <p class="mb-4">
                            Please keep the following in mind when receiving
                            your documents:
                        </p>
                        <ul class="list-disc pl-5 mb-4">
                            <li class="mb-2">
                                Track the shipment using the provided waybill
                                number.
                            </li>
                            <li class="mb-2">
                                Make sure someone is available to receive the
                                documents at the specified delivery address.
                            </li>
                            <li class="mb-2">
                                Verify the contents of the package upon arrival.
                                This should include your visa and any other
                                documents related to your travel.
                            </li>
                        </ul>
                        <p class="mb-4">
                            If you are unavailable at the time of delivery, the
                            courier will attempt to reach you or leave
                            instructions for re-delivery. @else The waybill and
                            tracking details will be provided once the visa is
                            approved.
                        </p>
                    </div>

                    <!-- Delivery Address Confirmation -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                            3. Delivery Address Confirmation
                        </h2>
                        <p class="mb-4">
                            It is vital that the address you provide is accurate
                            and current. If you need to update your delivery
                            address, please inform us immediately to prevent
                            delivery issues. The address you provided during the
                            application process is where your visa will be sent
                            unless you specify otherwise.
                        </p>
                        <p class="mb-4">
                            If you notice any issues with the address on the
                            waybill, please contact our customer support team to
                            rectify the details.
                        </p>
                        <p class="mb-4">
                            You can update your address by contacting us via:
                        </p>
                        <ul class="list-disc pl-5 mb-4">
                            <li class="mb-2">Email: support@example.com</li>
                            <li class="mb-2">Phone: +123-456-7890</li>
                            <li class="mb-2">
                                Website:
                                <a
                                    href="http://www.example.com"
                                    class="text-blue-600"
                                    >www.example.com</a
                                >
                            </li>
                        </ul>
                    </div>

                    <!-- Estimated Delivery Time -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                            4. Estimated Delivery Time
                        </h2>
                        <p class="mb-4">
                            The estimated delivery time for your visa and
                            documents depends on your location. After dispatch,
                            it typically takes 5-7 business days for domestic
                            deliveries and 7-10 business days for international
                            deliveries.
                        </p>
                        <p class="mb-4">
                            You will receive a tracking number along with a
                            delivery confirmation once the shipment is
                            dispatched, allowing you to monitor the delivery
                            progress.
                        </p>
                    </div>

                    <!-- Payment Confirmation -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                            5. Payment Confirmation
                        </h2>
                        <p class="mb-4">
                            Before your visa and documents are shipped, please
                            ensure that all payments, including visa fees,
                            courier charges, and any other applicable costs,
                            have been confirmed.
                        </p>
                        <p class="mb-4">
                            If you have already made a payment, please make sure
                            to keep your payment receipt for reference. If there
                            is any issue with the payment, please contact our
                            support team immediately.
                        </p>
                    </div>

                    <!-- Support and Assistance -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                            6. Support and Assistance
                        </h2>
                        <p class="mb-4">
                            If you need assistance at any point during the visa
                            approval or delivery process, our support team is
                            available to help. You can reach us via the
                            following channels:
                        </p>
                        <ul class="list-disc pl-5 mb-4">
                            <li class="mb-2">
                                Email:
                                <a
                                    href="mailto:support@example.com"
                                    class="text-blue-600"
                                    >support@example.com</a
                                >
                            </li>
                            <li class="mb-2">Phone: +123-456-7890</li>
                            <li class="mb-2">
                                Live Chat: Available on our website at
                                <a
                                    href="http://www.example.com"
                                    class="text-blue-600"
                                    >www.example.com</a
                                >
                            </li>
                        </ul>
                        <p class="mb-4">
                            Our team is ready to assist you with any concerns or
                            questions. We strive to make your visa application
                            and delivery process as smooth as possible.
                        </p>
                    </div>

                    <!-- Final Reminder -->
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                            7. Final Reminder
                        </h2>
                        <p class="mb-4">
                            Please keep all your travel documents, including the
                            visa, safe and secure. Double-check the details to
                            ensure everything is correct before your trip.
                        </p>
                        <p class="mb-4">
                            If you have any further questions or require
                            assistance, don't hesitate to contact us. We wish
                            you a safe and pleasant journey!
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <Footer />
    </div>
</template>

<script>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
import axios from "axios";
import jsPDF from "jspdf";

export default {
    components: { Header, Footer },
    data() {
        return {
            loading: true,
            visApplicants: [],
            approvedCount: 0,
            pendingCount: 0,
            rejectedCount: 0,
            downloadingVisa: null,
            showToast: false,
            toastMessage: "",
        };
    },
    methods: {
        fetchApplications() {
            this.loading = true;
            axios
                .get(route("user.fetch_application"))
                .then((res) => {
                    this.visApplicants = res.data.applications;
                    this.updateCounts();
                    this.loading = false;
                })
                .catch((err) => {
                    console.error("Error fetching applications:", err);
                    this.loading = false;
                });
        },
        updateCounts() {
            this.approvedCount = this.visApplicants.filter(
                (app) => app.status === "Accepted"
            ).length;
            this.pendingCount = this.visApplicants.filter(
                (app) => app.status === "Pending"
            ).length;
            this.rejectedCount = this.visApplicants.filter(
                (app) => app.status === "Rejected"
            ).length;
        },
        downloadVisa(visitor) {
            this.downloadingVisa = visitor;
        },
        closeDownloadModal() {
            this.downloadingVisa = null;
        },
        generateVisaDocument() {
            const visitor = this.downloadingVisa;
            if (!visitor) return;

            const doc = new jsPDF();
            doc.setFontSize(18);
            doc.text("Visa Document", 20, 20);
            doc.setFontSize(12);

            const content = [
                `Name: ${visitor.first_name} ${visitor.surname}`,
                `Email: ${visitor.email}`,
                `Residence: ${visitor.residence}`,
                `Marital Status: ${visitor.marital_status}`,
                `National ID: ${visitor.national_identity_number}`,
                `Travel Document: ${visitor.travel_document}`,
                `Journey Purpose: ${visitor.journey_purpose}`,
                `Arrival Date: ${visitor.arrival}`,
                `Departure Date: ${visitor.departure}`,
                `Status: ${visitor.status}`,
            ];

            content.forEach((line, index) => {
                doc.text(line, 20, 40 + index * 10);
            });

            doc.save(`${visitor.first_name}_${visitor.surname}_Visa.pdf`);

            this.showToast = true;
            this.toastMessage = `Visa for ${visitor.first_name} ${visitor.surname} downloaded successfully.`;
            setTimeout(() => {
                this.showToast = false;
                this.toastMessage = "";
            }, 3000);

            this.closeDownloadModal();
        },
        contactSupport(visitor) {
            alert(`Contacting support for application: ${visitor.first_name}`);
        },
        reapply(visitor) {
            alert(`Reapplying for: ${visitor.first_name}`);
        },
    },
    mounted() {
        this.fetchApplications();
    },
};
</script>
