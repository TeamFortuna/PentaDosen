const sideMenu = document.querySelector('aside');
const menuBtn = document.getElementById('menu-btn');
const closeBtn = document.getElementById('close-btn');
const darkMode = document.querySelector('.dark-mode');

// Cek status dark mode dari localStorage saat halaman dimuat
if (localStorage.getItem('darkMode') === 'enabled') {
    document.documentElement.classList.add('dark-mode-variables');
    darkMode.querySelector('span:nth-child(1)').classList.remove('active');
    darkMode.querySelector('span:nth-child(2)').classList.add('active');
} else {
    document.documentElement.classList.remove('dark-mode-variables');
    darkMode.querySelector('span:nth-child(1)').classList.add('active');
    darkMode.querySelector('span:nth-child(2)').classList.remove('active');
}

// Fungsi untuk mengaktifkan dark mode
const enableDarkMode = () => {
    document.documentElement.classList.add('dark-mode-variables');
    localStorage.setItem('darkMode', 'enabled');
    darkMode.querySelector('span:nth-child(1)').classList.remove('active');
    darkMode.querySelector('span:nth-child(2)').classList.add('active');
}

// Fungsi untuk menonaktifkan dark mode
const disableDarkMode = () => {
    document.documentElement.classList.remove('dark-mode-variables');
    localStorage.setItem('darkMode', 'disabled');
    darkMode.querySelector('span:nth-child(1)').classList.add('active');
    darkMode.querySelector('span:nth-child(2)').classList.remove('active');
}

// Event listener untuk tombol dark mode
darkMode.addEventListener('click', () => {
    if (localStorage.getItem('darkMode') === 'enabled') {
        disableDarkMode();
    } else {
        enableDarkMode();
    }
});

// Event listener untuk tombol menu
menuBtn.addEventListener('click', () => {
    sideMenu.style.display = 'block';
});

// Event listener untuk tombol close
closeBtn.addEventListener('click', () => {
    sideMenu.style.display = 'none';
});