<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\StudentBill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminBillingTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Telecaller', 'guard_name' => 'web']);

        $this->adminUser = User::factory()->create([
            'email' => 'admin@example.com',
            'status' => 'active',
        ]);
        $this->adminUser->assignRole($role);
    }

    /**
     * Test admin billing index page renders successfully with metrics and table.
     */
    public function test_admin_billing_index_renders_successfully(): void
    {
        $bill = StudentBill::create([
            'student_name' => 'Amit Kumar',
            'student_phone' => '9876543210',
            'course_name' => 'B.Tech (CSE)',
            'title' => 'Admission Registration Fee',
            'amount' => 5000.00,
            'discount' => 500.00,
            'tax_amount' => 0.00,
            'paid_amount' => 4500.00,
            'payment_method' => 'UPI / QR Code',
            'billing_date' => now()->toDateString(),
        ]);

        $response = $this->actingAs($this->adminUser)->get('/admin/billings');

        $response->assertStatus(200);
        $response->assertSee('Student Billing');
        $response->assertSee('Amit Kumar');
        $response->assertSee($bill->invoice_no);
        $response->assertSee('4,500.00');
    }

    /**
     * Test admin can create a new student bill.
     */
    public function test_admin_can_generate_student_bill(): void
    {
        $student = Student::create([
            'name' => 'Neha Sharma',
            'phone' => '9988776655',
            'course_interested' => 'BCA',
            'source' => 'Counseling Form',
            'status' => 'New',
            'priority' => 'High',
            'counselling_date' => now()->addDays(2)->toDateString(),
        ]);

        $response = $this->actingAs($this->adminUser)->post('/admin/billings', [
            'student_id' => $student->id,
            'student_name' => 'Neha Sharma',
            'student_phone' => '9988776655',
            'student_father_name' => 'Mr. Sharma',
            'course_name' => 'BCA',
            'title' => 'Counseling & Admission Fee',
            'amount' => 10000,
            'discount' => 1000,
            'tax_amount' => 0,
            'paid_amount' => 4000,
            'payment_method' => 'Cash',
            'billing_date' => now()->toDateString(),
            'due_date' => now()->addDays(10)->toDateString(),
        ]);

        $response->assertRedirect('/admin/billings');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('student_bills', [
            'student_name' => 'Neha Sharma',
            'student_phone' => '9988776655',
            'total_payable' => 9000.00,
            'paid_amount' => 4000.00,
            'due_amount' => 5000.00,
            'payment_status' => 'partially_paid',
        ]);
    }

    /**
     * Test admin can view printable official fee receipt / invoice.
     */
    public function test_admin_can_view_printable_invoice(): void
    {
        $bill = StudentBill::create([
            'student_name' => 'Rohan Varma',
            'student_phone' => '9871100223',
            'course_name' => 'Polytechnic',
            'title' => 'Counselling Registration Fee',
            'amount' => 3000.00,
            'paid_amount' => 3000.00,
            'payment_method' => 'Cash',
            'billing_date' => now()->toDateString(),
        ]);

        $response = $this->actingAs($this->adminUser)->get("/admin/billings/{$bill->id}");

        $response->assertStatus(200);
        $response->assertSee('Student Fee Receipt &amp; Billing Invoice', false);
        $response->assertSee('Rohan Varma');
        $response->assertSee($bill->invoice_no);
        $response->assertSee('PAID');
    }

    /**
     * Test admin can record subsequent payment towards an invoice.
     */
    public function test_admin_can_record_payment(): void
    {
        $bill = StudentBill::create([
            'student_name' => 'Deepak Gupta',
            'student_phone' => '9871100555',
            'title' => 'Annual College Seat Charge',
            'amount' => 8000.00,
            'discount' => 0.00,
            'paid_amount' => 3000.00,
            'payment_method' => 'Cash',
            'billing_date' => now()->toDateString(),
        ]);

        $this->assertEquals('partially_paid', $bill->payment_status);
        $this->assertEquals(5000.00, $bill->due_amount);

        // Record remaining 5000 payment
        $response = $this->actingAs($this->adminUser)->post("/admin/billings/{$bill->id}/record-payment", [
            'payment_amount' => 5000.00,
            'payment_method' => 'UPI / QR Code',
            'transaction_id' => 'UPI99887766',
        ]);

        $response->assertRedirect('/admin/billings');
        $response->assertSessionHas('success');

        $bill->refresh();
        $this->assertEquals(8000.00, $bill->paid_amount);
        $this->assertEquals(0.00, $bill->due_amount);
        $this->assertEquals('paid', $bill->payment_status);
    }

    /**
     * Test admin can export billing ledger to CSV.
     */
    public function test_admin_can_export_billing_csv(): void
    {
        StudentBill::create([
            'student_name' => 'Suman Roy',
            'student_phone' => '9871100999',
            'title' => 'Counseling Fee',
            'amount' => 2500.00,
            'paid_amount' => 2500.00,
            'billing_date' => now()->toDateString(),
        ]);

        $response = $this->actingAs($this->adminUser)->get('/admin/billings/export-csv');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }
}
