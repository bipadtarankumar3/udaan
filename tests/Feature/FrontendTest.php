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

        $response->assertRedirect(route('frontend.confirmation', ['id' => 1]));
        $response->assertSessionHas('success');
        $response->assertSessionHas('student');

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
}
