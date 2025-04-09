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
        return News::all();
    }

    public function getDetail(int $id)
    {
        return News::findOrFail($id);
    }

    public function update(array $data, int $id)
    {
        $news = News::findOrFail($id);
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
