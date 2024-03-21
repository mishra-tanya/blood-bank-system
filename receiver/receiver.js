document.addEventListener('DOMContentLoaded', function() {
    const hospitalSearchInput = document.getElementById('hospitalSearch');
    const bloodTypeSearchInput = document.getElementById('bloodTypeSearch');
    const expirationDateSearchInput = document.getElementById('expirationDateSearch');

    hospitalSearchInput.addEventListener('input', handleSearch);
    bloodTypeSearchInput.addEventListener('input', handleSearch);
    expirationDateSearchInput.addEventListener('input', handleSearch);

    function handleSearch() {
        const hospitalQuery = hospitalSearchInput.value.toLowerCase();
        const bloodTypeQuery = bloodTypeSearchInput.value.toLowerCase();
        const expirationDateQuery = expirationDateSearchInput.value.toLowerCase();

        const rows = document.querySelectorAll('.data-row');
        rows.forEach(row => {
            const hospitalText = row.querySelector('.hospital').textContent.toLowerCase();
            const bloodTypeText = row.querySelector('.blood-type').textContent.toLowerCase();
            const expirationDateText = row.querySelector('.expiration-date').textContent.toLowerCase();

            if (hospitalText.includes(hospitalQuery) &&
                bloodTypeText.includes(bloodTypeQuery) &&
                expirationDateText.includes(expirationDateQuery)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

    }
});