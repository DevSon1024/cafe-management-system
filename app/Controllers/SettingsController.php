<?php namespace App\Controllers;

use App\Models\SettingsModel;

class SettingsController extends BaseController
{
    public function index()
    {
        $model = new SettingsModel();
        $data['settings'] = $model->findAllAsArray();
        return view('settings/index', $data);
    }

    public function update()
    {
        $model = new SettingsModel();
        $settings = $this->request->getPost();

        foreach ($settings as $name => $value) {
            $model->updateValue($name, $value);
        }

        return redirect()->to('/admin/settings')->with('status', 'Settings updated successfully');
    }
}