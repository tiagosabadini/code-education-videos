<?php

namespace App\Http\Controllers\Api;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends BasicCrudController
{

    private $rules;

    public function __construct()
    {
        $this->rules = [
            'title' => 'required|max:255',
            'description' => 'required',
            'year_launched' => 'required|date_format:Y',
            'opened' => 'boolean',
            'rating' => 'required|in:' . implode(',', Video::RATING_LIST),
            'duration' => 'required|integer',
            'categories_id' => 'required|array|exists:categories,id',
            'genres_id' => 'required|array|exists:genres,id',
        ];
    }

    public function store(Request $request)
    {
        $validatedData = $this->validate($request, $this->rulesStore());
        /** @var Video $newObject */
        $newObject = $this->model()::create($validatedData);
        $newObject->categories()->sync($request->get('categories_id'));
        $newObject->genres()->sync($request->get('genres_id'));
        $newObject->refresh();
        return $newObject;
    }

    public function update(Request $request, $id)
    {
        $validatedData = $this->validate($request, $this->rulesUpdate());
        $newObject = $this->findOrFail($id);
        $newObject->update($validatedData);
        $newObject->categories()->sync($request->get('categories_id'));
        $newObject->genres()->sync($request->get('genres_id'));
        return $newObject;
    }


    public function rulesUpdate()
    {
        return $this->rules;
    }

    public function rulesStore()
    {
        return $this->rules;
    }

    public function model()
    {
        return Video::class;
    }
}
