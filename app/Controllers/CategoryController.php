<?php namespace App\Controllers;

use App\Models\CategoryModel;

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
        $model = new CategoryModel();
        // Now that the database handles cascading, this will work.
        $model->delete($id);
        return redirect()->to('/categories')->with('status', 'Category and its items were deleted successfully.');
    }
}