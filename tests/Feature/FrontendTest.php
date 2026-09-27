<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test public pages load properly.
     */
    public function test_frontend_pages_render_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/apply');
        $response->assertStatus(200);
        $response->assertSee('Online Application Form');

        $response = $this->get('/courses');
        $response->assertStatus(200);

        $response = $this->get('/process');
        $response->assertStatus(200);

        $response = $this->get('/enrollment');
        $response->assertStatus(200);

        $response = $this->get('/news');
        $response->assertStatus(200);

        $response = $this->get('/videos');
        $response->assertStatus(200);

        $response = $this->get('/partners');
        $response->assertStatus(200);

        $response = $this->get('/contact');
        $response->assertStatus(200);

        $response = $this->get('/services');
        $response->assertStatus(200);

        $response = $this->get('/programs');
        $response->assertStatus(200);

        $response = $this->get('/confirmation');
        $response->assertStatus(200);
    }

    /**
     * Test dynamic student registration submission.
     */
    public function test_apply_form_submission_creates_student_lead(): void
    {
        $postData = [
            'name' => 'Amit Verma',
            'father_name' => 'Suresh Verma',
            'dob' => '2005-04-12',
            'phone' => '9876543210',
            'whatsapp_no' => '9876543210',
            'qualification' => '12th',
            'gender' => 'Male',
            'address' => 'Station Road, Kankarbagh, Patna',
        ];

        $response = $this->post('/apply', $postData);

        $response->assertRedirect(route('frontend.confirmation', ['search' => '9876543210']));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('students', [
            'name' => 'Amit Verma',
            'father_name' => 'Suresh Verma',
            'phone' => '9876543210',
            'whatsapp_no' => '9876543210',
            'qualification' => '12th',
            'gender' => 'Male',
            'address' => 'Station Road, Kankarbagh, Patna',
            'source' => 'Website Application Form',
            'status' => 'New',
        ]);

        $createdStudent = Student::first();
        $this->assertEquals(now()->addDays(2)->toDateString(), $createdStudent->counselling_date->toDateString());
    }

    /**
     * Test dynamic contact form submission.
     */
    public function test_contact_form_submission_creates_lead(): void
    {
        $contactData = [
            'name' => 'Kavita Singh',
            'phone' => '9123456780',
            'email' => 'kavita@example.com',
            'subject' => 'Admission Inquiry',
            'message' => 'I would like to inquire about B.Sc Nursing admission through DRCC.',
        ];

        $response = $this->post('/contact', $contactData);

        $response->assertRedirect('/contact');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('students', [
            'name' => 'Kavita Singh',
            'phone' => '9123456780',
            'email' => 'kavita@example.com',
            'source' => 'Contact Us Page',
            'status' => 'New',
        ]);
    }

    /**
     * Test counselling letter default view shows search and no letter.
     */
    public function test_counselling_letter_default_view_shows_search_only(): void
    {
        Student::create([
            'name' => 'Rohan Kumar',
            'phone' => '9876543211',
            'dob' => '1996-06-06',
        ]);

        $response = $this->get('/confirmation');
        $response->assertStatus(200);
        $response->assertSee('Verify / Download Counselling Letter');
        $response->assertSee('Search Your Counselling Letter');
        // By default, student letter details should not be shown
        $response->assertDontSee('Counselling Date:');
    }

    /**
     * Test counselling letter search shows dynamic candidate details.
     */
    public function test_counselling_letter_search_by_phone_shows_details(): void
    {
        $student = Student::create([
            'name' => 'Rohan Sharma',
            'phone' => '9876543211',
            'dob' => '1996-06-06',
        ]);

        $response = $this->get('/confirmation?search=9876543211');
        $response->assertStatus(200);
        $response->assertSee('Counselling Letter');
        $response->assertSee('Rohan Sharma');
        $response->assertSee('6/6/1996');
        $response->assertSee('10:00 AM to 04:00 PM.');
        $response->assertSee('Combined Counselling Board');
        $response->assertSee('BIHAR STUDENT COUNSELLING CENTER');
    }

    /**
     * Test counselling letter search with invalid phone shows not found message.
     */
    public function test_counselling_letter_search_not_found(): void
    {
        $response = $this->get('/confirmation?search=1111111111');
        $response->assertStatus(200);
        $response->assertSee('No registration record found');
        $response->assertDontSee('Counselling Date:');
    }
}
