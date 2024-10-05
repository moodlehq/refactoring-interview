<?php

namespace MyApp\Storage;

/**
 * Interface StorageInterface
 *
 * Defines the contract for storage operations such as saving, reading, deleting, and retrieving all entities.
 */
interface StorageInterface {

    /**
     * Save an entity object to the storage.
     *
     * @param object $entity The entity object to be saved.
     * @return int The ID of the saved entity.
     */
    public function save($entity): bool;

    /**
     * Read an entity object from the storage by its ID.
     *
     * @param int $id The ID of the entity to be retrieved.
     * @param string $entityClass The class name of the entity to be retrieved.
     * @return object|null The entity object if found, or null if not found.
     */
    public function read($id): ?array;

    /**
     * Delete an entity object from the storage by its ID.
     *
     * @param int $id The ID of the entity to be deleted.
     * @param string $entityClass The class name of the entity to be deleted.
     * @return bool True if the entity was successfully deleted, false otherwise.
     */
    public function delete($id): bool;

    /**
     * Find all entities of a particular class in the storage.
     *
     * @param string $entityClass The class name of the entities to be retrieved.
     * @return array An array of all entities of the specified class.
     */
    public function findAll(): array;
}