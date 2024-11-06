const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

function showNextPart() {
    const part1 = document.getElementById('part1');
    const part2 = document.getElementById('part2');
    
    // Hapus kelas animasi terlebih dahulu (jika ada)
    part1.classList.remove('fade-in', 'fade-out');
    part2.classList.remove('fade-in', 'fade-out');
    
    // Tambahkan kelas fade-out ke bagian pertama
    part1.classList.add('fade-out');

    // Tunggu sampai animasi selesai untuk beralih
    setTimeout(() => {
        part1.style.display = 'none';  // Sembunyikan bagian pertama
        part1.classList.remove('fade-out'); // Reset kelas animasi

        // Tampilkan bagian kedua dengan animasi fade-in
        part2.style.display = 'block';
        part2.classList.add('fade-in');

        // Hapus kelas fade-in setelah animasi selesai
        setTimeout(() => part2.classList.remove('fade-in'), 500);
    }, 500);
}

function showPreviousPart() {
    const part1 = document.getElementById('part1');
    const part2 = document.getElementById('part2');
    
    // Hapus kelas animasi terlebih dahulu (jika ada)
    part1.classList.remove('fade-in', 'fade-out');
    part2.classList.remove('fade-in', 'fade-out');

    // Tambahkan kelas fade-out ke bagian kedua
    part2.classList.add('fade-out');

    // Tunggu sampai animasi selesai untuk beralih
    setTimeout(() => {
        part2.style.display = 'none';  // Sembunyikan bagian kedua
        part2.classList.remove('fade-out'); // Reset kelas animasi

        // Tampilkan bagian pertama dengan animasi fade-in
        part1.style.display = 'block';
        part1.classList.add('fade-in');

        // Hapus kelas fade-in setelah animasi selesai
        setTimeout(() => part1.classList.remove('fade-in'), 500);
    }, 500);
}


