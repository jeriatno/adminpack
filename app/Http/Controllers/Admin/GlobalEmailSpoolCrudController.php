<?php

    namespace App\Http\Controllers\Admin;

    use App\Models\GlobalEmailSpool;
    use App\Services\EmailSpoolService;
    use App\Traits\HasLogger;
    use Backpack\CRUD\app\Http\Controllers\CrudController;

    // VALIDATION: change the requests to match your own file names if you need form validation
    use App\Http\Requests\GlobalEmailSpoolRequest as StoreRequest;
    use App\Http\Requests\GlobalEmailSpoolRequest as UpdateRequest;
    use Backpack\CRUD\CrudPanel;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Prologue\Alerts\Facades\Alert;

    /**
     * Class GlobalEmailSpoolCrudController
     *
     * @package App\Http\Controllers\Admin
     * @property-read CrudPanel $crud
     */
    class GlobalEmailSpoolCrudController extends CrudController
    {
        use HasLogger;

        protected $emailSpoolService;

        public function __construct()
        {
            parent::__construct();
            $this->emailSpoolService = new EmailSpoolService();
        }

        public function setup()
        {
            /*
            |--------------------------------------------------------------------------
            | CrudPanel Basic Information
            |--------------------------------------------------------------------------
            */
            $this->crud->setModel('App\Models\GlobalEmailSpool');
            $this->crud->setRoute(config('backpack.base.route_prefix') . '/global-email-spool');
            $this->crud->setEntityNameStrings('Email Spool', 'Email Spool');
            $this->crud->denyAccess('create');
            $this->crud->denyAccess('update');
            $this->crud->denyAccess('delete');
            $this->crud->disableResponsiveTable();
            $this->crud->addButtonFromView('line', 'email_spool.cancel', 'email_spool.cancel', 'beginning');
            $this->crud->setListView('email_spool.list');
            /*
            |--------------------------------------------------------------------------
            | CrudPanel Configuration
            |--------------------------------------------------------------------------
            */

            // TODO: remove setFromDb() and manually define Fields and Columns
            $this->crud->setFromDb();

            $this->crud->addFilter([ // select2_multiple filter
                'name' => 'module_name',
                'type' => 'select2',
                'label'=> 'Module Name'
            ], function() {
                $distinct_data=GlobalEmailSpool::select('module_name')
                    ->distinct()->orderBy('module_name')->get();
                $data=[];
                if($distinct_data){
                    foreach($distinct_data as $key=>$val){
                        $data[$val->module_name] = $val->module_name;
                    }
                }
                return  $data;
            }, function($value) { // if the filter is active
                $this->crud->addClause('Where', 'module_name', $value);
            });

            $this->crud->addFilter([
                'name' => 'status',
                'type' => 'select2',
                'label' => 'Status'
            ], function () {
                return [
                    '1' => 'Success',
                    '-1' => 'Failed',
                ];
            }, function ($value) {
                $this->crud->addClause('Where', 'status', $value);
            });

            $this->crud->addFilter([ // daterange filter
                'type' => 'date_range',
                'name' => 'action_time',
                'label' => 'Action TIme'
            ], false, function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'action_time', '>=', $dates->from);
                $this->crud->addClause('where', 'action_time', '<=', $dates->to . ' 23:59:59');
            });

            $this->crud->addFilter([ // daterange filter
                'type' => 'date_range',
                'name' => 'send_time',
                'label' => 'Send TIme'
            ], false, function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'send_time', '>=', $dates->from);
                $this->crud->addClause('where', 'send_time', '<=', $dates->to . ' 23:59:59');
            });

            $this->crud->addFilter([ // daterange filter
                'type' => 'date_range',
                'name' => 'received_time',
                'label' => 'Received TIme'
            ], false, function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'received_time', '>=', $dates->from);
                $this->crud->addClause('where', 'received_time', '<=', $dates->to . ' 23:59:59');
            });

            $this->crud->orderBy('created_at', 'desc');
            // add asterisk for fields that are required in GlobalEmailSpoolRequest
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

        public function cancel(Request $request)
        {
            GlobalEmailSpool::where('id', $request->id)->delete();

            return response()->json([
                'message' => 'success'
            ]);
        }

        public function resend(Request $request, $id)
        {
            $logger = GlobalEmailSpool::find($id);

            try {
                $action = $request->get('action');
                $model = new GlobalEmailSpool::$docType[$logger->module_name];
                $data = $model->find($logger->doc_id);
                $action_name = $action ?? $logger->action_name;
                $refId = $logger->doc_ref_id ?? null;

                // send notification
                $this->emailSpoolService->sendNotification(
                    $logger->module_name,
                    $data,
                    $action_name,
                    null,
                    false,
                    [],
                    $refId
                );

                Alert::success(trans('The email successfully sent.'))->flash();

                return redirect()->back();
            } catch (\Exception $ex) {
                $this->errorMessage($ex, $logger->module_name, __METHOD__, $id);
                DB::rollBack();

                Alert::warning(trans('The email was not sent successfully.'))->flash();

                return redirect()->back()->withErrors($ex->getMessage());
            }
        }
    }
