<?php
namespace App\Http\Repositories;

use App\Models\News;

class NewsRepository
{
    public function create(array $data)
    {
        return News::create($data);
    }

    public function getAll()
    {
        $news = News::with(['languages' => function ($query) {
            $query->where('language_id', currentLanguageId());
        }])->get();
        return $news;
    }

    public function getDetail(int $id)
    {
        $news = News::with(['languages' => function ($query) {
            $query->where('language_id', currentLanguageId());
        }])->findOrFail($id);
        return $news;
    }

    public function update(array $data, int $id)
    {
        $news = News::with(['languages' => function ($query) {
            $query->where('language_id', currentLanguageId());
        }])->findOrFail($id);
        $news->update($data);
        return $news;
    }

    public function delete(int $id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        return $news;
    }

    public function update_status(int $id, array $data)
    {
        $news = News::findOrFail($id);
        $news->update($data);

        return $news;
    }
}
