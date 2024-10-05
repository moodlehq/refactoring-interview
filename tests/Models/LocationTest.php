<?php

use PHPUnit\Framework\TestCase;
use MyApp\Models\Location\Location;

/**
 * Class LocationTest
 *
 * Unit tests for the Location class.
 */
class LocationTest extends TestCase
{
    private Location $location;

    protected function setUp(): void
    {
        // Initialize a Location object for testing
        $this->location = new Location('New York', 40.7128, -74.0060);
    }

    // Test the constructor and getter methods
    public function testLocationCreation()
    {
        // Assert that the name is set correctly
        $this->assertEquals('New York', $this->location->getName());

        // Assert that latitude and longitude are set correctly
        $this->assertEquals(40.7128, $this->location->getLatitude());
        $this->assertEquals(-74.0060, $this->location->getLongitude());
    }

    // Test the toArray method
    public function testToArray()
    {
        $expectedArray = [
            'location_name' => 'New York',
            'location_longitude' => -74.0060,
            'location_latitude' => 40.7128,
        ];

        // Assert that toArray method returns the expected array
        $this->assertEquals($expectedArray, $this->location->toArray());
    }

    // Test the __toString method
    public function testToString()
    {
        // Assert that the string representation of the location is correct
        $this->assertEquals('New York (Lat: 40.7128, Lon: -74.006)', (string)$this->location);
    }
}
