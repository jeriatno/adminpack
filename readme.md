<p align="center"><img src="" width="250px"></p>

## About AdminPack

AdminPack is a comprehensive admin panel designed to simplify and optimize the management of web applications. 
With its intuitive interface and powerful features, AdminPack serves as the backbone for administrative control, allowing seamless integration with various modules.

## App Docs (How To)

### ℹ️ EmailSpool service

Guide on implementing and using the EmailSpool service.

1. Define your action in `\App\Enums` :

    ```php
    class YourModuleAction {
        const REQUEST = 'request';
        // etc
    }
    ```

2. Define your email configuration using a `seeder`:

    ```bash
    php artisan make:seeder GlobalEmailConfigForYourModuleSeeder
    ```
    
    ```php
    class GlobalEmailConfigForYourModuleSeeder extends Seeder {
        public function run() {
            $emails = [
                [
                   'app_name'    => config('app.name'),
                   'module_name' => 'your-module',
                   'to'          => 'By System',
                   'cc'          => 'By System',
                   'subject'     => 'Your Module - [DocNumber] - '.YourModuleAction::EVENT_NAME,
                   'action'      => YourModuleAction::ACTION_NAME,
                ], //etc 
            ];
   
            foreach ($emails as $emailData) {
                \App\Models\GlobalEmailConfig::updateOrCreate($emailData);
            }
        }
    }
    ```
   
3. Prepare your view in `views/your-module/email.blade.php` : : 

    ```
        @extends('layouts.app-email')
        @section('content')
           // Your email body content here
           ...
        @endsection
    ```

4. Implement the `WithRecipients` interface in your Repository:

    ```php
    class YourRepository extends BaseRepository implements BaseContract, WithRecipients {
        ...
    }
    ```

5. Add`setRecipients` method stub in your Repository:

    ```php
    class YourRepository extends BaseRepository implements BaseContract, WithRecipients {
        ...
        public function setRecipients($data, $action, $config, $refId = null): array
        {
            ...
            // Define your action
            $to = [];
            $cc = [];
            $bcc = [config('mail.to')];
            switch ($action) {
                case YourModelAction::REQUEST:
                    $to = ['email_1'];
                    $cc = ['email_1', 'email_2'];
                    break;
             }
   
             return ['to' => $to, 'cc' => $cc, 'bcc' => $bcc];
        }
    }
    ```

6. Set properties in the `GlobalEmailSpool` model:

    ```php
    class GlobalEmailSpool extends Model {
        ...
        public static $docType = [
            ...
            'your_module'     => YourModel::class
        ];
    
        public static $emailConf = [
            ...
            'your_module'        => GlobalEmailConfig::class
        ];
    
        public static $emailLog = [
            ...
            'your_module'     => YourRepository::class
        ];
    
        public const module = [
            ...
            'your_module'        => 'your-module'
        ];
    
        public const views = [
            ...
            'your_module'        => 'your-view.email'
        ];
    
        public const url = [
            ...
            'your_module'        => 'your-route'
        ];
    
        public static $docNumber = [
            ...
            'your_module'        => 'your-column-number'
        ];
    }
    ```

7. Implement the service in your Repository:

    ```php
    class YourRepository extends BaseRepository implements BaseContract, WithRecipients {
        ...
        private $emailSpoolService;
        public function __construct() {
            ...
            $this->emailSpoolService = new EmailSpoolService();
        }
        
        public function yourMethod() {
            ...
            // send notification 
            $this->emailSpoolService->sendNotification('your_module', $data, YourModuleAction::ACTION_NAME);
            // or with notes
            $this->emailSpoolService->sendNotification('your_module', $data, YourModuleAction::ACTION_NAME, $notes);
            // or send to principal
            $this->emailSpoolService->sendNotification('your_module', $data, YourModuleAction::ACTION_NAME, null, true);
            // or with attachments
            $this->emailSpoolService->sendNotification('your_module', $data, YourModuleAction::ACTION_NAME, null, false, [
                'document_name' => $data->document_path ?? null
            ]);
            // or with other ID
            $this->emailSpoolService->sendNotification('your_module', $data, YourModuleAction::ACTION_NAME, null, true, [], $otherId);
        }
    }
    ```

