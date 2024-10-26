document.addEventListener('DOMContentLoaded', function() {
    // Ambil base URL dari atribut data-baseurl pada body
    const baseUrl = document.body.getAttribute('data-baseurl');

    // Ambil elemen link "Ingat password Anda?"
    const registerLink = document.getElementById('register');

    // Tambahkan event listener pada link
    registerLink.addEventListener('click', function(event) {
        // Cegah link berpindah halaman seketika
        event.preventDefault();

        // Tambahkan kelas fade-out
        document.body.classList.add('fade-out');

        // Tunggu animasi selesai, lalu ganti halaman
        setTimeout(() => {
            // Arahkan ke halaman yang sesuai
            window.location.href = baseUrl + '/forgot_password';
        }, 500); // Durasi harus sama dengan durasi CSS transition
    });
});
