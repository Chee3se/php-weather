import React from 'react';

const WeatherCard = ({ city, avg, max, min }) => {
    return (
        <div className="weather-card">
            <div className="weather-info">
                <h2>{city}</h2>
                <p>Avg: {avg}°C</p>
                <p>Max: {max}°C</p>
                <p>Min: {min}°C</p>
            </div>
        </div>
    );
};

export default WeatherCard;
