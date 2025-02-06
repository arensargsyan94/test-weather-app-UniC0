let unit = 'metric';

function toggleUnit() {
    unit = unit === 'metric' ? 'imperial' : 'metric';
    document.getElementById('unit-toggle').innerText = unit === 'metric' ? 'Switch to °F' : 'Switch to °C';
    searchWeather();
}

function searchWeather() {
    let cityInputGuest = document.getElementById('guest-search');
    let cityInputDashboard = document.getElementById('city-input');
    let city = cityInputGuest ? cityInputGuest.value.trim() : (cityInputDashboard ? cityInputDashboard.value.trim() : '');

    if (!city) {
        showError("Please enter a city name.");
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let weatherResult = document.getElementById('weather-result');

    if (!weatherResult) {
        console.error("Weather result container not found.");
        return;
    }

    weatherResult.style.display = 'none';
    weatherResult.innerHTML = '';

    fetch('/search', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({city: city, unit: unit})
    })
        .then(response => {
            const contentType = response.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                throw new Error("Unexpected response from server. Please check the network tab.");
            }
            return response.json();
        })
        .then(data => {
            if (!data || !data.name) {
                throw new Error("City not found");
            }
            displayWeather(data);
            if (typeof isLoggedIn !== "undefined" && isLoggedIn) {
                saveSearchHistory(data);
                updateSearchHistory();
            }
        })
        .catch(error => {
            console.error("Error:", error);
            showError(error.message || "An error occurred. Please try again.");
        });
}

function displayWeather(data) {
    let weatherResult = document.getElementById('weather-result');

    if (!weatherResult) {
        console.error("Weather result container not found.");
        return;
    }

    weatherResult.innerHTML = `
        <h3 id="weather-city">${data.name}</h3>
        <p>🌡️ Temperature: <span id="weather-temp">${data.main.temp}</span><span id="unit-symbol">${unit === 'metric' ? '°C' : '°F'}</span></p>
        <p>🌥️ Condition: <span id="weather-condition">${data.weather[0].description}</span></p>
        <p>💨 Wind Speed: <span id="weather-wind">${data.wind.speed}</span> m/s</p>
        <button id="unit-toggle" onclick="toggleUnit()">Switch to ${unit === 'metric' ? '°F' : '°C'}</button>
    `;

    weatherResult.style.display = 'block';
}

function showError(message) {
    let weatherResult = document.getElementById('weather-result');

    if (!weatherResult) {
        console.error("Weather result container not found.");
        return;
    }

    weatherResult.innerHTML = `<p class="error-message">${message}</p>`;
    weatherResult.style.display = 'block';
}

function saveSearchHistory(data) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch('/save-search', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            city: data.name,
            temperature: data.main.temp,
            condition: data.weather[0].description,
            wind_speed: data.wind.speed
        })
    })
        .catch(error => console.error("Search save error:", error));
}

function updateSearchHistory() {
    fetch('/history')
        .then(response => response.json())
        .then(data => {
            let historyTable = document.querySelector('.history-table tbody');
            if (!historyTable) {
                console.warn("Search history table not found.");
                return;
            }
            historyTable.innerHTML = '';

            data.forEach(search => {
                let condition = search.weather_condition ? search.weather_condition : 'N/A'; // Avoid undefined
                let searchTime = search.created_at ? new Date(search.created_at).toLocaleString() : 'N/A'; // Format time
                let row = `<tr>
                    <td>${search.city ? search.city : 'Unknown'}</td>
                    <td>${search.temperature !== undefined && search.temperature !== null ? search.temperature + '°' + (unit === 'metric' ? 'C' : 'F') : 'N/A'}</td>
                    <td>${search.weather_condition && search.weather_condition !== 'undefined' ? search.weather_condition : 'N/A'}</td>
                    <td>${search.wind_speed !== undefined && search.wind_speed !== null ? search.wind_speed + ' m/s' : 'N/A'}</td>
                    <td>${search.created_at ? new Date(search.created_at).toLocaleString() : 'N/A'}</td>
                </tr>`;
                historyTable.innerHTML += row;
            });
        })
        .catch(error => console.error("History fetch error:", error));
}
