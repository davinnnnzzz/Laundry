<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaundryFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_homepage_shows_services_and_buttons(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Laundry Express');
        $response->assertSee('Masuk (Login)');
        $response->assertSee('Daftar (Register)');
        $response->assertSee('Bed Cover');
        $response->assertSee('Cuci Express 3 Jam');
    }

    public function test_customer_can_register_and_is_redirected_to_home(): void
    {
        $response = $this->post('/register', [
            'name'                  => 'Rina Melati',
            'email'                 => 'rina@example.com',
            'whatsapp_number'       => '081299887766',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'rina@example.com',
            'role'  => 'customer',
        ]);
    }

    public function test_customer_can_submit_order_and_price_is_calculated_on_server(): void
    {
        $customer = User::where('role', 'customer')->first();
        $service1 = Service::where('service_name', 'Cuci Kering')->first(); // 5000 / Kg
        $service2 = Service::where('service_name', 'Bed Cover')->first(); // 25000 / Pcs

        $response = $this->actingAs($customer)->post('/pesan', [
            'customer_name'   => $customer->name,
            'whatsapp_number' => '081234567890',
            'service_id'      => [$service1->id, $service2->id],
            'quantity'        => [2, 1], // 2*5000 + 1*25000 = 35000
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'user_id'         => $customer->id,
            'customer_name'   => $customer->name,
            'whatsapp_number' => '081234567890',
            'total_price'     => 35000,
            'status'          => 'Proses',
        ]);

        $order = Order::where('customer_name', $customer->name)->first();
        $this->assertCount(2, $order->orderDetails);
    }

    public function test_customer_can_view_their_order_history(): void
    {
        $customer = User::where('role', 'customer')->first();

        $order = Order::create([
            'user_id'         => $customer->id,
            'customer_name'   => $customer->name,
            'whatsapp_number' => '081234567890',
            'total_price'     => 50000,
            'status'          => 'Dicuci',
        ]);

        $response = $this->actingAs($customer)->get('/riwayat-pesanan');
        $response->assertStatus(200);
        $response->assertSee('Riwayat Pesanan Saya');
        $response->assertSee('LDR-'.$order->id);
        $response->assertSee('Sedang Dicuci');
    }

    public function test_non_admin_cannot_access_admin_dashboard_or_rekap(): void
    {
        $customer = User::where('role', 'customer')->first();

        // Customer tried to access admin dashboard
        $response = $this->actingAs($customer)->get('/admin/dashboard');
        $response->assertRedirect('/');

        // Customer tried to access admin rekap
        $rekapResponse = $this->actingAs($customer)->get('/admin/rekap');
        $rekapResponse->assertRedirect('/');
    }

    public function test_admin_can_login_and_view_rekap(): void
    {
        $admin = User::where('email', 'admin@laundry.test')->first();

        $loginResponse = $this->post('/login', [
            'email'    => 'admin@laundry.test',
            'password' => 'password123',
        ]);

        $loginResponse->assertRedirect('/admin/dashboard');

        $rekapResponse = $this->actingAs($admin)->get('/admin/rekap');
        $rekapResponse->assertStatus(200);
        $rekapResponse->assertSee('Rekapitulasi Laporan Transaksi');
        $rekapResponse->assertSee('Cetak / Print Rekap');
    }

    public function test_kasir_can_login_and_update_status_from_proses_to_selesai(): void
    {
        $kasir = User::where('email', 'kasir@laundry.test')->first();

        $loginResponse = $this->post('/login', [
            'email'    => 'kasir@laundry.test',
            'password' => 'password123',
        ]);
        $loginResponse->assertRedirect('/admin/dashboard');

        $order = Order::create([
            'customer_name'   => 'Ahmad',
            'whatsapp_number' => '081298765432',
            'total_price'     => 24000,
            'status'          => 'Proses',
            'status_bayar'    => 'Belum Lunas',
        ]);

        $updateResponse = $this->actingAs($kasir)->patch("/admin/orders/{$order->id}/status", [
            'status'       => 'Selesai',
            'status_bayar' => 'Lunas',
        ]);

        $updateResponse->assertSessionHas('success');
        $this->assertDatabaseHas('orders', [
            'id'           => $order->id,
            'status'       => 'Selesai',
            'status_bayar' => 'Lunas',
        ]);
    }

    public function test_kasir_cannot_create_or_delete_services(): void
    {
        $kasir = User::where('email', 'kasir@laundry.test')->first();

        // Kasir coba akses halaman form tambah layanan
        $response = $this->actingAs($kasir)->get('/admin/services/create');
        $response->assertRedirect('/admin/services');
        $response->assertSessionHas('error');

        // Kasir coba kirim POST tambah layanan
        $postResponse = $this->actingAs($kasir)->post('/admin/services', [
            'service_name'   => 'Layanan Ilegal',
            'category'       => 'Reguler',
            'price_per_unit' => 10000,
            'unit_type'      => 'Kg',
        ]);
        $postResponse->assertRedirect('/admin/services');
        $this->assertDatabaseMissing('services', ['service_name' => 'Layanan Ilegal']);
    }

    public function test_admin_can_update_order_status(): void
    {
        $admin = User::where('email', 'admin@laundry.test')->first();
        $order = Order::create([
            'customer_name'   => 'Siti',
            'whatsapp_number' => '081298765432',
            'total_price'     => 15000,
            'status'          => 'Antrean',
        ]);

        $response = $this->actingAs($admin)->patch("/admin/orders/{$order->id}/status", [
            'status' => 'Dicuci',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('orders', [
            'id'     => $order->id,
            'status' => 'Dicuci',
        ]);
    }

    public function test_admin_can_manage_services_crud(): void
    {
        $admin = User::where('email', 'admin@laundry.test')->first();

        // Create
        $response = $this->actingAs($admin)->post('/admin/services', [
            'service_name'   => 'Boneka Jumbo',
            'category'       => 'Satuan',
            'price_per_unit' => 45000,
            'unit_type'      => 'Pcs',
            'description'    => 'Pencucian boneka besar',
        ]);
        $response->assertRedirect('/admin/services');
        $this->assertDatabaseHas('services', ['service_name' => 'Boneka Jumbo']);

        $service = Service::where('service_name', 'Boneka Jumbo')->first();

        // Update
        $updateResponse = $this->actingAs($admin)->put("/admin/services/{$service->id}", [
            'service_name'   => 'Boneka Super Jumbo',
            'category'       => 'Satuan',
            'price_per_unit' => 50000,
            'unit_type'      => 'Pcs',
            'description'    => 'Pencucian boneka sangat besar',
        ]);
        $updateResponse->assertRedirect('/admin/services');
        $this->assertDatabaseHas('services', ['service_name' => 'Boneka Super Jumbo']);

        // Delete
        $deleteResponse = $this->actingAs($admin)->delete("/admin/services/{$service->id}");
        $deleteResponse->assertRedirect('/admin/services');
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }
}
