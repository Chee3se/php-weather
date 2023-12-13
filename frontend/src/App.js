import React, { useEffect, useState } from "react";
import WeatherCard from "./WeatherCard";
import LoadingSpinner from "./LoadingSpinner";

function App() {
  const [weather, setWeather] = useState({});
  const [loading, setLoading] = useState(true);
  const [city, setCity] = useState("Cesis");

  useEffect(() => {
    async function getData() {
      // Requesting data from the backend
      const formData = new FormData();
      formData.append('city', city);
      const response = await fetch("http://localhost", {
        method: "POST",
        body: formData
      });

      // Saving the response to the state
      const data = await response.json();
      setWeather(data);
      setLoading(false);
    }
    getData();
  }, [city]);

  const handleCityChange = (event) => {
    setCity(event.target.value);
  };

  return (
    <div className="App">
      <h1>Weather App</h1>
      <input type="text" value={city} onChange={handleCityChange} />
      {loading ? (
        <LoadingSpinner />
      ) : weather.status === 200 ? (
        <WeatherCard weather={weather.response} />
      ) : (
        <p>{weather.message}</p>
      )}
    </div>
  );
}

export default App;
