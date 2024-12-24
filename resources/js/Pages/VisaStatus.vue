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
                                        Download Visa
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
                    Download Visa
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
