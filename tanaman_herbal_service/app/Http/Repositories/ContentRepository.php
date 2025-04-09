<?php
namespace App\Http\Repositories;

use App\Models\Content;

class ContentRepository
{
    public function create(array $data)
    {
        return Content::create($data);
    }

    public function get_all()
    {
        return Content::all();
    }

    public function get_detail(int $id)
    {
        return Content::findOrFail($id);
    }

    public function update(array $data, int $id)
    {
        $content = Content::findOrFail($id);
        $content->update($data);
        return $content;
    }
    public function delete(int $id)
    {
        $content = Content::findOrFail($id);
        $content->delete();
        return $content;
    }

    public function update_status(int $id, bool $status)
    {
        $contents = Content::findOrFail($id);
        $contents->update([
            'status' => $status,
        ]);

        return $contents;
    }
}