### ℹ️ Cancel Document

Instructions for adding bulk cancel functionality using the Cancelable trait.

1. Set the `bulk-cancel` route in your module in `custom.php`:

     ```php
     Route::post('bulk-cancel', [YourController::class, 'bulkCancel']);
     ```

2. Use the `Cancelable` trait in your Controller:

    ```php
    class YourController extends CrudController {
        use Cancelable;
        ...
    }
    ```

3.  Initialize an instance of YourRepository :

    ```php
    protected $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = new YourRepository();
    }
    ```
   
4. Implement the `cancel` function by extending `BaseRepository` and implementing `BaseContract` in your Repository:

    ```php
    class YourRepository extends BaseRepository implements BaseContract {
        ...
    }
    ```

    **Note:
    Check the status column type in your model:
    - If the column type is integer, define constants in your model (e.g., const CANCELLED = -1;).
    - If the column type is string, you don't need to define constants; just use string values directly. <br><br>

5. Override the `delete` method in your Repository

   ```php
   class YourRepository extends BaseRepository implements BaseContract {
        ...
        public function delete($id)
        {
            // set delete to all related models
            ...
            // and than your model 
            return $this->model->where('id', $id)->delete();
        }
    }
    ```

6. Ensure all models to be deleted have a softDeletes column in the migration and use the `SoftDeletes` trait in each model:
    
    ```php
    class AddDeletedAtToYourTable extends Migration {
        public function up() {
            Schema::table('your_table_name', function (Blueprint $table) {
                $table->softDeletes()->nullable()->after('updated_at');
            }); 
        }
    }
   ```

   ```php 
    class YourModel extends Model {
        use SoftDeletes;
        ...
    }
    ```
   
7. Show the `Bulk Cancel` button at the top of the table & Enable bulk actions: 

    ```php
   class YourController extends CrudController {
        ...
        public function setup() {
            $this->crud->enableBulkActions();
   
            if(isAdmin()) {
                $this->crud->addButtonFromView('top', 'cancel', 'cancel', 'end');
            }
            ...
        }
    }
    ```

### ℹ️ Response Handling

Standardized response formats and methods for returning data in your repository and controller.

1. Ensure your repository uses the following format:

   ```php
   class YourRepository extends BaseRepository implements BaseContract {
        ...
        public function yourMethod()
        {
            try {
                return $data; //  or true;
            } catch(Exception $exception) {
                return $exception;        
            }
        }
    }
    ```

2. Implement it in your controller as follows:

    ```php
    class YourController extends CrudController {
        ...
        public function yourMethod()
        {
            $data = $this->repository->yourMethod();
   
            // if the return is a redirect to a view
            return ResponseBase::view($data);
   
            // if the return is in JSON format
            return ResponseBase::json($data);
        }
    }
    ```

3. Use other parameters for specific purposes:

    ```php
    // if the return is a redirect to a view
    return ResponseBase::view($data, string $redirectUrl = null, $msg = null, $showError = false);

    // if the return is in JSON format
    return ResponseBase::json($data, $msg = null, $showError = false, $autoHide = true, $isDirect = false);
    ```

### ℹ️ Managing Attachments

Guide on managing file attachments within your models using the `HasAttachments` trait.

1. Use the `HasAttachments` trait in your Model:

    ```php
    class YourModel extends Model {
        use HasAttachments;
        ...
    }
    ```
   
2. Set properties in the `yourModel` model:

    ```php
    class YourModel extends Model {
        use HasAttachments;
        ...
        // Define the var for the attachments
        protected $docNo = 'doc_number'; // optional, if 'doc_no' column not exists
        protected $storagePath = 'Your/Directory/Path';
        protected $attachmentFields = ['your_attach_field'];
    }
    ```

3. Implement it in your repository as follows:

    ```php
    class YourRepository extends BaseRepository implements BaseContract {
        ...
        public function yourMethod($request)
        {
            $data = $this->repository->create([
                ...
            ]);

            // prepare the attachment
            $attach = $data->attach($request);
   
            // or If need $number other. By default use DocNumber.
            $attach = $data->attach($request, $number);
            
            // save the attachment
            $this->model->where('id', $data->id)->update([
                 'your_attach_field'      => $attach['your_attach_field']['path'] ?? null, // optional
                 'your_attach_field_name' => $attach['your_attach_field']['name'] ?? null,
            ]);
            ...
        }
    }
    ```
   
