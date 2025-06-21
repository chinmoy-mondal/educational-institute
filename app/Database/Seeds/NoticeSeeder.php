<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class NoticeSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $data = [
                'title'       => $faker->sentence(6),
                'body'        => $faker->paragraph(3),
                'notice_date' => $faker->date(),
                'created_at'  => date('Y-m-d H:i:s'),
            ];

            $this->db->table('notices')->insert($data);
        }
    }
}
