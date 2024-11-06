document.addEventListener('DOMContentLoaded', () => {
    fetch('PHP/api/getVehicles.php')
        .then(response => response.json())
        .then(data => {
            const vehicleSelect = document.getElementById('vehicleSelect');
            vehicleSelect.innerHTML = data.map(vehicle => `<option value="${vehicle.id}">${vehicle.license_plate}</option>`).join('');
        });

    document.getElementById('bookingForm').addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);

        fetch('PHP/api/book.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('bookingStatus').textContent = data.message;
        });
    });
});