4. To preview image/file in show page, use this component :

    ```php 
        @component('components.button.preview', [
            'attachment' => $entry->your_attach_field
        ]) @endcomponent
   ```

### ℹ️ Notification Badge

How to display and manage notification badges in the sidebar. 

1. Create a menu in the sidebar in the file `sidebar_content.blade.php`:

    ```php
    ...
    <li>
        <a id="yourMenu" href='{{ backpack_url('your-route') }}'>
            <i class='fa fa-your-icon'></i>
            <span>Your Menu <span class="notif-badge" id="your-menu-badge"></span></span>
        </a>
    </li>
   
   // or if use menu component
    @include('components.menu', [
        'menu' => 'Your Menu',
        'useNotif' => true // notif for menu
        'submenu' => [
            [
                'url' => 'your-submenu-url',
                'label' => 'Your Submenu',
                'useNotif' => true // notif for submenu
            ],
        ],
    ])
    ```

2. Define your module in `notif_badge.blade.php` :

    ```php
    ...
    const YOUR_MODULE = 'your-module'
    ```
   
3. Add notification types for your module in the `setNotifForModule` function:

   ```php
    function setNotifForModule(module, response) {
        let res = response.data

        if (module === YOUR_MODULE) {
            setNotifBadge(module, 'all', res.notif_for_all); // for notifications in the "all" tab in your menu
            setNotifBadge(module, 'requester', res.notif_for_requester); // for notifications in the "my data" tab in your menu
            ...
        }
   
       if (module === 'ALL') {
            setNotifBadge(YOUR_MODULE, '', res.your_module); // for notifications in the main menu in the sidebar
        }
        ...
   ```
   
4. Add an event listener in `$(function() {})`:

   ```php
   $(function () {
        ...
       if (currentURL.indexOf('/admin/'+YOUR_MODULE) {
            NotifBadgeComponent.forModule(YOUR_MODULE)
        }
   })
   ```

