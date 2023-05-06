<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Repositories\Customer\EloquentCustomerRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\CreatesApplication;
use Tests\TestCase;

class EloquentCustomerRepositoryTest extends TestCase
{
    use CreatesApplication, RefreshDatabase, WithFaker;

    protected EloquentCustomerRepository $eloquentCustomerRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->eloquentCustomerRepository = new EloquentCustomerRepository();
    }

    public function test_all_method_returns_all_customers(): void
    {
        $customers = Customer::factory()->count(5)->create();
        $result = $this->eloquentCustomerRepository->all();
        $this->assertCount(5, $result);
    }

    public function test_find_method_returns_customer_by_id(): void
    {
        $customer = Customer::factory()->create();
        $result = $this->eloquentCustomerRepository->find($customer->id);

        $this->assertInstanceOf(Customer::class, $result);
        $this->assertEquals($customer->id, $result->id);
    }

    public function test_create_method_creates_new_customer(): void
    {
        $customerData = [
            'name' => 'Nagy István',
            'country' => 'Magyarország',
            'postal_code' => '1123',
            'city' => 'Budapest',
            'street' => 'Nagymező út',
            'house_number' => '12',
            'customer_code' => 'NGYI-123',
            'contract_date' => '2023-05-06',
        ];

        $newCustomer = $this->eloquentCustomerRepository->create($customerData);

        $this->assertInstanceOf(Customer::class, $newCustomer);
        $this->assertDatabaseHas('customers', $customerData);
    }

    public function test_update_method_updates_existing_customer(): void
    {
        $customer = Customer::factory()->create();
        $updateData = [
            'name' => 'Nagy István',
            'country' => 'Magyarország',
            'postal_code' => '1113',
            'city' => 'Budapest',
            'street' => 'Nagymező út',
            'house_number' => '15',
            'customer_code' => 'NGYI-123',
            'contract_date' => '2023-05-06',
        ];

        $updateResult = $this->eloquentCustomerRepository->update($customer->id, $updateData);

        $this->assertTrue($updateResult);
        $this->assertDatabaseHas('customers', array_merge(['id' => $customer->id], $updateData));
    }

    public function test_delete_method_removes_customer_from_database(): void
    {
        $customer = Customer::factory()->create();
        $deleteResult = $this->eloquentCustomerRepository->delete($customer->id);

        $this->assertTrue($deleteResult);
        $this->assertSoftDeleted('customers', ['id' => $customer->id]);
    }
}
