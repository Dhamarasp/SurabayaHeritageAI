<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KnowledgeEntry;
use App\Models\User;

class KnowledgeEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@surabayaai.com')->first();
        
        KnowledgeEntry::create([
            'topic' => 'battle of surabaya',
            'keywords' => ['battle of surabaya', 'pertempuran surabaya', '10 november', 'hari pahlawan'],
            'response' => 'Pertempuran Surabaya terjadi pada tanggal 10 November 1945. Ini adalah pertempuran antara pejuang kemerdekaan Indonesia dan pasukan Inggris-India sebagai bagian dari Revolusi Nasional Indonesia. Pertempuran ini diperingati sebagai Hari Pahlawan di Indonesia. Pertempuran dimulai setelah pasukan Inggris mendarat di Surabaya pada akhir Oktober 1945 dengan maksud untuk melucuti pasukan Jepang dan membebaskan tawanan Eropa. Ketegangan meningkat ketika Brigadir Inggris Mallaby terbunuh pada 30 Oktober, yang menyebabkan ultimatum dari Inggris. Ketika pasukan Indonesia menolak untuk menyerah, Inggris melancarkan serangan besar menggunakan kekuatan udara, laut, dan darat.',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        KnowledgeEntry::create([
            'topic' => 'bung tomo',
            'keywords' => ['bung tomo', 'sutomo', 'radio pejuang'],
            'response' => 'Sutomo, yang lebih dikenal sebagai Bung Tomo, adalah seorang aktivis kemerdekaan Indonesia yang memainkan peran penting selama Pertempuran Surabaya. Siaran radionya yang berapi-api menginspirasi rakyat Surabaya untuk melawan pasukan Inggris-India. Lahir pada 3 Oktober 1920, Bung Tomo dikenal dengan kepemimpinannya yang karismatik dan kemampuan orasi yang kuat. Pidatonya yang terkenal pada 10 November 1945 mengobarkan semangat rakyat Surabaya dengan seruan "Merdeka atau Mati!". Setelah kemerdekaan, ia tetap aktif dalam politik tetapi sering berselisih dengan pemerintah. Ia meninggal pada 7 Oktober 1981 dan dianugerahi gelar Pahlawan Nasional Indonesia pada tahun 2008.',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        KnowledgeEntry::create([
            'topic' => 'nama surabaya',
            'keywords' => ['nama surabaya', 'asal usul surabaya', 'sura baya', 'ikan hiu', 'buaya'],
            'response' => 'Nama "Surabaya" dipercaya berasal dari kata "sura" (hiu) dan "baya" (buaya), yang mengacu pada pertempuran legendaris antara kedua makhluk ini yang melambangkan kekuatan Mongol dan pasukan Majapahit Raden Wijaya pada zaman kuno. Menurut legenda, hiu (mewakili kekuatan laut) dan buaya (mewakili kekuatan darat) bertarung sengit di apa yang sekarang menjadi Sungai Kalimas. Pertarungan epik ini menjadi simbol keberanian dan tekad, kualitas yang dikenal dari kota Surabaya. Lambang kota menampilkan kedua hewan ini, memperingati legenda pendiriannya.',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        KnowledgeEntry::create([
            'topic' => 'tugu pahlawan',
            'keywords' => ['tugu pahlawan', 'monumen pahlawan', 'monumen 10 november'],
            'response' => 'Tugu Pahlawan adalah monumen paling terkenal di Surabaya, didirikan untuk memperingati Pertempuran 10 November 1945. Monumen ini berbentuk seperti paku terbalik setinggi 41,15 meter dan terletak di pusat kota Surabaya. Di area ini juga terdapat Museum 10 November yang menampilkan dokumentasi sejarah pertempuran dan pahlawan nasional.',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);
        
        KnowledgeEntry::create([
            'topic' => 'hotel majapahit',
            'keywords' => ['hotel majapahit', 'hotel orange', 'insiden bendera', 'perobekan bendera'],
            'response' => 'Hotel Majapahit, dahulu dikenal sebagai Hotel Oranje, menjadi lokasi insiden penting pada 19 September 1945 saat pemuda Surabaya merobek bagian biru bendera Belanda di atap hotel, sehingga hanya tersisa warna merah putih. Aksi ini menjadi simbol perlawanan terhadap penjajahan dan menambah semangat perjuangan kemerdekaan.',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);
        
        KnowledgeEntry::create([
            'topic' => 'jembatan merah',
            'keywords' => ['jembatan merah', 'red bridge', 'pertempuran jembatan merah'],
            'response' => 'Jembatan Merah adalah lokasi penting dalam Pertempuran Surabaya. Di sini terjadi pertempuran sengit antara pejuang Indonesia dan pasukan Sekutu. Brigadir Jenderal Mallaby tewas di sekitar area ini pada 30 Oktober 1945, yang kemudian memicu serangan besar-besaran dari pasukan Inggris.',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);
        
        KnowledgeEntry::create([
            'topic' => 'kampung ampel',
            'keywords' => ['ampel', 'kampung arab', 'sunan ampel', 'masjid ampel'],
            'response' => 'Kampung Ampel adalah kawasan bersejarah di Surabaya yang menjadi pusat penyebaran Islam pada abad ke-15. Sunan Ampel, salah satu Wali Songo, mendirikan Masjid Ampel di sini sekitar tahun 1421. Hingga kini, kawasan ini tetap menjadi pusat kegiatan keagamaan dan budaya Arab di Surabaya.',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);
        
        KnowledgeEntry::create([
            'topic' => 'sungai kalimas',
            'keywords' => ['kalimas', 'sungai kalimas', 'jalur dagang', 'perdagangan surabaya'],
            'response' => 'Sungai Kalimas adalah salah satu sungai penting di Surabaya yang dulunya menjadi jalur utama perdagangan dan transportasi. Sungai ini menghubungkan Pelabuhan Tanjung Perak dengan pusat kota, menjadikannya nadi ekonomi Surabaya sejak zaman kolonial hingga awal kemerdekaan.',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);
        
        KnowledgeEntry::create([
            'topic' => 'penjara kalisosok',
            'keywords' => ['penjara kalisosok', 'kalisosok', 'penjara kolonial surabaya'],
            'response' => 'Penjara Kalisosok merupakan penjara peninggalan Belanda di Surabaya yang pernah menjadi tempat penahanan tokoh-tokoh pergerakan nasional seperti Bung Karno. Lokasinya kini menjadi bangunan cagar budaya yang menyimpan sejarah perjuangan rakyat Indonesia melawan kolonialisme.',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);
        
        KnowledgeEntry::create([
            'topic' => 'sekolah taman siswa surabaya',
            'keywords' => ['taman siswa', 'sekolah taman siswa', 'ki hajar dewantara'],
            'response' => 'Taman Siswa adalah institusi pendidikan nasional yang didirikan oleh Ki Hajar Dewantara. Cabang Surabaya memainkan peran penting dalam mencerdaskan pemuda dan menyebarkan semangat nasionalisme sebelum kemerdekaan. Sekolah ini menekankan pendidikan yang membebaskan dan mandiri.',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);
        
        KnowledgeEntry::create([
            'topic' => 'revolusi sosial surabaya',
            'keywords' => ['revolusi sosial', 'kerusuhan 1945', 'revolusi rakyat surabaya'],
            'response' => 'Setelah Proklamasi Kemerdekaan, Surabaya mengalami masa revolusi sosial di mana banyak simbol kekuasaan kolonial diserang oleh rakyat. Gedung-gedung pemerintahan, rumah bangsawan Belanda, dan markas Jepang menjadi target dalam perjuangan rakyat menegakkan kedaulatan bangsa.',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);
        
        KnowledgeEntry::create([
            'topic' => 'pahlawan nasional dari surabaya',
            'keywords' => ['pahlawan nasional surabaya', 'pahlawan asal surabaya', 'tokoh kemerdekaan surabaya'],
            'response' => 'Beberapa pahlawan nasional berasal dari atau berjuang di Surabaya, seperti Bung Tomo, Dr. Moestopo, dan Gubernur Suryo. Mereka berkontribusi besar dalam perjuangan mempertahankan kemerdekaan Indonesia khususnya dalam Pertempuran Surabaya.',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);
        
        KnowledgeEntry::create([
            'topic' => 'arsitektur kolonial surabaya',
            'keywords' => ['arsitektur kolonial', 'bangunan belanda', 'gedung tua surabaya'],
            'response' => 'Surabaya memiliki banyak bangunan berarsitektur kolonial Belanda, seperti Gedung Internatio, Balai Pemuda, dan Gedung Siola. Bangunan-bangunan ini mencerminkan kekayaan sejarah kota sebagai pusat perdagangan dan pemerintahan pada masa kolonial.',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        KnowledgeEntry::create([
            'topic' => 'raden wijaya dan pasukan mongol',
            'keywords' => ['raden wijaya', 'pasukan mongol', 'pertempuran mongol', 'surabaya 1293', 'mongol'],
            'response' => 'Pada tahun 1293, Raden Wijaya, pendiri Kerajaan Majapahit, berhasil mengalahkan pasukan Mongol yang dikirim oleh Kubilai Khan. Pertempuran ini terjadi di wilayah yang kini dikenal sebagai Surabaya dan menandai berdirinya kota tersebut.',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        KnowledgeEntry::create([
            'topic' => 'pelabuhan tanjung perak',
            'keywords' => ['pelabuhan tanjung perak', 'tanjung perak', 'pelabuhan surabaya'],
            'response' => 'Pelabuhan Tanjung Perak adalah pelabuhan utama di Surabaya yang dibangun pada awal abad ke-20. Pelabuhan ini memainkan peran penting dalam perdagangan dan transportasi di Indonesia timur.',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);
        
    }
}
