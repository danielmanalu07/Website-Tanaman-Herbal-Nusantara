<?php
namespace App\Http\Repositories;

use App\Models\ContactUs;

class AboutUsRepository
{
    public function create(array $data)
    {
        return ContactUs::create($data);
    }

    public function get_all()
    {
        $about_us = ContactUs::with(['languages' => function ($query) {
            $query->where('language_id', currentLanguageId());
        }])->get();
        return $about_us;
    }

    public function get_detail(int $id)
    {
        $about_us = ContactUs::with(['languages' => function ($query) {
            $query->where('language_id', currentLanguageId());
        }])->findOrFail($id);
        return $about_us;
    }

    public function update_about_us(array $data, int $id)
    {
        $about_us = ContactUs::with(['languages' => function ($query) {
            $query->where('language_id', currentLanguageId());
        }])->findOrFail($id);
        $about_us->update($data);
        return $about_us;
    }

    public function delete_about_us(int $id)
    {
        $about_us = ContactUs::findOrFail($id);
        $about_us->delete();
        return $about_us;
    }
}
