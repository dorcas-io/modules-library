<?php

namespace Dorcas\ModulesLibrary\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dorcas\ModulesLibrary\Models\ModulesLibraryVideos;
use Dorcas\ModulesLibrary\Http\Controllers\ModulesLibraryController as Library;
use App\Dorcas\Hub\Utilities\UiResponse\UiResponse;
use App\Http\Controllers\HomeController;
use Hostville\Dorcas\Sdk;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\HubController;


class ModulesLibraryVideosController extends HubController
{
    public function index(Request $request, Sdk $sdk)
    {
        //return redirect()->route('task.create');
        $this->data['page']['title'] .= ' &rsaquo; Academy';
        $this->data['header']['title'] = 'Academy';
        $this->data['selectedSubMenu'] = 'library-videos';
        $this->data['submenuAction'] = '';

        $this->data['subcategories'] = [];
        foreach (Library::LIBRARY_SUBCATEGORIES as $key => $value) {
            $this->data['subcategories'][] = ["id"=>$key, "name" => $value];
        }
        $this->data['categories'] = [];
        foreach (Library::LIBRARY_CATEGORIES as $key => $value) {
            $this->data['categories'][] = ["id"=>$key, "name" => $value];
        }

        $this->data['selectedCategory'] = !empty($request->cat) ? $request->cat : 0;
        $this->data['selectedSubCategory'] = !empty($request->subcat) ? $request->subcat : 0;

        $this->setViewUiResponse($request);

        $resources = $this->getLibraryVideos($request, $sdk);
        //dd($resources);
        $this->data['videos'] = $resources->filter(function ($resource, $key) {
            return $resource->resource_type=="video" && $resource->resource_category==$this->data['selectedCategory'] && ($this->data['selectedSubCategory']==0 ? $resource->resource_subcategory>=$this->data['selectedSubCategory'] : $resource->resource_subcategory==$this->data['selectedSubCategory']);
        })->all();
        return view('modules-library::videos.videos', $this->data);


    }

    public function create()
    {
        /*$tasks = Task::all();
        $submit = 'Add';
        return view('wisdmlabs.todolist.list', compact('tasks', 'submit'));*/
    }

    public function store()
    {
        /*$input = Request::all();
        Task::create($input);
        return redirect()->route('task.create');*/
    }

    public function edit($id)
    {
        /*$tasks = Task::all();
        $task = $tasks->find($id);
        $submit = 'Update';
        return view('wisdmlabs.todolist.list', compact('tasks', 'task', 'submit'));*/
    }

    public function update($id)
    {
        /*$input = Request::all();
        $task = Task::findOrFail($id);
        $task->update($input);
        return redirect()->route('task.create');*/
    }

    public function destroy($id)
    {
        /*$task = Task::findOrFail($id);
        $task->delete();
        return redirect()->route('task.create');*/
    }

}
