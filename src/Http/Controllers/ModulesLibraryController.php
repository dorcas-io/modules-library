<?php

namespace Dorcas\ModulesLibrary\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dorcas\ModulesLibrary\Models\ModulesLibrary;
use App\Dorcas\Hub\Utilities\UiResponse\UiResponse;
use App\Http\Controllers\HomeController;
use Hostville\Dorcas\Sdk;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\HubController;

class ModulesLibraryController extends HubController {


    const LIBRARY_CATEGORIES = [
        0 => 'General',
        1 => 'Health Sector'
    ];

    const LIBRARY_SUBCATEGORIES = [
        0 => 'For Everyone',
        1 => 'For Businesses',
        2 => 'For Customers',
        3 => 'For Employees'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->data = [
            'page' => ['title' => config('modules-library.title')],
            'header' => ['title' => config('modules-library.title')],
            'selectedMenu' => 'addons',
            'submenuConfig' => 'navigation-menu.addons.sub-menu.modules-library.sub-menu',
            'submenuAction' => ''
        ];
    }

    public function main()
    {
    	$this->data['availableModules'] = HomeController::SETUP_UI_COMPONENTS;
    	return view('modules-library::main', $this->data);
    }

    public function videos(Request $request, Sdk $sdk)
    {
        $this->data['page']['title'] .= ' &rsaquo; Videos';
        $this->data['header']['title'] = 'Videos';
        $this->data['selectedSubMenu'] = 'library-videos';
        $this->data['submenuAction'] = '';

        $this->data['subcategories'] = [];
        foreach (self::LIBRARY_SUBCATEGORIES as $key => $value) {
            $this->data['subcategories'][] = ["id"=>$key, "name" => $value];
        }
        $this->data['categories'] = [];
        foreach (self::LIBRARY_CATEGORIES as $key => $value) {
            $this->data['categories'][] = ["id"=>$key, "name" => $value];
        }

        $this->data['selectedCategory'] = !empty($request->cat) ? $request->cat : 0;
        $this->data['selectedSubCategory'] = !empty($request->subcat) ? $request->subcat : 0;

        $this->setViewUiResponse($request);

        $resources = config('modules-library.library.sample_resources');
        $this->data['videos'] = array_filter($resources, function ($resource) {
            return $resource["resource_type"]=="video" && $resource["resource_category"]==$this->data['selectedCategory'] && ($this->data['selectedSubCategory']==0 ? $resource["resource_subcategory"]>=$this->data['selectedSubCategory'] : $resource["resource_subcategory"]==$this->data['selectedSubCategory']);
        });
        //dd($this->data["videos"]);
        /*$resources = $this->getLibraryResources('video');
        //dd($resources);
        $this->data['videos'] = $resources->filter(function ($resource, $key) {
            return $resource->resource_type=="video" && $resource->resource_category==$this->data['selectedCategory'] && ($this->data['selectedSubCategory']==0 ? $resource->resource_subcategory>=$this->data['selectedSubCategory'] : $resource->resource_subcategory==$this->data['selectedSubCategory']);
            //return $resource;
        })->all();*/
        return view('modules-library::videos.videos', $this->data);
    }




}