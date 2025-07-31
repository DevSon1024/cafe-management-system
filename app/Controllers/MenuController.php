<?php namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\CategoryModel;
// It's good practice to also have a CategoryModel

class MenuController extends BaseController
{
    // List all menu items
    public function index()
    {
        $model = new MenuModel();
        // This is more advanced, but shows how you'd get category names
        $data['items'] = $model->select('menu_items.*, categories.name as category_name')
                               ->join('categories', 'categories.id = menu_items.category_id', 'left')
                               ->findAll();
        return view('menu/index', $data);
    }

    // Show form to add a new item
    public function new()
    {   
        $categoryModel = new CategoryModel(); // 👈 ADD
        $data['categories'] = $categoryModel->findAll();
        // In a real app, you'd fetch categories from the DB
        return view('menu/create', $data);
    }

    // Process the new item form submission
    public function create()
    {
        $model = new MenuModel();
        
        // --- Image Upload ---
        $img = $this->request->getFile('image');
        $imgName = 'default.jpg'; // Default image
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $imgName = $img->getRandomName();
            $img->move('uploads/', $imgName);
        }

        $data = [
            'name'      => $this->request->getPost('name'),
            'category_id' => $this->request->getPost('category_id'),
            'price'     => $this->request->getPost('price'),
            'image'     => $imgName
        ];

        $model->save($data);
        return redirect()->to('/menu')->with('status', 'Menu Item Added Successfully');
    }

    // Show form to edit an item
    public function edit($id = null)
    {
        $model = new MenuModel();
        $categoryModel = new CategoryModel();
        $data['item'] = $model->find($id);
        $data['categories'] = $categoryModel->findAll();
        return view('menu/edit', $data);
    }

    // Process the edit form submission
    public function update($id = null)
    {
        $model = new MenuModel();
        $data = [
            'name'  => $this->request->getPost('name'),
            'category_id' => $this->request->getPost('category_id'),
            'price' => $this->request->getPost('price'),
        ];
        
        $img = $this->request->getFile('image');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $imgName = $img->getRandomName();
            $img->move('uploads/', $imgName);
            $data['image'] = $imgName;
        }

        $model->update($id, $data);
        return redirect()->to('/menu')->with('status', 'Menu Item Updated Successfully');
    }

    // Delete an item
     public function delete($id = null)
    {
        $model = new MenuModel();
        // Deleting a menu item has no children, so this is safe.
        $model->delete($id);
        return redirect()->to('/menu')->with('status', 'Menu Item Deleted Successfully');
    }
}