<?php namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\MenuModel;

class CategoryController extends BaseController
{
    public function index()
    {
        $model = new CategoryModel();
        $data['categories'] = $model->findAll();
        return view('categories/index', $data);
    }

    public function new()
    {
        return view('categories/create');
    }

    public function create()
    {
        $model = new CategoryModel();
        $model->save(['name' => $this->request->getPost('name')]);
        return redirect()->to('/categories')->with('status', 'Category Added Successfully');
    }

    public function edit($id = null)
    {
        $model = new CategoryModel();
        $data['category'] = $model->find($id);
        return view('categories/edit', $data);
    }

    public function update($id = null)
    {
        $model = new CategoryModel();
        $model->update($id, ['name' => $this->request->getPost('name')]);
        return redirect()->to('/categories')->with('status', 'Category Updated Successfully');
    }

    public function delete($id = null)
    {
        // Now that you've "imported" the class, you can use it directly
        $menuModel = new MenuModel();
        $categoryModel = new CategoryModel();

        // First, delete menu items associated with the category
        $menuModel->where('category_id', $id)->delete();

        // Now, delete the category itself
        $categoryModel->delete($id);

        return redirect()->to('/categories')->with('success', 'Category and its items were deleted successfully.');
    }
}