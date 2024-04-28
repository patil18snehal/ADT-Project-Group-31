document.addEventListener("DOMContentLoaded", function() {
    const zoneSelect = document.getElementById("zone");
    const stateSelect = document.getElementById("state");

    // Fetch zones from database
    fetch("fetch_zones_states.php")
        .then(response => response.json())
        .then(data => {
            data.zones.forEach(zone => {
                const option = new Option(zone, zone);
                zoneSelect.add(option);
            });
        })
        .catch(error => console.error("Error fetching zones:", error));

    // Add event listener for zone change
    zoneSelect.addEventListener("change", function() {
        const selectedZone = this.value;
        stateSelect.disabled = true; // Disable state select until states are fetched

        // Fetch states based on selected zone
        fetch("fetch_zones_states.php", {
            method: "POST",
            body: JSON.stringify({ zone: selectedZone }),
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            stateSelect.innerHTML = '<option value="">Select State</option>';
            data.states.forEach(state => {
                const option = new Option(state, state);
                stateSelect.add(option);
            });
            stateSelect.disabled = false; // Enable state select after fetching states
        })
        .catch(error => console.error("Error fetching states:", error));
    });
});
