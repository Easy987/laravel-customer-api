<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index_returns_all_customers(): void
    {
        $customers = Customer::factory()->count(5)->create();
        $response = $this->get('/api/customers');

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }

    public function test_store_creates_new_customer(): void
    {
        $customerData = [
            'name' => 'Nagy Ferenc',
            'country' => 'Magyarország',
            'postal_code' => '1213',
            'city' => 'Budapest',
            'street' => 'Nagymező út',
            'house_number' => '8',
            'customer_code' => 'NGYI-123',
            'contract_date' => '2023-05-06',
        ];

        $response = $this->postJson('/api/customers', $customerData);

        $response->assertStatus(201)
            ->assertJsonFragment($customerData);
    }

    public function test_show_returns_customer_by_id(): void
    {
        $customer = Customer::factory()->create();
        $response = $this->getJson("/api/customers/{$customer->id}");

        $response->assertStatus(200)
            ->assertJsonFragment($customer->toArray());
    }

    public function test_update_updates_existing_customer(): void
    {
        $customer = Customer::factory()->create();
        $updateData = [
            'name' => 'Nagy István',
            'country' => 'Magyarország',
            'postal_code' => '1113',
            'city' => 'Budapest',
            'street' => 'Nagymező út',
            'house_number' => '20',
            'customer_code' => 'NGYI-123',
            'contract_date' => '2023-05-06',
        ];

        $response = $this->putJson("/api/customers/{$customer->id}", $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('customers', array_merge(['id' => $customer->id], $updateData));
    }

    public function test_destroy_removes_customer_from_database(): void
    {
        $customer = Customer::factory()->create();
        $response = $this->deleteJson("/api/customers/{$customer->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('customers', ['id' => $customer->id]);
    }
}
