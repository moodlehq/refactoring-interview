<?php

namespace MyApp\Storage;

/**
 * Class JsonStorage
 *
 * Implements the StorageInterface to store data in a JSON file.
 */
class JsonStorage implements StorageInterface {

    /**
     * @var string The path to the JSON file used for storage.
     */
    private string $filePath;

    /**
     * JsonStorage constructor.
     *
     * Initializes the JSON storage with the given file path. If the file does not exist,
     * it creates an empty JSON array in the file.
     *
     * @param string $filePath The file path where data will be stored.
     */
    public function __construct(string $filePath) {
        $this->filePath = $filePath;
        if (!file_exists($filePath)) {
            file_put_contents($filePath, json_encode([]));
        }
    }

    /**
     * Save a new data entry to the JSON file.
     *
     * @param mixed $data The data to be saved (typically an object or array).
     * @return bool Returns true if the data is successfully saved, false otherwise.
     */
    public function save($data): bool {
        $allData = $this->readAll();
        
        $allData[] = $data->toArray();
        return file_put_contents($this->filePath, json_encode($allData)) !== false;
    }

    /**
     * Read a data entry from the JSON file by its ID.
     *
     * @param int $id The ID of the data entry to be read.
     * @return array The data entry if found, or an empty array if not found.
     */
    public function read($id): ?array {
        $allData = $this->readAll();

        foreach ($allData as $dataPoint) {
            if (isset($dataPoint['id']) and $dataPoint['id'] == $id) {
                return $dataPoint;
            }
        }
        return null;
    }

    /**
     * Retrieve all data entries from the JSON file.
     *
     * @return array An array containing all data entries.
     */
    public function findAll(): array {
        return $this->readAll();
    }

    /**
     * Delete a data entry from the JSON file by its ID.
     *
     * @param int $id The ID of the data entry to be deleted.
     * @return bool Returns true if the entry is successfully deleted, false otherwise.
     */
    public function delete($id): bool {
        $allData = $this->readAll();
        if (isset($allData[$id])) {
            unset($allData[$id]);
            // Re-index the array after deletion to maintain continuous keys
            return file_put_contents($this->filePath, json_encode(array_values($allData))) !== false;
        }
        return false;
    }

    /**
     * Read all data from the JSON file.
     *
     * @return array An array containing all the stored data.
     */
    public function readAll(): array {
        return json_decode(file_get_contents($this->filePath), true) ?? [];
    }
}