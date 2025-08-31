<?php namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\CategoryModel;

class Landing extends BaseController
{
    public function index()
    {
        // Redirect chef away from the landing page
        if (session()->get('isLoggedIn') && session()->get('role') === 'chef') {
            return redirect()->to('/chef/dashboard');
        }

        $menuModel = new MenuModel();
        $categoryModel = new CategoryModel();

        $data['categories'] = $categoryModel->findAll();
        $data['menu_items'] = $menuModel->getMenuItemsWithCategories();

        // Group menu items by category for easier display
        $data['menu_by_category'] = [];
        foreach($data['menu_items'] as $item) {
            $categoryId = $item['category_id'] ?? 'uncategorized';
            $data['menu_by_category'][$categoryId][] = $item;
        }

        return view('landing_page', $data);
    }
}
