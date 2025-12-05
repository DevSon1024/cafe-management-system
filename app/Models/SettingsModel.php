<?php namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'cafe_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'value'];

    public function findAllAsArray()
    {
        $settings_array = $this->findAll();
        $settings = [];
        foreach ($settings_array as $setting) {
            $settings[$setting['name']] = $setting['value'];
        }
        return $settings;
    }

    public function updateValue($name, $value)
    {
        $this->where('name', $name)->set('value', $value)->update();
    }
}