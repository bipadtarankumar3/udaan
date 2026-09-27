<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminStudentTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Super Admin role and user
        $role = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Telecaller', 'guard_name' => 'web']);

        $this->adminUser = User::factory()->create([
            'email' => 'admin@example.com',
            'status' => 'active',
        ]);
        $this->adminUser->assignRole($role);
    }

    /**
     * Test admin students index page renders properly without syntax or blade errors.
     */
    public function test_admin_students_index_renders_successfully(): void
    {
        Student::create([
            'name' => 'Rahul Sharma',
            'phone' => '9871123417',
            'counselling_date' => now()->addDays(2)->toDateString(),
            'status' => 'New',
            'priority' => 'Medium',
            'source' => 'Counseling Form',
        ]);

        $response = $this->actingAs($this->adminUser)->get('/admin/students');

        $response->assertStatus(200);
        $response->assertSee('Students Counseling & Lead Distribution', false);
        $response->assertSee('Rahul Sharma');
        $response->assertSee('Counselling &amp; DOB', false);
    }

    /**
     * Test admin can create a student with custom counselling date.
     */
    public function test_admin_can_create_student_with_counselling_date(): void
    {
        $customDate = now()->addDays(5)->toDateString();

        $response = $this->actingAs($this->adminUser)->post('/admin/students', [
            'name' => 'Pooja Kumari',
            'father_name' => 'Ramesh Kumar',
            'phone' => '9871123999',
            'whatsapp_no' => '9871123999',
            'qualification' => '12th Pass',
            'gender' => 'Female',
            'address' => 'Patna',
            'source' => 'Counseling Form',
            'status' => 'New',
            'priority' => 'High',
            'counselling_date' => $customDate,
        ]);

        $response->assertRedirect('/admin/students');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('students', [
            'name' => 'Pooja Kumari',
            'phone' => '9871123999',
        ]);
        $pooja = Student::where('phone', '9871123999')->first();
        $this->assertEquals($customDate, $pooja->counselling_date->toDateString());
    }

    /**
     * Test admin can update a student counselling date.
     */
    public function test_admin_can_update_student_counselling_date(): void
    {
        $student = Student::create([
            'name' => 'Vikram Singh',
            'phone' => '9871123888',
            'source' => 'Counseling Form',
            'status' => 'New',
            'priority' => 'Medium',
            'counselling_date' => now()->addDays(2)->toDateString(),
        ]);

        $newDate = now()->addDays(7)->toDateString();

        $response = $this->actingAs($this->adminUser)->put("/admin/students/{$student->id}", [
            'name' => 'Vikram Singh Updated',
            'phone' => '9871123888',
            'source' => 'Counseling Form',
            'status' => 'Contacted',
            'priority' => 'High',
            'counselling_date' => $newDate,
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Vikram Singh Updated',
            'status' => 'Contacted',
        ]);
        $this->assertEquals($newDate, $student->fresh()->counselling_date->toDateString());
    }
}
