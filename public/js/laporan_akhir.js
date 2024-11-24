$(document).ready(function() {
    $('#laporanAkhirTable').DataTable();

    var modal = document.getElementById("laporanAkhirModal");
    var btn = document.getElementById("openModalBtn");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Menutup modal saat tombol 'X' diklik
    document.querySelector('.close').onclick = function() {
        document.getElementById('laporanAkhirModal').style.display = 'none';
    };

    // Menutup modal jika pengguna mengklik di luar konten modal
    window.onclick = function(event) {
        const modal = document.getElementById('laporanAkhirModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };

    // Daftar grup Kpop untuk autocomplete
    const kpopGroups = [
        "aespa", "BTS", "Blackpink", "EXO", "Red Velvet", "Twice", "ITZY", "Stray Kids", "TXT", "Seventeen", "Boy"
    ];

    $('#grupFavoritKpop').on('input', function() {
        let inputVal = $(this).val().toLowerCase();
        let suggestions = $('#suggestions');
        suggestions.empty().hide();  // Kosongkan dan sembunyikan dropdown

        if (inputVal) {
            let filteredGroups = kpopGroups.filter(group => group.toLowerCase().includes(inputVal));
            filteredGroups.forEach(group => {
                suggestions.append(`<div class="suggestion-item">${group}</div>`);
            });
            suggestions.show();
        }
    });

    // Menangani klik pada suggestion
    $(document).on('click', '.suggestion-item', function() {
        $('#grupFavoritKpop').val($(this).text());
        $('#suggestions').empty().hide();
    });
});
