import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Simple client-side geolocation helper reused by checkout & UMKM profile forms.
window.lokalinGetLocation = function (latInputId, lngInputId, statusElId) {
    const statusEl = statusElId ? document.getElementById(statusElId) : null;

    if (!navigator.geolocation) {
        if (statusEl) statusEl.textContent = 'Browser Anda tidak mendukung geolocation.';
        return;
    }

    if (statusEl) statusEl.textContent = 'Mengambil lokasi...';

    navigator.geolocation.getCurrentPosition(
        (position) => {
            document.getElementById(latInputId).value = position.coords.latitude;
            document.getElementById(lngInputId).value = position.coords.longitude;
            if (statusEl) statusEl.textContent = `Lokasi ditemukan (${position.coords.latitude.toFixed(5)}, ${position.coords.longitude.toFixed(5)})`;
        },
        (error) => {
            if (statusEl) statusEl.textContent = 'Gagal mengambil lokasi: ' + error.message;
        }
    );
};
