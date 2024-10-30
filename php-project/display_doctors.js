const formEl = document.querySelector("form");
const inputEl = document.getElementById("search-input");
const searchResults = document.querySelector(".search-results");
const introductoryText = document.getElementById("introductory-text");


async function searchDoctors() {
    const inputData = inputEl.value;
    const url = `display_doctors.php`;

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
    
    displayDoctors(data);
}

function displayDoctors(results) {
    // Clear previous results
    searchResults.innerHTML = "";

    // Process and display results
    results.forEach((doctor) => {
        const doctorWrapper = document.createElement("div");
        doctorWrapper.classList.add("search-result");

        const doctorImage = document.createElement("img");
        doctorImage.src = doctor.userPhoto; 

        const doctorName = document.createElement("h2");
        doctorName.textContent = `Dr. ${doctor.first_name} ${doctor.last_name}`;

        const doctorEmail = document.createElement("p");
        doctorEmail.textContent = `Email: ${doctor.email}`;

        const doctorContact = document.createElement("p");
        doctorContact.textContent = `Contact No: ${doctor.contact_number}`;

        const doctorSpecialization = document.createElement("p");
        doctorSpecialization.textContent = `Specialisation: ${doctor.specialization}`;

        

        doctorWrapper.appendChild(doctorImage);
        doctorWrapper.appendChild(doctorName);
        doctorWrapper.appendChild(doctorEmail);
        doctorWrapper.appendChild(doctorContact);
        doctorWrapper.appendChild(doctorSpecialization);

        searchResults.appendChild(doctorWrapper);
    });
}

formEl.addEventListener("submit", async (event) => {
    event.preventDefault();
    await searchDoctors();
});
