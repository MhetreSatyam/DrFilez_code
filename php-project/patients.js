const formEl = document.querySelector("#search-form");
const inputEl = document.getElementById("search-input");
const searchResults = document.querySelector(".search-results");

async function searchPatients() {
    const inputData = inputEl.value;
    const url = `searchPatients.php`;

    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'search_term': inputData,
        }),
    });

    const data = await response.json();
    displayPatients(data);
}

function displayPatients(results) {
    // Clear previous results
    searchResults.innerHTML = "";

    // Process and display results
    results.forEach((patient) => {
        const detailsContainer = document.createElement("div");
        detailsContainer.classList.add("details");

        const recentOrdersContainer = document.createElement("div");
        recentOrdersContainer.classList.add("recentOrders");

        const table = document.createElement("table");

        const userPhotoTd = document.createElement("td");
        userPhotoTd.setAttribute("rowspan", "8");
        userPhotoTd.style.verticalAlign = "top";

        const userPhotoDiv = document.createElement("div");
        userPhotoDiv.id = "userPhoto"; // Assuming 'photo' is the property in your patient object
        userPhotoDiv.innerHTML = `<img src="${patient.photo}" alt="User Photo">`;

        userPhotoTd.appendChild(userPhotoDiv);

        const nameRow = createDetailRow("Name:", "name", patient.name);
        const idRow = createDetailRow("ID:", "username", patient.id);
        const dobRow = createDetailRow("Date of Birth:", "dob", patient.dob);
        const ageRow = createDetailRow("Age:", "age", patient.age);
        const genderRow = createDetailRow("Gender:", "gender", patient.gender);
        const bloodGroupRow = createDetailRow("Blood Group:", "bloodGroup", patient.bloodGroup);
        const contactRow = createDetailRow("Contact Number:", "contact_number", patient.contactNumber);
        const aadharRow = createDetailRow("Aadhar Number:", "aadhar_number", patient.aadharNumber);
        const emContactRow = createDetailRow("Emergency Contact Number:", "emergency_contact", patient.emergencyContact);
        const addressRow = createDetailRow("Address:", "address", patient.address);
        const medicalHistoryRow = createDetailRow("Medical History:", "medical_history", patient.medicalHistory);
        const prescriptionRow = createDetailRow("Doctor's Prescription:", "prescription", patient.doctorPrescription);
        const insuranceRow = createDetailRow("Health Insurance:", "insurance", patient.healthInsurance);
        const insuranceProofRow = createDetailRow("Health Insurance Proof:", "insurance_proof", patient.insuranceProof);
        const additionalInfoRow = createDetailRow("Additional Info:", "additional_info", patient.additionalInfo);

        appendRowsToTable(table, [userPhotoTd, nameRow, idRow, dobRow, ageRow, genderRow, bloodGroupRow, contactRow,
            aadharRow, emContactRow, addressRow, medicalHistoryRow, prescriptionRow, insuranceRow, insuranceProofRow, additionalInfoRow]);

        const editInfoRow = document.createElement("tr");
        const editInfoTd = document.createElement("td");
        editInfoTd.colSpan = "3";

        const editInfoLink = document.createElement("a");
        editInfoLink.href = "editPatients.html";
        editInfoLink.style.textDecoration = "none";
        editInfoLink.style.marginRight = "45%";

        const editInfoButton = document.createElement("button");
        editInfoButton.classList.add("my-button");
        editInfoButton.textContent = "Edit Information";

        editInfoLink.appendChild(editInfoButton);
        editInfoTd.appendChild(editInfoLink);
        editInfoRow.appendChild(editInfoTd);

        table.appendChild(editInfoRow);

        recentOrdersContainer.appendChild(table);
        detailsContainer.appendChild(recentOrdersContainer);
        searchResults.appendChild(detailsContainer);
    });
}

function createDetailRow(label, id, value) {
    const row = document.createElement("tr");

    const labelTd = document.createElement("td");
    labelTd.textContent = label;

    const valueTd = document.createElement("td");
    valueTd.id = id;
    valueTd.textContent = value;

    row.appendChild(labelTd);
    row.appendChild(valueTd);

    return row;
}

function appendRowsToTable(table, rows) {
    rows.forEach((row) => {
        table.appendChild(row);
    });
}

formEl.addEventListener("submit", async (event) => {
    event.preventDefault();
    await searchPatients();
});
