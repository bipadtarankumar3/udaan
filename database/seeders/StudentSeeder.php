<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\StudentRemark;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@uddan.com')->first();
        $priya = User::where('email', 'telecaller1@uddan.com')->first();
        $rahul = User::where('email', 'telecaller2@uddan.com')->first();
        $ananya = User::where('email', 'telecaller3@uddan.com')->first();

        $studentsData = [
            [
                'name' => 'Aarav Kumar',
                'father_name' => 'Ramesh Kumar',
                'dob' => '2004-05-15',
                'phone' => '9823412345',
                'whatsapp_no' => '9823412345',
                'qualification' => '12th Pass',
                'gender' => 'Male',
                'address' => 'Vill- Rampur, PO- Danapur, Patna',
                'city' => 'Patna',
                'course_interested' => 'B.Tech / Engineering Counseling',
                'source' => 'Counseling Form',
                'status' => 'Interested',
                'priority' => 'High',
                'assigned_to' => $priya?->id,
                'assigned_at' => now()->subDays(2),
                'assigned_by' => $admin?->id,
                'last_contacted_at' => now()->subHours(5),
                'next_followup_at' => now()->addDay()->setHour(14)->setMinute(0),
                'current_remarks' => 'Student wants counseling for CS branch under Bihar Student Credit Card scheme.',
                'remarks_history' => [
                    [
                        'user_id' => $priya?->id,
                        'call_outcome' => 'Connected',
                        'status' => 'Contacted',
                        'remarks' => 'Introductory counseling call. Explained available colleges and scholarship criteria.',
                        'created_at' => now()->subDays(1),
                        'next_followup_at' => now()->subHours(5),
                    ],
                    [
                        'user_id' => $priya?->id,
                        'call_outcome' => 'Interested',
                        'status' => 'Interested',
                        'remarks' => 'Student wants counseling for CS branch under Bihar Student Credit Card scheme.',
                        'created_at' => now()->subHours(5),
                        'next_followup_at' => now()->addDay()->setHour(14)->setMinute(0),
                    ],
                ]
            ],
            [
                'name' => 'Sneha Kumari',
                'father_name' => 'Sunil Singh',
                'dob' => '2003-11-20',
                'phone' => '9834567890',
                'whatsapp_no' => '9834567890',
                'qualification' => 'Graduation (Pursuing)',
                'gender' => 'Female',
                'address' => 'Ward No 4, Boring Road, Patna',
                'city' => 'Patna',
                'course_interested' => 'B.Sc Nursing & Paramedical',
                'source' => 'Website Form',
                'status' => 'Converted',
                'priority' => 'High',
                'assigned_to' => $priya?->id,
                'assigned_at' => now()->subDays(5),
                'assigned_by' => $admin?->id,
                'last_contacted_at' => now()->subDay(),
                'next_followup_at' => null,
                'current_remarks' => 'Counseling letter issued and admission token confirmed for Nursing College.',
                'remarks_history' => [
                    [
                        'user_id' => $priya?->id,
                        'call_outcome' => 'Connected',
                        'status' => 'Interested',
                        'remarks' => 'Father spoke on call. Inquired about hostel facility and college affiliation.',
                        'created_at' => now()->subDays(4),
                        'next_followup_at' => now()->subDays(2),
                    ],
                    [
                        'user_id' => $priya?->id,
                        'call_outcome' => 'Converted',
                        'status' => 'Converted',
                        'remarks' => 'Counseling letter issued and admission token confirmed for Nursing College.',
                        'created_at' => now()->subDay(),
                        'next_followup_at' => null,
                    ],
                ]
            ],
            [
                'name' => 'Vikram Sharma',
                'father_name' => 'Ajay Sharma',
                'dob' => '2005-01-10',
                'phone' => '9812398765',
                'whatsapp_no' => '9812398765',
                'qualification' => '10th Pass',
                'gender' => 'Male',
                'address' => 'Near Zero Mile, Muzaffarpur',
                'city' => 'Muzaffarpur',
                'course_interested' => 'Polytechnic Diploma',
                'source' => 'Counseling Form',
                'status' => 'Follow-up',
                'priority' => 'Medium',
                'assigned_to' => $rahul?->id,
                'assigned_at' => now()->subDays(3),
                'assigned_by' => $admin?->id,
                'last_contacted_at' => now()->subHours(3),
                'next_followup_at' => now()->addHours(4),
                'current_remarks' => 'Requested evening callback when father is home (6:30 PM).',
                'remarks_history' => [
                    [
                        'user_id' => $rahul?->id,
                        'call_outcome' => 'Callback Requested',
                        'status' => 'Follow-up',
                        'remarks' => 'Requested evening callback when father is home (6:30 PM).',
                        'created_at' => now()->subHours(3),
                        'next_followup_at' => now()->addHours(4),
                    ]
                ]
            ],
            [
                'name' => 'Pooja Kumari',
                'father_name' => 'Santosh Prasad',
                'dob' => '2004-08-25',
                'phone' => '9848012345',
                'whatsapp_no' => '9848012345',
                'qualification' => '12th Pass',
                'gender' => 'Female',
                'address' => 'Station Road, Gaya',
                'city' => 'Gaya',
                'course_interested' => 'BCA / Computer Applications',
                'source' => 'Counseling Form',
                'status' => 'Contacted',
                'priority' => 'High',
                'assigned_to' => $ananya?->id,
                'assigned_at' => now()->subDay(),
                'assigned_by' => $admin?->id,
                'last_contacted_at' => now()->subHours(2),
                'next_followup_at' => now()->addDay()->setHour(11)->setMinute(30),
                'current_remarks' => 'Connected. Wants counseling letter details sent on WhatsApp.',
                'remarks_history' => [
                    [
                        'user_id' => $ananya?->id,
                        'call_outcome' => 'Connected',
                        'status' => 'Contacted',
                        'remarks' => 'Connected. Wants counseling letter details sent on WhatsApp.',
                        'created_at' => now()->subHours(2),
                        'next_followup_at' => now()->addDay()->setHour(11)->setMinute(30),
                    ]
                ]
            ],
            [
                'name' => 'Manish Verma',
                'father_name' => 'Bipin Verma',
                'dob' => '2003-03-12',
                'phone' => '9890123456',
                'whatsapp_no' => '9890123456',
                'qualification' => '12th Pass',
                'gender' => 'Male',
                'address' => 'Bhagalpur City, Near Tower Chowk',
                'city' => 'Bhagalpur',
                'course_interested' => 'B.Pharma / Pharmacy',
                'source' => 'Bulk Upload',
                'status' => 'New',
                'priority' => 'Medium',
                'assigned_to' => null,
                'assigned_at' => null,
                'assigned_by' => null,
                'last_contacted_at' => null,
                'next_followup_at' => null,
                'current_remarks' => null,
                'remarks_history' => []
            ],
            [
                'name' => 'Anjali Raj',
                'father_name' => 'Rajendra Roy',
                'dob' => '2004-12-05',
                'phone' => '9447123456',
                'whatsapp_no' => '9447123456',
                'qualification' => '12th Pass',
                'gender' => 'Female',
                'address' => 'Darbhanga Bazar, Darbhanga',
                'city' => 'Darbhanga',
                'course_interested' => 'B.Tech / CS & AI',
                'source' => 'Website Form',
                'status' => 'New',
                'priority' => 'High',
                'assigned_to' => null,
                'assigned_at' => null,
                'assigned_by' => null,
                'last_contacted_at' => null,
                'next_followup_at' => null,
                'current_remarks' => null,
                'remarks_history' => []
            ],
        ];

        foreach ($studentsData as $data) {
            $remarksHistory = $data['remarks_history'] ?? [];
            unset($data['remarks_history']);

            $student = Student::create($data);

            foreach ($remarksHistory as $rem) {
                StudentRemark::create([
                    'student_id' => $student->id,
                    'user_id' => $rem['user_id'],
                    'call_outcome' => $rem['call_outcome'],
                    'status' => $rem['status'],
                    'remarks' => $rem['remarks'],
                    'next_followup_at' => $rem['next_followup_at'],
                    'created_at' => $rem['created_at'],
                ]);
            }
        }
    }
}
