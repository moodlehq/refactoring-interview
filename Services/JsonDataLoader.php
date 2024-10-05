<?php

namespace MyApp\Services;

/**
 * Class Teacher
 *
 * Encapsulates a specific  user type Teacher
 */
class JsonDataLoader {

    /**
     * @var int student's id.
     */
    private string $filePath;

    /**
     * JsonDataLoader constructor.
     *
     * @param string $filePath json file path.
     */
    public function __construct(string $filePath) {
        $this->filePath = $filePath;
    }

    /**
     * Get json file contents.
     *
     * @return array get the loaded json file as an array.
     */
    public function loadData(): array {
        $jsonContent = file_get_contents($this->filePath);
        return json_decode($jsonContent, true);
    }
}
