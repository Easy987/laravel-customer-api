<?php

namespace App\Repositories\Customer;

use App\Models\Customer;
use Illuminate\Support\Collection;

/**
 * Class EloquentCustomerRepository
 * The EloquentCustomerRepository is a concrete implementation of the
 * CustomerRepositoryInterface using Eloquent ORM for data persistence.
 * It provides methods to interact with the Customer model.
 */
class EloquentCustomerRepository implements CustomerRepositoryInterface
{
    /**
     * Get all customers.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Customer::all();
    }

    /**
     * Create a new customer with the given data.
     *
     * @param array $attributes
     *
     * @return Customer
     */
    public function create(array $attributes): Customer
    {
        return Customer::create($attributes);
    }

    /**
     * Update an existing customer with the given data.
     *
     * @param int   $id
     * @param array $attributes
     *
     * @return bool
     */
    public function update(int $id, array $attributes): bool
    {
        $customer = $this->find($id);
        if (!$customer) {
            return false;
        }

        return $customer->update($attributes);
    }

    /**
     * Find a customer by its ID.
     *
     * @param int $id
     *
     * @return Customer|null
     */
    public function find(int $id): ?Customer
    {
        return Customer::find($id);
    }

    /**
     * Delete a customer by its ID.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        $customer = $this->find($id);
        if (!$customer) {
            return false;
        }

        return $customer->delete();
    }
}
