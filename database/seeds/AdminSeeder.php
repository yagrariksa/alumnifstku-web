<?php

use Illuminate\Database\Seeder;
use App\User;
use App\KelasAlumni;
use App\DataKelasAlumni;
use App\Loker;
use App\FstNews;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 2; $i++) { 
            $user = new User();
            $user->email = 'admin'.$i.'@gmail.com';
            $user->name = 'admin'.$i;
            $user->password = Hash::make('1qw23er4');
            $user->role = $i+1;
            $user->save();

            if ($i == 0) {
                $news = new FstNews();
                $news->judul = 'ini judul berita';
                $news->link = 'https://unair.ac.id/site/article/read/3093/national-level-achievement-three-faculty-of-veterinary-medicine-students-propose-idea-for-covid-19-antiviral-candidates.html';
                $news->gambar = 'https://unair.ac.id/filemanager/userfiles/PHNC-2020.jpeg';
                $news->user_id = $user->id;
                $news->save();
                
                $loker = new Loker();
                $loker->jabatan = 'Decision Scientist - Customer Analytics';
                $loker->perusahaan = 'Gojek';
                $loker->deskripsi = 'This role is for those who enjoy mining insights from the sea of data, building data products, and designing experiments with the ability to see the real-time impact of your contribution. You will get to work with insanely awesome and smart business leads and fellow analysts. Your work will impact how the senior leaders at Gojek shape strategies around millions of customers across South East Asia!';
                $loker->cluster = 'Startup';
                $loker->jurusan = 'Sistem Informasi, Statistika, Matematika';
                $loker->link = 'https://www.linkedin.com/jobs/search/?currentJobId=2243927501&pivotType=jymbii';
                $loker->user_id = $user->id;
                $loker->save();

                $kelas = new KelasAlumni();
                $kelas->judul = 'Getting to know Data Analytics';
                $kelas->kuota = 100;
                $kelas->tanggal = '2020-11-28 19:30';
                $kelas->poster = 'https://media-exp1.licdn.com/dms/image/C5622AQHdt0t80nFI1A/feedshare-shrink_800-alternative/0?e=1607558400&v=beta&t=tzKFuaPLbF0NJHDZE1qBIqxsHk8qldAxjDH3MnOA_iE';
                $kelas->deskripsi = 'ini deskripsi acara gaes';
                $kelas->user_id = $user->id;
                $kelas->save();

                $speaker = new DataKelasAlumni();
                $speaker->pembicara = 'Affandy Fahrizain';
                $speaker->tentang = 'Lorem ipsum';
                $speaker->foto = 'https://avatars2.githubusercontent.com/u/28261222?s=460&u=c772b821309f759ebab921152c9825626160aeeb&v=4';
                $speaker->kelas_alumni_id = $kelas->id;
                $speaker->save();
            }
        }
    }
}
