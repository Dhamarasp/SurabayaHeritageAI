<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Keyword;
use App\Models\User;

class KeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@surabayaai.com')->first();
        
        // Surabaya keywords
        $surabayaKeywords = [
            'surabaya', 'suroboyo', 'sby', 'jawa timur', 'east java',
            'tugu pahlawan', 'hotel majapahit', 'bung tomo', 'jembatan merah',
            'kalimas', 'ampel', 'arek suroboyo', '10 november', 'pemuda surabaya',
            'gedung siola', 'balai pemuda', 'balai kota surabaya', 'monumen kapal selam',
            'kampung lawas maspati', 'pantai kenjeran', 'kebun binatang surabaya',
            'jembatan suramadu', 'bratang', 'tambaksari', 'dr soetomo', 'emeri suroboyo',
            'pabrik rokok cap 93', 'roti oberoi', 'kya-kya', 'pecinan surabaya',
            'pasar atom', 'pasar turi', 'darmo', 'wonokromo', 'krembangan', 'pegirian',
            'rolak', 'peneleh', 'gunungsari', 'kalijudan', 'karangmenjangan',
            'kampung arab', 'kampung cina', 'kampung eropa', 'kampung kolonial',
            'kampung pelabuhan', 'kampung nelayan', 'kampung pekerja pelabuhan'
        ];
        
        foreach ($surabayaKeywords as $word) {
            Keyword::create([
                'type' => 'surabaya',
                'word' => $word,
                'is_active' => true,
                'created_by' => $admin ? $admin->id : null,
                'updated_by' => $admin ? $admin->id : null,
            ]);
        }
        
        // History keywords
        $historyKeywords = [
            'sejarah', 'history', 'masa lalu', 'apa', 'perang', 'nama',
            'pahlawan', 'kemerdekaan', 'kolonial', 'kerajaan', 'zaman',
            'belanda', 'jepang', 'penjajahan', 'pertempuran', 'revolusi',
            'zaman belanda', 'zaman jepang', 'zaman kerajaan', 'era kolonial',
            'era kemerdekaan', 'pendudukan belanda', 'pendudukan jepang',
            'perjuangan kemerdekaan', 'resolusi jihad', 'tokoh kemerdekaan',
            'revolusi fisik', 'zaman orde lama', 'zaman orde baru',
            'tokoh pejuang', 'tokoh nasional', 'peristiwa sejarah',
            'gerakan pemuda', 'organisasi perlawanan', 'laskar rakyat',
            'senjata bambu runcing', 'strategi gerilya', 'pengungsian',
            'perlawanan rakyat', 'penjajahan asing', 'kemerdekaan indonesia',
            'peristiwa bersejarah', 'monumen bersejarah', 'penjajahan kolonial',
            'konflik bersenjata', 'pertahanan rakyat', 'perjuangan rakyat surabaya',
            'kapan'
        ];
        
        foreach ($historyKeywords as $word) {
            Keyword::create([
                'type' => 'history',
                'word' => $word,
                'is_active' => true,
                'created_by' => $admin ? $admin->id : null,
                'updated_by' => $admin ? $admin->id : null,
            ]);
        }
    }
}
