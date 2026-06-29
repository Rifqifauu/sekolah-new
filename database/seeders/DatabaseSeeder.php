<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\AcademicPeriod;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Extracurricular;
use App\Models\Setting;
use App\Models\Media;
use App\Models\People;
use App\Models\Post;
use App\Models\GradeComponent;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\StudentReport;
use App\Models\User;
use App\Models\Achievement; // Tambahkan import model Achievement

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Buat User Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@sekolah.sch.id'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
            ]
        );

        // 2. Data Master (Periode, Kelas, Mapel, Ekstra)
        $period = AcademicPeriod::create([
            'year' => '2025/2026',
            'semester' => 'odd', // Disesuaikan dengan rule database sebelumnya
            'is_active' => true
        ]);

        $classrooms = [];
        foreach (['X-A', 'X-B', 'XI-A', 'XI-B', 'XII-A', 'XII-B'] as $className) {
            $classrooms[] = Classroom::create(['name' => $className]);
        }

        $subjects = [];
        $subjectNames = ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'Biologi', 'Fisika'];
        foreach ($subjectNames as $index => $subjectName) {
            $subjects[] = Subject::create([
                'code' => strtoupper(substr($subjectName, 0, 3)) . '-' . (100 + $index),
                'name' => $subjectName,
                'description' => $faker->sentence(),
            ]);
        }

        $extracurriculars = ['Pramuka', 'PMR', 'Paskibra', 'Basket', 'Karya Ilmiah Remaja'];
        foreach ($extracurriculars as $extra) {
            Extracurricular::create([
                'name' => $extra,
                'description' => $faker->paragraph(),
                'image' => strtolower($extra) . '.jpg',
                'schedule' => $faker->dayOfWeek() . ', 15:00 WIB',
            ]);
        }

        // 3. Settings & Media (Value dikonversi ke JSON)
        Setting::insert([
            [
                'key' => 'school_name',
                'value' => json_encode('Sekolah Unggulan Nusantara')
            ],
            [
                'key' => 'contact_email',
                'value' => json_encode('info@sekolah.sch.id')
            ],
            [
                'key' => 'social_media',
                'value' => json_encode([
                    'facebook' => 'https://facebook.com/sekolah',
                    'instagram' => 'https://instagram.com/sekolah'
                ])
            ]
        ]);

        Media::create([
            'name' => 'Gedung Utama',
            'path' => '/storage/gedung.jpg',
            'type' => 'image',
            'description' => 'Tampak depan gedung utama sekolah'
        ]);

        // 4. People (Guru, Staf, Siswa)
        $teachers = [];
        for ($i = 0; $i < 15; $i++) {
            $teachers[] = People::create([
                'name' => $faker->name . ', S.Pd',
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'id_number' => $faker->unique()->numerify('19##########'), // NIP
                'role' => 'teacher',
                'classroom_id' => $faker->boolean(30) ? $faker->randomElement($classrooms)->id : null,
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            People::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'id_number' => $faker->unique()->numerify('19##########'),
                'role' => 'staff',
                'classroom_id' => null,
            ]);
        }

        $students = [];
        for ($i = 0; $i < 50; $i++) {
            $students[] = People::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'id_number' => $faker->unique()->numerify('######'), // NISN
                'role' => 'student',
                'classroom_id' => $faker->randomElement($classrooms)->id,
            ]);
        }

        // 5. Postingan (Artikel & Pengumuman)
        for ($i = 0; $i < 20; $i++) {
            $title = $faker->sentence;
            Post::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'content' => $faker->paragraphs(3, true),
                'image' => 'default.jpg',
                'type' => $faker->randomElement(['article', 'announcement']),
                'is_published' => $faker->boolean(80),
                'user_id' => $admin->id,
            ]);
        }

        // 6. Transaksional (Komponen Nilai, Nilai, Absensi)
        $gradeComponents = [];
        foreach ($subjects as $subject) {
            $gradeComponents[] = GradeComponent::create([
                'subject_id' => $subject->id,
                'name' => 'Ujian Akhir Semester',
                'weight' => 40
            ]);
        }

        $sampleStudents = array_slice($students, 0, 10);

        foreach ($sampleStudents as $student) {
            Grade::create([
                'student_id' => $student->id,
                'grade_component_id' => $faker->randomElement($gradeComponents)->id,
                'academic_period_id' => $period->id,
                'score' => $faker->randomFloat(2, 60, 100),
                'feedback' => $faker->sentence()
            ]);

            Attendance::create([
                'student_id' => $student->id,
                'teacher_id' => $faker->randomElement($teachers)->id,
                'academic_period_id' => $period->id,
                'date' => $faker->date(),
                'status' => $faker->randomElement(['present', 'absent', 'late', 'permission','sick']),
                'note' => $faker->optional()->sentence()
            ]);

            StudentReport::create([
                'student_id' => $student->id,
                'teacher_id' => $faker->randomElement($teachers)->id,
                'academic_period_id' => $period->id,
                'notes' => $faker->sentence(),
                'status' => $faker->randomElement(['pending', 'approved', 'rejected'])
            ]);
        }

        // 7. Data Master Prestasi (Achievement) & Relasi ke Siswa
        $achievementCategories = ['Akademik', 'Olahraga & Seni', 'Penelitian', 'Teknologi'];
        $achievementLevels = ['Sekolah', 'Kabupaten', 'Provinsi', 'Nasional', 'Internasional'];
        $achievementRanks = ['Juara 1', 'Juara 2', 'Juara 3', 'Harapan 1', 'Medali Emas'];

        $titles = [
            'Olimpiade Sains Nasional', 'Kejuaraan Pencak Silat', 'Lomba Debat Bahasa Inggris',
            'Turnamen Basket Fiba', 'Kompetisi Robotik', 'Lomba Karya Tulis Ilmiah'
        ];

        for ($i = 0; $i < 15; $i++) {
            $achievement = Achievement::create([
                'title' => $faker->randomElement($titles) . ' Tingkat ' . $faker->city,
                'category' => $faker->randomElement($achievementCategories),
                'level' => $faker->randomElement($achievementLevels),
                'rank' => $faker->randomElement($achievementRanks),
                'year' => $faker->numberBetween(2022, 2026),
                'image' => 'prestasi-' . $faker->numberBetween(1, 5) . '.jpg',
            ]);

            // Ambil 1 sampai 3 siswa secara acak untuk dihubungkan ke prestasi ini
            $randomStudents = $faker->randomElements($students, $faker->numberBetween(1, 3));

            // Ambil ID dari siswa-siswa tersebut
            $studentIds = array_map(function($student) {
                return $student->id;
            }, $randomStudents);

            // Simpan ke tabel pivot (achievement_people)
            $achievement->students()->attach($studentIds);
        }

        $this->command->info('Puluhan data dummy beserta Data Prestasi & Relasi Siswa berhasil di-generate!');
    }
}
