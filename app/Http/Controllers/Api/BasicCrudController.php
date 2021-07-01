<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenreRequest;
use App\Models\Genre;
use Illuminate\Http\Request;

abstract class BasicCrudController extends Controller
{
    protected abstract function model();
    protected abstract function rulesStore();
    protected abstract function rulesUpdate();

    protected function findOrFail($id)
    {
        $newObject = $this->model();
        $keyName = (new $newObject)->getRouteKeyName();
        return $this->model()::where($keyName, $id)->firstOrFail();
    }

    public function store(Request $request)
    {
        $validatedData = $this->validate($request->all(), $this->rulesStore());
        $newObject = $this->model()::create($validatedData);
        $newObject->refresh();
        return $newObject;
    }

    public function update(Request $request, $id)
    {
        $validatedData = $this->validate($request->all(), $this->rulesUpdate());
        $newObject = $this->findOrFail($id);
        $newObject->update($validatedData);
        return $newObject;
    }

    public function show($id)
    {
        return $this->findOrFail($id);
    }

    public function destroy($id)
    {
        $newObject = $this->findOrFail($id);
        $newObject->delete();
        return response()->noContent();
    }

    public function index()
    {
        return $this->model()::all();
    }
}
