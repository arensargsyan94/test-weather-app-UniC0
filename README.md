Weather Forecast App

This project is a simple weather forecast application that allows users to search for cities and view the current weather conditions, including temperature, weather conditions, and wind speed. The app also includes a login and signup functionality, along with different search modes for guest users and logged-in users.

Features
1. City Search:
   Users can search for a city by name.
   The app displays the current temperature, weather conditions, and wind speed for the selected city.
   The search results are shown in both Celsius and Fahrenheit, depending on the user's selected unit of measurement.
2. Unit Switch:
   Users can toggle between Celsius and Fahrenheit units for temperature measurement.
3. API Integration:
   The app integrates with the OpenWeatherMap API to fetch real-time weather data.
4. Error Handling:
   The app displays appropriate error messages when:
   The city is not found.
   The API call fails due to issues such as network connectivity.
5. Recent Searches:
   For logged-in users: The app stores and displays the last five cities searched.
   For guest users: No search history is saved, and the feature is unavailable until the user logs in.
6. User Authentication:
   The app includes a login and signup feature.
   Logged-in users can view and store their recent searches, while guest users cannot access this functionality.
   Secure authentication ensures users can create an account and log in with their credentials.
7. Search Modes:
   Guest Mode: Allows searching for cities without logging in. Guest users cannot see their search history.
   Logged-In Mode: Allows users to view and manage their search history (last 5 cities searched).
