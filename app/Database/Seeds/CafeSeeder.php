<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CafeSeeder extends Seeder
{
    public function run()
    {
        // Seed Categories
        $this->db->table('categories')->insertBatch([
            ['name' => 'Hot Coffee'],
            ['name' => 'Cold Coffee'],
            ['name' => 'Snacks'],
            ['name' => 'Desserts'],
        ]);

        // Seed Tables
        $this->db->table('tables')->insertBatch([
            ['name' => 'Table 1', 'status' => 'Available'],
            ['name' => 'Table 2', 'status' => 'Available'],
            ['name' => 'Table 3', 'status' => 'Occupied'],
            ['name' => 'Table 4', 'status' => 'Available'],
            ['name' => 'Counter 1', 'status' => 'Available'],
        ]);

        // Seed Staff
        $this->db->table('staff')->insertBatch([
            ['name' => 'John Doe', 'role' => 'Admin', 'shift' => 'Morning'],
            ['name' => 'Jane Smith', 'role' => 'Cashier', 'shift' => 'Morning'],
        ]);

        // Seed Menu Items
        $this->db->table('menu_items')->insertBatch([
            ['name' => 'Espresso', 'category_id' => 1, 'price' => 2.50, 'image' => 'espresso.jpg'],
            ['name' => 'Latte', 'category_id' => 1, 'price' => 3.50, 'image' => 'latte.jpg'],
            ['name' => 'Iced Americano', 'category_id' => 2, 'price' => 3.00, 'image' => 'iced_americano.jpg'],
            ['name' => 'Croissant', 'category_id' => 3, 'price' => 2.75, 'image' => 'croissant.jpg'],
            ['name' => 'Cheesecake', 'category_id' => 4, 'price' => 4.50, 'image' => 'cheesecake.jpg'],
        ]);
    }
}