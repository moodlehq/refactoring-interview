<?php

namespace MyApp\Models\Location;

/**
 * Class Location
 *
 * Represents an Location.
 */
class Location {

    /**
     * @var string Location name.
     */
    private string $name;

    /**
     * @var float Location latitude.
     */
    private float $latitude;

    /**
     * @var float Location longitude.
     */
    private float $longitude;
    
    /**
     * Location constructor.
     *
     * @param string $name Location name.
     * @param float $latitude The name of the location.
     * @param float $longitude The name of the location.
     */
    public function __construct(
        string $name='', 
        float $latitude=0.0, 
        float $longitude=0.0
    ) {
        $this->name = $name;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
    
    /**
     * Get name of the location.
     *
     * @return string Name of the location
     */
    public function getName(): string {
        return $this->name;
    }
    
    /**
     * Get Latitude of location.
     *
     * @return float Latitude of location.
     */
    public function getLatitude(): float {
        return $this->latitude;
    }
    
    /**
     * Get Longitude of location.
     *
     * @return float Longitude of location.
     */
    public function getLongitude(): float {
        return $this->longitude;
    }

    /**
     * Convert to array.
     *
     * @return array Convert to array.
     */
    public function toArray(): array {
        return [
            'location_name' => $this->getName(),
            'location_longitude' => $this->getLongitude(),
            'location_latitude' => $this->getLatitude(),
        ];
    }
    
    /**
     * Get location as a string.
     *
     * @return string location as string.
     */
    public function __toString(): string {
        return $this->name . " (Lat: " . $this->latitude . ", Lon: " . $this->longitude . ")";
    }
}
