<?php
namespace App\Http\Repositories;

use App\Models\Language;

class LanguageRepository
{
    public function create(array $data)
    {
        $existingLang = Language::withTrashed()->where('code', $data['code'])->first();
        if ($existingLang) {
            if ($existingLang->trashed()) {
                $existingLang->restore();
                $existingLang->update($data);
                return $existingLang;
            } else {
                throw new \Exception('Language with this code already exists and is not deleted.');
            }
        }
        return Language::create($data);
    }

    public function get_all()
    {
        return Language::all();
    }

    public function get_detail(int $id)
    {
        return Language::findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $language = Language::findOrFail($id);
        $language->update($data);
        return $language;
    }

    public function delete(int $id)
    {
        $language = Language::findOrFail($id);
        $language->delete();
        return $language;
    }
}
