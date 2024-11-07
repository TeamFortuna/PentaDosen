document.addEventListener("DOMContentLoaded", function () {
    const eventStartInput = document.getElementById("eventStart");
    const eventEndInput = document.getElementById("eventEnd");

    // Set minimum date pada tanggal mulai agar tidak bisa pilih sebelum hari ini
    const today = new Date().toISOString().split("T")[0];
    eventStartInput.setAttribute("min", today);

    eventStartInput.addEventListener("change", function () {
        eventEndInput.setAttribute("min", eventStartInput.value);
    });

    eventEndInput.addEventListener("change", function () {
        if (eventEndInput.value < eventStartInput.value) {
            alert("Tanggal selesai tidak boleh sebelum tanggal mulai.");
            eventEndInput.value = ""; 
        }
    });

    window.addEvent = function () {
        var title = document.getElementById("eventTitle").value;
        var description = document.getElementById("eventDescription").value;
        var start = eventStartInput.value;
        var end = eventEndInput.value;

        if (title && start) {
            calendar.addEvent({
                title: title,
                start: start,
                end: end ? end : start,
                extendedProps: {
                    description: description  // Menyimpan deskripsi dalam properti tambahan
                }
            });
            closeEventForm();
            document.getElementById("eventForm").reset();
        } else {
            alert("Judul dan tanggal mulai wajib diisi");
        }
    };
});

function openEventForm() {
    document.getElementById("eventForm").style.display = "block";
    document.querySelector(".modal-overlay").style.display = "block";
}

function closeEventForm() {
    document.getElementById("eventForm").style.display = "none";
    document.querySelector(".modal-overlay").style.display = "none";
}

// Fungsi untuk menampilkan detail acara
function showEventDetails(event) {
    document.getElementById("modalEventTitle").innerText = event.title;
    document.getElementById("modalEventDescription").innerText = event.extendedProps.description || "Tidak ada deskripsi";
    document.getElementById("modalEventStart").innerText = event.start.toLocaleDateString();
    document.getElementById("modalEventEnd").innerText = event.end ? event.end.toLocaleDateString() : "Tidak ada tanggal selesai";

    document.getElementById("eventDetailModal").style.display = "block";
}

// Fungsi untuk menutup modal detail acara
function closeEventDetailModal() {
    document.getElementById("eventDetailModal").style.display = "none";
}
