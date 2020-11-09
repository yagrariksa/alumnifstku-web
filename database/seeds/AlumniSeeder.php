<?php

use Illuminate\Database\Seeder;
use App\Alumni;
use App\BiodataAlumni;
use App\TracingAlumni;
use App\NotifAlumni;
use App\SharingAlumni;
use App\KomentarSharingAlumni;
use App\PostAttribute;
use App\TagPost;
use Carbon\Carbon;

class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nama' => 'Affandy Fahrizain',
                'angkatan' => '2016',
                'jurusan' => 'S1 Sistem Informasi',
                'linkedin' => 'https://linkedin.com/affandyfahrizain',
                'foto' => 'https://avatars2.githubusercontent.com/u/28261222?s=460&u=c772b821309f759ebab921152c9825626160aeeb&v=4'
            ],
            [
                'nama' => 'Reinaldy Subiakto',
                'angkatan' => '2016',
                'jurusan' => 'S1 Sistem Informasi',
                'linkedin' => 'https://www.linkedin.com/in/reinaldy-subiakto/',
                'foto' => 'https://media-exp1.licdn.com/dms/image/C5603AQEn4sn1P8UdWA/profile-displayphoto-shrink_200_200/0?e=1605139200&v=beta&t=VPQHFbBroUIwqxAO-qRMmDUvw_qWVWPzLJ4tmUF2Ni4'
            ]
        ];

        $company = [
            [
                [
                    'perusahaan' => 'Trydev',
                    'tahun_masuk' => '2017',
                    'jabatan' => 'Fullstack Developer',                
                ],
                [
                    'perusahaan' => 'Tokopedia',
                    'tahun_masuk' => '2020',
                    'jabatan' => 'Data Analyst',                
                ],
            ],
            [
                [
                    'perusahaan' => 'SevenQbits',
                    'tahun_masuk' => '2018',
                    'jabatan' => 'Manager',
                ],
            ],
        ];

        $post = [
            [
                [
                    'foto' => 'https://rencanamu.id/assets/file_uploaded/blog/1555831965-social-med.jpg',
                    'deskripsi' => 'lorem ipsum dolor sit amet',                
                ],
                [
                    'foto' => 'https://www.ramblers.org.uk/-/media/Images/Get%20involved/Cotswold%20Outdoor/cotswold%201.ashx?la=en&hash=346928C069B4FF73422FD4468472AEE0',
                    'deskripsi' => 'tes posting gan',
                ],
            ],
            [
                [
                    'foto' => 'https://www.jakartanotebook.com/images/products/80/63/36541/8/tenda-camping-outdoor-adventure-3-4-orang-green-1.jpg',
                    'deskripsi' => 'ini cuma testing saja',                
                ]
            ]
        ];

        $cmt = [
            [
                'text' => 'tes komentar',
            ],
            [
                'text' => 'tes komentar baru',
            ],
            [
                'text' => 'tes komentar lagi',
            ],
        ];

        for ($i=0; $i < 2; $i++) { 
            $alumni = new Alumni();
            $alumni->email = 'alumni'.$i.'@gmail.com';
            $alumni->username = 'alumni'.$i;
            $alumni->password = Hash::make('testing');
            $alumni->save();
    
            $bio = new BiodataAlumni();
            $bio->nama = $data[$i]['nama'];
            $bio->angkatan = $data[$i]['angkatan'];
            $bio->jurusan = $data[$i]['jurusan'];
            $bio->alumni_id = $alumni->id;
            $bio->linkedin = $data[$i]['linkedin'];
            $bio->foto = $data[$i]['foto'];
            $bio->save();
            
            if ($i==0) { 
                $tracing = new TracingAlumni();
                $tracing->perusahaan = $company[$i][0]['perusahaan'];
                $tracing->tahun_masuk = $company[$i][0]['tahun_masuk'];
                $tracing->jabatan = $company[$i][0]['jabatan'];  
                $tracing->alumni_id = $alumni->id;
                $tracing->save();

                $post = new SharingAlumni();
                $post->foto = 'google';                        
                $post->deskripsi = 'tes';
                $post->alumni_id = $alumni->id;
                $post->save();

                $attr = new PostAttribute();
                $attr->like_count = 324;
                $attr->comment_count = 2;
                $attr->sharing_alumni_id = $post->id;
                $attr->save();

                if ($i == 0) {
                    $tag = new TagPost();
                    $tag->alumni_id = $alumni->id;
                    $tag->sharing_alumni_id = $post->id;
                    $tag->save();
                }

                for ($k=0; $k < 3; $k++) { 
                    $comment = new KomentarSharingAlumni();
                    $comment->text = $cmt[$k]['text'];
                    $comment->alumni_id = $alumni->id;
                    $comment->sharing_alumni_id = $post->id;
                    $comment->save();
                }
            }

            for ($j=0; $j < 5; $j++) { 
                $notif = new NotifAlumni();
                $notif->text = 'Lorem ipsum dolor sit amet';
                $notif->is_read = $j%2;
                $notif->alumni_id = $alumni->id;
                $notif->readed_at = Carbon::now();
                $notif->save();
            }
            
        }


    }
}
