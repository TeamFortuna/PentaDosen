<!-- Sidebar -->
<div class="sidebar w-64 bg-white shadow-lg flex flex-col h-full" id="sidebar">
    <!-- Logo and Toggle -->
    <div class="p-4 flex items-center justify-between border-b">
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-lg bg-indigo-500 flex items-center justify-center text-white mr-3">
                <i class="fas fa-tachometer text-xl"></i>
            </div>
            <h1 class="text-xl font-bold text-indigo-600">Penta Dosen</h1>
        </div>
        <button class="menu-toggle md:hidden text-gray-500" id="closeSidebar">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Menu -->
    <div class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-1 px-4">
            <li>
                <a href="<?= site_url('dashboard') ?>" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-indigo-600 font-medium <?= (current_url() == site_url('dashboard')) ? 'active text-indigo-600' : '' ?>">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="<?= site_url('kalender') ?>" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-indigo-600 font-medium <?= (current_url() == site_url('kalender')) ? 'active text-indigo-600' : '' ?>">
                    <i class="far fa-calendar-alt mr-3"></i>
                    Kalender
                </a>
            </li>
            <li>
                <a href="<?= site_url('penelitian') ?>" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-indigo-600 font-medium <?= (current_url() == site_url('penelitian')) ? 'active text-indigo-600' : '' ?>">
                    <i class="fas fa-microscope mr-3"></i>
                    Penelitian
                </a>
            </li>
            <li>
                <a href="<?= site_url('publikasi') ?>" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-indigo-600 font-medium <?= (current_url() == site_url('publikasi')) ? 'active text-indigo-600' : '' ?>">
                    <i class="fas fa-book-open mr-3"></i>
                    Publikasi
                </a>
            </li>
            <li>
                <a href="<?= site_url('hki') ?>" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-indigo-600 font-medium <?= (current_url() == site_url('hki')) ? 'active text-indigo-600' : '' ?>">
                    <i class="fas fa-lightbulb mr-3"></i>
                    HKI
                </a>
            </li>
        </ul>
    </div>


    <!-- User Profile -->
    <div class="p-4 border-t">
        <div class="flex items-center">
            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User" class="w-10 h-10 rounded-full mr-3">
            <div>
                <p class="font-medium text-gray-800"><?= $user['nama'] ?></p>
                <p class="text-xs text-gray-500">Dosen <?= $user['jurusan'] ?></p>
            </div>
        </div>
        <a href="<?= site_url('logout') ?>" class="mt-3 w-full py-2 px-4 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition duration-200 inline-block text-center">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
    </div>
</div>