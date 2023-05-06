<?php

namespace App\Http\Controllers;

use App\Repositories\Customer\CustomerRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class CustomerController
 * The CustomerController handles HTTP requests related to the Customer model.
 * It utilizes the CustomerRepositoryInterface to interact with the data layer.
 */
class CustomerController extends Controller
{
    /**
     * Create a new CustomerController instance.
     *
     * @param CustomerRepositoryInterface $customerRepository
     *
     * @return void
     */
    public function __construct(
        protected readonly CustomerRepositoryInterface $customerRepository
    )
    {
    }

    /**
     * Display a listing of customers.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => $this->customerRepository->all()]);
    }

    /**
     * Store a newly created customer in the database.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->all();

        if (isset($data[0]) && is_array($data[0])) {
            $customers = [];
            foreach ($data as $item) {
                $customers[] = $this->customerRepository->create($item);
            }
        } else {
            $customers = $this->customerRepository->create($data);
        }

        return response()->json(['data' => $customers], 201);
    }

    /**
     * Display the specified customer.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $customer = $this->customerRepository->find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
        return response()->json(['data' => $customer]);
    }

    /**
     * Update the specified customer in the database.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        if (!$this->customerRepository->update($id, $request->all())) {
            return response()->json(['message' => 'Customer not found or could not be updated'], 404);
        }
        return response()->json(['message' => 'Customer updated successfully']);
    }

    /**
     * Remove the specified customer from the database.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if (!$this->customerRepository->delete($id)) {
            return response()->json(['message' => 'Customer not found or could not be deleted'], 404);
        }
        return response()->json(['message' => 'Customer deleted successfully'], 204);
    }
}
