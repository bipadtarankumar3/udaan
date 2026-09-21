<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CategoryAndPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        $adminId = $admin ? $admin->id : null;

        $categories = [
            [
                'name' => 'Education',
                'slug' => 'education',
                'description' => 'Latest updates and news in higher education, scholarships, and learning initiatives.',
                'color' => '#0284c7', // Sky blue
            ],
            [
                'name' => 'Scholarships',
                'slug' => 'scholarships',
                'description' => 'Student financial aid schemes, government grants, and BSCC student credit updates.',
                'color' => '#dc2626', // Crimson Red
            ],
            [
                'name' => 'Women Empowerment',
                'slug' => 'women-empowerment',
                'description' => 'Workshops, vocational training, and entrepreneurship opportunities for young women.',
                'color' => '#ea580c', // Vibrant Orange
            ],
            [
                'name' => 'Environment',
                'slug' => 'environment',
                'description' => 'Green initiatives, plantation drives, and eco-sustainability programs.',
                'color' => '#16a34a', // Emerald Green
            ],
            [
                'name' => 'Health & Wellness',
                'slug' => 'health-wellness',
                'description' => 'Community medical checkup camps, health awareness, and hygiene drives.',
                'color' => '#0d9488', // Teal
            ],
            [
                'name' => 'Skill Development',
                'slug' => 'skill-development',
                'description' => 'Industry-aligned technical skill bootcamps, job-readiness, and IT training.',
                'color' => '#7c3aed', // Purple
            ],
            [
                'name' => 'Community Development',
                'slug' => 'community-development',
                'description' => 'Grassroots welfare projects, rural upliftment, and youth leadership initiatives.',
                'color' => '#d97706', // Amber
            ],
        ];

        $categoryMap = [];
        foreach ($categories as $catData) {
            $cat = Category::firstOrCreate(['slug' => $catData['slug']], $catData);
            $categoryMap[$cat->slug] = $cat->id;
        }

        $posts = [
            [
                'title' => 'Udaan Foundation Launches Digital Literacy Program in Rural Bihar',
                'slug' => 'udaan-launches-digital-literacy-program-rural-bihar',
                'category_id' => $categoryMap['education'] ?? null,
                'user_id' => $adminId,
                'featured_image' => 'news slide (1).png',
                'excerpt' => 'In a landmark initiative, Udaan Foundation has launched a comprehensive Digital Literacy Program targeting over 5,000 students in rural Bihar and Jharkhand.',
                'content' => '<p>In a landmark initiative, <strong>Udaan Foundation</strong> has launched a comprehensive Digital Literacy Program targeting over <strong>5,000 students</strong> across rural Bihar and Jharkhand. The program aims to bridge the digital divide by providing free computer training, high-speed internet access, and essential digital skills education.</p><p>Supported by local government education bodies and corporate partners, the initiative will operate across 25 dedicated training centers for a duration of 6 months. Students will undergo intensive hands-on training in computing basics, cyber safety, digital payments, and job-oriented software tools.</p><blockquote>"Digital literacy is no longer a luxury — it is an urgent necessity. Every child and young adult deserves an equal opportunity to thrive in the modern digital age," stated the Foundation’s Director during the inauguration ceremony.</blockquote><p>Local community leaders and youth representatives attended the opening ceremony with great enthusiasm. Applications are now open for the next cohort of rural trainees.</p>',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => Carbon::parse('2024-09-10 10:00:00'),
                'views_count' => 1420,
            ],
            [
                'title' => 'Annual Scholarship Drive Benefits 500 Meritorious Students',
                'slug' => 'annual-scholarship-drive-benefits-500-meritorious-students',
                'category_id' => $categoryMap['scholarships'] ?? null,
                'user_id' => $adminId,
                'featured_image' => 'news slide (2).png',
                'excerpt' => "Udaan Foundation's flagship Annual Scholarship Drive 2024 has successfully supported 500 meritorious students from economically weaker sections with tuition and study aid.",
                'content' => '<p>Udaan Foundation’s flagship <strong>Annual Scholarship Drive 2024</strong> has successfully awarded educational grants to <strong>500 meritorious students</strong> from economically weaker sections. The scholarships, ranging from ₹10,000 to ₹50,000 per student, directly cover tuition fees, technical college admissions, study materials, and state examination preparation costs.</p><p>This year’s scholarship selection committee reviewed over 3,000 applications from 8 states, conducting rigorous merit-cum-means evaluations and personal interviews to ensure support reaches the most deserving candidates.</p><p>Recipients expressed deep gratitude, highlighting how this financial support enables them to pursue professional degrees in engineering, management, nursing, and IT.</p>',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => Carbon::parse('2024-08-22 11:30:00'),
                'views_count' => 980,
            ],
            [
                'title' => 'Women Entrepreneurs Workshop Empowers 200 Rural Women',
                'slug' => 'women-entrepreneurs-workshop-empowers-200-rural-women',
                'category_id' => $categoryMap['women-empowerment'] ?? null,
                'user_id' => $adminId,
                'featured_image' => 'news slide (3).png',
                'excerpt' => 'Over 200 women from rural villages in Bihar attended Udaan Foundation’s 3-day intensive workshop on micro-enterprise development and financial independence.',
                'content' => '<p>Over 200 aspiring female leaders from rural villages across Bihar gathered for Udaan Foundation’s 3-day intensive workshop focused on <strong>micro-enterprise development, financial independence, and market access</strong>.</p><p>Participants received specialized mentoring in small business accounting, digital marketing via mobile phones, government credit schemes, and group savings management. By the end of the workshop, 35 participants had already formalized business plans for small handicraft, agro-processing, and retail ventures.</p><p>The foundation has pledged continuous mentorship and linkage with micro-loan partners over the next 12 months to ensure sustainable growth for these new enterprises.</p>',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::parse('2024-07-15 09:00:00'),
                'views_count' => 760,
            ],
            [
                'title' => '50,000 Trees Planted: Udaan’s Green India Campaign Milestone',
                'slug' => '50000-trees-planted-udaans-green-india-campaign-milestone',
                'category_id' => $categoryMap['environment'] ?? null,
                'user_id' => $adminId,
                'featured_image' => 'news slide (4).png',
                'excerpt' => 'On World Environment Day, Udaan Foundation celebrated a significant milestone — 50,000 trees planted across 5 states with youth volunteer participation.',
                'content' => '<p>In celebration of World Environment Day, Udaan Foundation crossed a major sustainability milestone: <strong>50,000 native trees successfully planted</strong> across 5 states since the inception of the Green India Campaign.</p><p>More than 1,200 active student volunteers, local school teachers, and civic volunteers joined forces across 100+ plantation sites. Each tree planted is geotagged and cared for by local youth committees to ensure long-term survival rates.</p><p>The foundation also conducted interactive eco-clubs in 40 schools to educate children on water conservation, zero-waste practices, and biodiversity protection.</p>',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::parse('2024-06-05 14:00:00'),
                'views_count' => 610,
            ],
            [
                'title' => 'Free Mega Health Camp in Patna Benefits 1,200 Residents',
                'slug' => 'free-mega-health-camp-patna-benefits-1200-residents',
                'category_id' => $categoryMap['health-wellness'] ?? null,
                'user_id' => $adminId,
                'featured_image' => 'news slide (5).png',
                'excerpt' => 'Udaan Foundation organized a comprehensive free health camp providing consultations, essential medicines, and diagnostic tests to over 1,200 residents.',
                'content' => '<p>Udaan Foundation organized a comprehensive <strong>Free Mega Health Camp in Patna</strong> in collaboration with renowned medical institutions and specialist doctors. Over 1,200 local residents, including children and senior citizens, received free diagnostic checks, medical consultations, and essential prescribed medicines.</p><p>Services provided included comprehensive eye checkups with distribution of free spectacles, cardiac screening, blood sugar and pressure testing, pediatric consultations, and dental care. Health counselors also delivered sessions on nutrition, preventative health care, and seasonal disease prevention.</p>',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::parse('2024-05-12 10:00:00'),
                'views_count' => 840,
            ],
            [
                'title' => 'Youth Career Fair 2024 Connects 800+ Students with Industry Mentors',
                'slug' => 'youth-career-fair-2024-connects-800-students-with-mentors',
                'category_id' => $categoryMap['skill-development'] ?? null,
                'user_id' => $adminId,
                'featured_image' => 'news slide (6).png',
                'excerpt' => 'Over 800 diploma and degree students participated in the Mega Career Guidance Fair featuring top corporate HRs and university counselors.',
                'content' => '<p>Udaan Foundation organized the <strong>Youth Career Fair 2024</strong>, bringing together over 800 college students, polytechnic diploma holders, and fresh graduates from across the state.</p><p>Over 20 industry leaders, HR managers, and senior university counselors conducted interactive breakout sessions on resume building, interview techniques, Bihar Student Credit Card (BSCC) funding schemes, and emerging career opportunities in software development, healthcare management, and green technologies.</p>',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::parse('2024-04-18 16:00:00'),
                'views_count' => 520,
            ],
        ];

        foreach ($posts as $postData) {
            Post::firstOrCreate(['slug' => $postData['slug']], $postData);
        }
    }
}
