<template>
    <div class="max-w-4xl p-8 mx-auto">
        <!-- Logo and Main Header Section -->
        <div class="mb-8 text-center">
            <img src="/images/logo2.png" alt="Nurses Council Logo" class="mx-auto mb-4" style="width: 100px;" />
            <h1 class="text-lg font-bold">NURSES AND MIDWIVES COUNCIL OF MALAWI</h1>
            <h2 class="mt-2 font-bold text-md">LICENSING EXAMINATION FOR NURSING AND MIDWIFERY TECHNICIAN</h2>
            <h3 class="mt-2 font-bold underline text-md">MIDWIFERY PAPER ONE</h3>
        </div>

        <!-- Date and Time Section -->
        <div class="flex justify-between mb-6">
            <div class="font-bold">DATE: __________</div>
            <div class="font-bold">TIME: 8:00 A.M – 11:00 A.M</div>
        </div>

        <!-- Candidates Instructions Section -->
        <h3 class="mb-4 font-bold text-md">CANDIDATES INSTRUCTIONS</h3>
        <ol class="pl-6 space-y-2 text-justify list-decimal">
            <li>
                Write your <span class="italic">examination number</span> in the space provided for this purpose at the top of each page.
            </li>
            <li>
                This paper has <span class="font-bold">100</span> multiple-choice questions contained in 
                <span class="font-bold underline">55 pages</span> divided into five <span class="font-bold">Sections</span>.
            </li>
            <li>Each item is worth one mark.</li>
            <li>You must answer all the questions.</li>
            <li>
                Using a <span class="font-bold">pencil</span>, choose the <span class="font-bold">most correct</span> answer to the question by circling the letter that stands at the beginning of the option you have chosen.
            </li>
            <li>Follow the separate instructions that relate to specific questions wherever they appear.</li>
            <li>
                Do not turn over this page until you have been instructed by the invigilator to do so.
            </li>
            <li>
                Cheating is not allowed. If caught, you will be disqualified.
            </li>
        </ol>

        <!-- For Official Use Table -->
        <h3 class="mt-8 font-bold text-md">FOR OFFICIAL USE ONLY</h3>
        <table class="w-full mt-4 text-center border border-black table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2 border border-black">SECTION</th>
                    <th class="px-4 py-2 border border-black">TOTAL SCORE</th>
                    <th class="px-4 py-2 border border-black">SCORE OBTAINED</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="section in sections" :key="section.name">
                    <td class="px-4 py-2 border border-black">{{ section.name }}</td>
                    <td class="px-4 py-2 border border-black">{{ section.totalScore }}</td>
                    <td class="px-4 py-2 border border-black">{{ section.scoreObtained }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td class="px-4 py-2 font-bold border border-black">TOTAL</td>
                    <td class="px-4 py-2 font-bold border border-black">100</td>
                    <td class="px-4 py-2 font-bold border border-black">__________</td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script setup>
const sections = [
    { name: "1 (ANC)", totalScore: 19, scoreObtained: "" },
    { name: "2 (L&D)", totalScore: 46, scoreObtained: "" },
    { name: "3 (PNC)", totalScore: 20, scoreObtained: "" },
    { name: "4 (NNC)", totalScore: 10, scoreObtained: "" },
    { name: "5 (COM)", totalScore: 5, scoreObtained: "" }
];
</script>

<style scoped>
/* Adjust any custom styles here */
</style>
