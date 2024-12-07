<?php

namespace App\Http\Controllers\Admin;

use App\Models\GlobalEnvironment;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\CrudPanel;

// VALIDATION: change the requests to match your own file names if you need form validation

/**
 * Class AccessLogCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class WelcomeController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\AccessLog');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/admin/welcome');
        $this->crud->setEntityNameStrings('Access Logs', 'Welcome');
        $this->crud->setListView('welcome');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
    }

}
