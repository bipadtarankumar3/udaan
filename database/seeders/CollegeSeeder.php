<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Seeder;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colleges = [
            [
                'name' => 'Netaji Subhas Institute of Technology (NSIT)',
                'code' => 'NSIT-PAT',
                'city' => 'Bihta, Patna',
                'state' => 'Bihar',
                'address' => 'Amhara, Bihta, Patna, Bihar - 801106',
                'affiliation' => 'Aryabhatta Knowledge University (AKU) / AICTE',
                'contact_person' => 'Dr. A. K. Sharma',
                'phone' => '9431000001',
                'email' => 'admissions@nsitbihta.org',
                'website' => 'https://nsit.in',
                'is_active' => true,
            ],
            [
                'name' => 'Patna Institute of Nursing & Paramedical Science',
                'code' => 'PINPS',
                'city' => 'Patna',
                'state' => 'Bihar',
                'address' => 'Brahmpur, Jaganpura, Patna - 800027',
                'affiliation' => 'BNRC / Indian Nursing Council (INC)',
                'contact_person' => 'Sunil Verma',
                'phone' => '9431000002',
                'email' => 'info@patnanursing.com',
                'website' => 'https://patnanursing.com',
                'is_active' => true,
            ],
            [
                'name' => 'Maulana Azad College of Engineering & Technology',
                'code' => 'MACET',
                'city' => 'Neora, Patna',
                'state' => 'Bihar',
                'address' => 'Anisabad - Khagaul Road, Neora, Patna - 801113',
                'affiliation' => 'AKU / AICTE Approved',
                'contact_person' => 'Mohd. Tariq',
                'phone' => '9431000003',
                'email' => 'admissions@macet.ac.in',
                'website' => 'https://macet.ac.in',
                'is_active' => true,
            ],
            [
                'name' => 'Vidya Vihar Institute of Technology (VVIT)',
                'code' => 'VVIT-PUR',
                'city' => 'Purnea',
                'state' => 'Bihar',
                'address' => 'Vidya Vihar Nagar, Maranga, Purnea - 854301',
                'affiliation' => 'AICTE / AKU Affiliated',
                'contact_person' => 'R. K. Roy',
                'phone' => '9431000004',
                'email' => 'admission@vvit.org',
                'website' => 'https://vvit.org',
                'is_active' => true,
            ],
            [
                'name' => 'Buddha Institute of Technology',
                'code' => 'BIT-GAYA',
                'city' => 'Gaya',
                'state' => 'Bihar',
                'address' => 'Industrial Area, Gaya-Dobhi Road, Gaya - 823004',
                'affiliation' => 'SBTE Bihar / AICTE',
                'contact_person' => 'Vikash Kumar',
                'phone' => '9431000005',
                'email' => 'info@bitgaya.com',
                'website' => 'https://bitgaya.com',
                'is_active' => true,
            ],
        ];

        foreach ($colleges as $data) {
            College::firstOrCreate(['name' => $data['name']], $data);
        }
    }
}
