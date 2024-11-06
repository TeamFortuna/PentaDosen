<!-- Right Section -->
<div class="right-section">
    <div class="nav">
        <button id="menu-btn">
            <span class="material-icons-sharp">menu</span>
        </button>
        <div class="dark-mode">
            <span class="material-icons-sharp active">light_mode</span>
            <span class="material-icons-sharp">dark_mode</span>
        </div>

        <div class="profile">
            <div class="info">
                <p>Hello, <b><?= session()->get('nama') ? session()->get('nama') : 'Guest'; ?></b></p>
                <small class="text-muted"><?= session()->get('user_type'); ?></small>
            </div>
            <div class="profile-photo">
                <img src="<?= base_url('images/Logo Web Fortuna.png'); ?>" alt="Logo Web Fortuna">
            </div>
        </div>
    </div>
</div>
<!-- End of Nav -->