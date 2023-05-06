<?php

namespace App\Repositories\Customer;

use App\Models\Customer;
use Illuminate\Support\Collection;

/**
 * Interface CustomerRepositoryInterface
 * The CustomerRepositoryInterface is an interface that describes all the methods
 * a CustomerRepository should implement. This interface ensures that any class
 * implementing it adheres to a consistent structure for interacting with the
 * Customer model.
 */
interface CustomerRepositoryInterface
{
    /**
     * Get all customers.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find a customer by its ID.
     *
     * @param int $id
     *
     * @return Customer|null
     */
    public function find(int $id): ?Customer;

    /**
     * Create a new customer with the given data.
     *
     * @param array $attributes
     *
     * @return Customer
     */
    public function create(array $attributes): Customer;

    /**
     * Update an existing customer with the given data.
     *
     * @param int   $id
     * @param array $attributes
     *
     * @return bool
     */
    public function update(int $id, array $attributes): bool;

    /**
     * Delete a customer by its ID.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool;
}
