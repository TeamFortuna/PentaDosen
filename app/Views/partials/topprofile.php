<div class="profile-container">
    <div class="nav">
        <button id="menu-btn">
            <span class="material-icons-sharp">menu</span>
        </button>
        <div id="dark-mode" class="dark-mode">
            <span class="material-icons-sharp active">light_mode</span>
            <span class="material-icons-sharp">dark_mode</span>
        </div>
        <div class="profile">
            <div class="profile-text">
                <p>Hai, <b><?= session()->get('nama') ? session()->get('nama') : 'Guest'; ?></b></p>
                <small class="text-muted"><?= session()->get('user_type'); ?></small>
            </div>
            <div class="profile-photo">
                <a href="<?= base_url('profile'); ?>">
                    <img src="<?= base_url('images/Logo Web Fortuna.png'); ?>" alt="Logo Web Fortuna">
                </a>
            </div>
        </div>
    </div>
</div>