5. Set the `notif-badge` route in your module in `custom.php`:

     ```php
     Route::post('notif-badge', [YourController::class, 'getNotifBadge']);


6. Use the `NotifBadges` trait in your Controller:

    ```php
    class YourController extends CrudController {
        use NotifBadges;
        ...
    }
    ```
   
7. Prepare notification data in your module repository by overriding the notify function from `BaseRepository`:

   ```php
   public function notify(): array
    {
        // prepare status
        $status = [
            'requester'        => [
                 YourModel::PENDING_REQUESTER
                 ...
             ],
            ...
        ];
    
        if (isAdmin()) {
            $notifCountRequester = $this->model->where('requested_by', $userId)
                                    ->whereIn('status', $status['requester'])->count();
            ...
        } else {
            ...
        }
    
        $notifCountAll = (
            ($notifCountRequester ?? 0) +
            ...
        );
    
        return [
            'notif_count'                => $notifCountAll ?? 0, // for notifications in the main menu in the sidebar
            'notif_for_all'              => $notifCountAll ?? 0, // for notifications in the "all" tab in your menu
            'notif_for_requester'        => $notifCountRequester ?? 0, // for notifications in the "my data" tab in your menu
            ...
        ];
    }
   ```

### ℹ️ User Request Display

How to Add Requester Icons with Tooltips to Your Table Columns.

1. Ensure the data is related to the user model:

    ```php 
        class YourModel extends Model
        {
            ...
            public function requestedBy()
            {
                return $this->belongsTo(User::class, 'created_by', 'id');
            }
    ```

2. Implement using the requester icon component:

    ```php 
        $this->crud->addColumns($columns);
            'name'     => 'requested_by',
            'label'    => 'Requested by',
            'type'     => 'closure',
            'function' => function ($entry) {
                return view('components.icon.requester', ['user' => $entry->requestedBy]);
            },
        ];
    ```
   
3. Register your repo in 'GlobalNotifications' model

    ```php
   class GlobalNotifications extends Model
    {
        ...
        public static $repo = [
            ...
            'your_module'   => YourModuleRepository::class,
        ];
   ```

### ℹ️ Excel Validation

Guide on managing Excel imports within your application using the Excelable trait. 

1. Use the `Excelable` trait in your Import Class:

    ```php
    class YourImportClass implements ... {
        use Excelable;
        ...
    }
    ```

2. Define necessary properties and mapping in your Import Class:

    ```php
    class YourImportClass implements ToCollection, WithStartRow, WithHeadingRow {
        use Excelable;
    
        protected $model;
        protected $request;
        protected $numericFields = ['field1', 'field2']; // Numeric fields
        protected $dateFields = ['field3', 'field4'];    // Date fields
    
        public function __construct($model, $request) {
            $this->model = $model;
            $this->request = $request;
        }
    
        // Define column mappings
        public function columMapping() {
            return [
                'excel_column_1' => 'db_column_1',
                'excel_column_2' => 'db_column_2',
                ...
            ];
        }
    }
    ```
   
3. Use it in your Controller or Repository for processing imports:

    ```php
    public function import(Request $request) {
        ...
        $import = new YourImportClass($this->model, $request);

        // Import the file
        Excel::import($import, $request->file);

        // Update stats (optional)
        $model = $import->getData();
        $model->total_records = $import->getTotalData();
        $model->save();

        // Handle failures
        if ($failures = $import->getFailures()) {
            return redirect()->back()->withErrors($failures);
        }          
    }
    ```

### ℹ️ Dynamic Menu 

Guide for rendering menus and submenus with permissions and optional notification indicators.

1. Include the `menu` component in `sidebar_content` view:

    ```php
    @include('components.menu', [
        'permission' => 'your-permission', 
        'menu' => 'Your Menu',     
        'useNotif' => true // optional if use notif badge        
        'submenu' => [                     
            ['url' => 'your-submenu-url', 'label' => 'Your Submenu', 'permission' => ['your-permission']],
            ...
        ]
    ])
    ```

### ℹ️ Import Bulky

Guide for using the import button & modal component. 

1. Include the button component with dynamic routes and fields:

    ```php
    @component('components.button.import-bulky', [
        'label' => 'Your field label', 
        'importRoute' => backpack_url('your-import-route'),
        'downloadRoute' => asset('your-file-path') // optional
        'title' => 'Your button label', // optional
        'modalTitle' => 'Your modal title', // optional
    ])
        // your additional form (optional)
        <div class="form-group">
            <label for="">Your Field</label>
            <input type="text" name="field_name" class="form-control">
        </div>
        ...
    @endcomponent
    ```

### ℹ️ Stats Card

Guide for implementing status cards using the stats component. 

1. Define your `Status` in your Enum : 

    ```php
    class YourEnum
    {
        ...    
        public const STATUS_A = 'StatusA';
        public const STATUS_B = 'StatusB';
    
        const STATUS_LIST = [
            self::STATUS_A,
            self::STATUS_B
        ];
    
        const STATUS_BADGE = [
            self::STATUS_A => 'bg-primary',
            self::STATUS_B => 'bg-secondary'
        ];
    
        const STATUS_ICONS = [
            self::STATUS_A => 'fa-ticket',
            self::STATUS_B => 'fa-pause-circle'
        ]; 
    ```

2. Use the `StatsConfig` trait in `YourEnum`:

    ```php
    class YourEnum {
        use StatsConfig;
        ...
    }
    ```
   
3. Set the `stats` route in your module in `custom.php`:

     ```php
     Route::get('stats' [YourController::class, 'getStats']);
     ```

4. Use the `Statsable` trait in `YourController`:

    ```php
    class YourController extends CrudController {
        use Statsable;
        ...
    }
    ```

5. Initialize an instance of `YourRepository` in `YourController`:

    ```php
    protected $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = new YourRepository();
    }
    ```

6. Implement the `stats` function by extending `BaseRepository` and implementing `BaseContract` in your Repository:

    ```php
    class YourRepository extends BaseRepository implements BaseContract {
        ...
    }
    ```

7. Override the `stats` method in your Repository

   ```php
   class YourRepository extends BaseRepository implements BaseContract {
        ...
       /**
        * @inheritDoc
        */
        public function stats($request): array
        {
            // prepare your data based on the request
            ... 
   
            return [
                'status_a' => $statusACount ?? 0,
                'status_b' => $statusBCount ?? 0,
            ];
        }
    }
    ```
   
8. Implement the Stats Cards in the View

    ```php
    @component('components.stats', [
        'stats'       => \App\Enums\YourEnum::getStatsConfig(),
        'useGradient' => false // optional (default: true)
    ]) @endcomponent 
    ```


### ℹ️ Status Badges

Guide on dynamically generating status labels and badges using the HasStatus trait. 

1. Use the `StatusBadge` trait in your Model:

    ```php
    class YourModel extends Model {
        use StatusBadge;
        ...
    }
    ```

2. Set properties in the `YourModel` model:

    ```php
    class YourModel extends Model {
        use StatusBadge;
        ...
        // Define the var for the status
        protected $statusField = 'request_status'; // optional (default: status)
        protected $statusText = EngStatus::STATUS_TEXT;
        protected $statusBadge = EngStatus::STATUS_BADGE;
    }
    ```

3. Access status properties in view page :

   ```php
    $model->status_label: // Returns the status label (e.g., Pending, Completed).
    $model->status_badge: // Returns the status badge HTML (e.g., <span class="badge bg-success">Completed</span>).
   ```

### ℹ️ Generate Number

Guide on implementing auto-generated document numbers. 

1.  Define module configurations in the `GlobalNumbering` model:

    ```php
    class GlobalNumbering extends Model {
        ...
        const module = [
            ...
            'your_module' => 'your_module'
        ];
    
        const for = [
            ...
            'your_module' => 'your_doc_number_field' 
        ];
    
        public static $forModel = [
            ...
            'your_module' => YourModel::class
        ];
    }
    ```

2. Add your module's configuration to the `GlobalNumberingSeeder` seeder file:

    ```php
    class GlobalNumberingSeeder extends Seeder {
        public function run() {
            $data = [
                ...
                [
                    'module'  => GlobalNumbering::module['your_module'],
                    'for'     => GlobalNumbering::for['your_module'],
                    'format'  => '[Y][m][iiiii]', // set your format
                    'prefix'  => 'RNT', // set your prefix
                    'clause'  => GlobalNumbering::DEFAULT, // opt: FORMAT, ALPHABET, RESET, ROMAN
                    'example' => 'RNT240100001', // set your example
                ],
            ];
        }
    }
    ```
   
3. Execute the seeder to populate the `GlobalNumbering` table with your module's configuration:

    ```bash
    php artisan db:seed --class=GlobalNumberingSeeder
    ```

4. Add your module-specific number generator to the `GenerateNumber` utility:

    ```php
    class GenerateNumber
    {
        ... 
        // REGISTER DOCUMENT NUMBER
        public static function generate($model, $number, $withKey, $withIncrement)
        {
            ...
            if ($model instanceof YourModel) {
                return self::yourModule($number, $withKey, $withIncrement);
            }
        }
    
        // SPECIFIC DOCUMENT FORMATS
        public static function yourModule($number = null, $withKey = null, $withIncrement = false)
        {
            return self::convert('your-module', '[Y][m][iiiii]', $number, $withKey, $withIncrement);
        }
    }
    ```
   
5. Include the `AutoDocNumber` trait in your model to enable document number generation:

    ```php
    class YourModel extends Model
    {
        use AutoDocNumber;
        ... 
        // Optionally, define the document number field (default: 'doc_no')
        protected $docNo = 'doc_number';
    }

6. Override the `boot()` method in your model and call `static::generateNumber()` with the module name:

    ```php
    class YourModel extends Model
    {
        ...
        public static function boot() {
            parent::boot();

            // generate doc number
            static::generateNumber('your-module');
        }
        ...
    }
   ```

## Contributing

Thank you for considering contributing to the AdminPack!

## License

AdminPack is an admin panel software licensed under MIT.
