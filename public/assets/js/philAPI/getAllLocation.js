document.addEventListener("DOMContentLoaded", () => {
    const regionSelect = document.getElementById("region");
    const provinceSelect = document.getElementById("province");
    const muncitySelect = document.getElementById("muncity");
    const barangaySelect = document.getElementById("barangay");

    // Fetch regions on load
    fetch("/location/regions")
        .then(res => res.json())
        .then(data => {
            data.forEach(region => {
                const option = document.createElement("option");
                option.value = region.code;
                option.textContent = region.description;
                regionSelect.appendChild(option);
            });
        });

    // Fetch provinces on region change
    regionSelect.addEventListener("change", () => {
        provinceSelect.innerHTML = '<option disabled selected value="">Select Province</option>';
        muncitySelect.innerHTML = '<option disabled selected value="">Select Municipality/City</option>';
        barangaySelect.innerHTML = '<option disabled selected value="">Select Barangay</option>';

        fetch(`/location/province?region_code=${regionSelect.value}`)
            .then(res => res.json())
            .then(data => {
                data.forEach(province => {
                    const option = document.createElement("option");
                    option.value = province.code;
                    option.textContent = province.description;
                    provinceSelect.appendChild(option);
                });
            });
    });

    // Fetch municipalities/cities on province change
    provinceSelect.addEventListener("change", () => {
        muncitySelect.innerHTML = '<option disabled selected value="">Select Municipality/City</option>';
        barangaySelect.innerHTML = '<option disabled selected value="">Select Barangay</option>';

        fetch(`/location/muncity?province_code=${provinceSelect.value}`)
            .then(res => res.json())
            .then(data => {
                data.forEach(city => {
                    const option = document.createElement("option");
                    option.value = city.muncity_id;
                    option.textContent = city.description;
                    muncitySelect.appendChild(option);
                });
            });
    });

    // Fetch barangays on muncity change
    muncitySelect.addEventListener("change", () => {
        barangaySelect.innerHTML = '<option disabled selected value="">Select Barangay</option>';

        fetch(`/location/barangay?muncity_id=${muncitySelect.value}`)
            .then(res => res.json())
            .then(data => {
                data.forEach(barangay => {
                    const option = document.createElement("option");
                    option.value = barangay.muncity_id;
                    option.textContent = barangay.description;
                    barangaySelect.appendChild(option);
                });
            });
    });
});