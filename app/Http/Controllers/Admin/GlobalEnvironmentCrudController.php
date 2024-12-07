<?php

namespace App\Http\Controllers\Admin;

// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\CRUD\CrudPanel;
use App\Http\Requests\ProvinceRequest as StoreRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\ProvinceRequest as UpdateRequest;

/**
 * Class ProvinceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class GlobalEnvironmentCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\GlobalEnvironment');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/global-config/environment');
        $this->crud->setEntityNameStrings('Global Environment', 'Global Environments');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->disableResponsiveTable();

        $this->crud->addColumns([
            [
                'label' => "Application Name",
                'type' => 'text',
                'name' => 'application_name',
            ],
            [
                'label' => "Key Name",
                'type' => 'text',
                'name' => 'key_name',
            ],
            [
                'label' => "Value",
                'type' => 'text',
                'name' => 'value',
            ],
            [
                'label' => "Description",
                'type' => 'text',
                'name' => 'description',
            ],
        ]);

        $this->crud->addFields([
            [
                'label' => "Application Name",
                'type' => 'text',
                'name' => 'application_name',
            ],
            [
                'label' => "Key Name",
                'type' => 'text',
                'name' => 'key_name',
            ],
            [
                'label' => "Value",
                'type' => 'textarea',
                'name' => 'value',
            ],
            [
                'label' => "Description",
                'type' => 'textarea',
                'name' => 'description',
            ],
        ]);

        $this->crud->addClause('orderBy', 'updated_at', 'desc');

        // add asterisk for fields that are required in ProvinceRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
