<aside>
    <div class="toggle">
        <div class="logo">
            <img src="<?= base_url('images/Logo Web Fortuna.png'); ?>" alt="Logo Web Fortuna">
            <a href="<?= site_url('/dashboard'); ?>" class="<?= uri_string() == 'dashboard' ? 'active' : ''; ?>">
                <h2>Penta<span class="web">Dosen</span></h2>
            </a>
        </div>
        <div class="close" id="close-btn">
            <span class="material-icons-sharp">close</span>
        </div>
    </div>

    <div class="sidebar">
        <?php
        // Mendapatkan user_type dari session
        $user_type = session()->get('user_type');
        ?>

        <?php if ($user_type == 'admin' || $user_type == 'fakultas'): ?>
            <!-- Menu untuk Admin dan Fakultas -->
            <a href="<?= site_url('/kalender'); ?>" class="<?= uri_string() == 'kalender' ? 'active' : ''; ?>">
                <span class="material-icons-sharp">event</span>
                <h3>Kalender</h3>
            </a>
            <a href="<?= site_url('/proposal_penelitian'); ?>" class="<?= uri_string() == 'proposal_penelitian' ? 'active' : ''; ?>">
                <span class="material-icons-sharp">receipt_long</span>
                <h3>Penelitian</h3>
            </a>
            <a href="<?= site_url('/publikasi'); ?>" class="<?= uri_string() == 'publikasi' ? 'active' : ''; ?>">
                <span class="material-icons-sharp">book</span>
                <h3>Publikasi</h3>
            </a>
            <a href="<?= site_url('/haki'); ?>" class="<?= uri_string() == 'haki' ? 'active' : ''; ?>">
                <span class="material-icons-sharp">import_contacts</span>
                <h3>HKI</h3>
            </a>
        <?php endif; ?>

        <?php if ($user_type == 'dosen'): ?>
            <!-- Menu untuk Dosen -->
            <a href="<?= site_url('/kalender'); ?>" class="<?= uri_string() == 'kalender' ? 'active' : ''; ?>">
                <span class="material-icons-sharp">event</span>
                <h3>Kalender</h3>
            </a>
            <a href="<?= site_url('/proposal_penelitian'); ?>" class="<?= uri_string() == 'proposal_penelitian' ? 'active' : ''; ?>">
                <span class="material-icons-sharp">receipt_long</span>
                <h3>Penelitian</h3>
            </a>
            <a href="<?= site_url('/publikasi'); ?>" class="<?= uri_string() == 'publikasi' ? 'active' : ''; ?>">
                <span class="material-icons-sharp">book</span>
                <h3>Publikasi</h3>
            </a>
            <a href="<?= site_url('/haki'); ?>" class="<?= uri_string() == 'haki' ? 'active' : ''; ?>">
                <span class="material-icons-sharp">import_contacts</span>
                <h3>HKI</h3>
            </a>
        <?php endif; ?>

        <a href="registerlogincontroller/logout">
            <span class="material-icons-sharp">logout</span>
            <h3>Keluar</h3>
        </a>
    </div>
</aside>