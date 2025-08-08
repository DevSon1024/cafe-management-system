<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $model = new UserModel();
        
        $data = [
            'name'     => 'Admin User',
            'email'    => 'admin@cafe.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT), // Use a strong password
            'role'     => 'admin'
        ];

        // Using model's insert function to respect model's configuration
        $model->insert($data);
    }
}