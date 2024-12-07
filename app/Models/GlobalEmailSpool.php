<?php

    namespace App\Models;

    use App\Models\ClaimThirdParty\ClaimThirdParty;
    use App\Models\Engineering\EngineeringRequest;
    use App\Models\ForwardOrder\ForwardOrder;
    use App\Models\ForwardOrder\ForwardOrderEmail;
    use App\Models\Pipeline\PipelineHeader;
    use App\Models\PriceInquiry\PriceInquiry;
    use App\Models\PrincipalClaim\PrincipalClaim;
    use App\Models\PrincipalClaim\PrincipalClaimEmail;
    use App\Models\SupportTicket\SupportTicket;
    use App\Repositories\ClaimThirdParty\ClaimThirdPartyRepository;
    use App\Repositories\Engineering\EngineeringRequestRepository;
    use App\Repositories\ForwardOrder\ForwardOrderRepository;
    use App\Repositories\Pipeline\PipelineHeaderRepository;
    use App\Repositories\PriceInquiry\PriceInquiryRepository;
    use App\Repositories\PrincipalClaim\PrincipalClaimRepository;
    use App\Repositories\SupportTicket\SupportTicketRepository;
    use App\User;
    use Backpack\CRUD\CrudTrait;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class GlobalEmailSpool extends Model
    {
        use CrudTrait;
        use SoftDeletes;

        /*
        |--------------------------------------------------------------------------
        | GLOBAL VARIABLES
        |--------------------------------------------------------------------------
        */

        public const app = 'email-spool';
        protected $table = 'global_email_spools';
        // protected $primaryKey = 'id';
        // public $timestamps = false;
        protected $guarded = ['id'];
        // protected $fillable = [];
        // protected $hidden = [];
        // protected $dates = [];

        /*
        |--------------------------------------------------------------------------
        | CONST VARIABLES
        |--------------------------------------------------------------------------
        */

        public const PENDING = 0;
        public const FAILED  = -1;
        public const SENT    = 1;

        public static $docType = [
            'po_booking'        => ForwardOrder::class,
            'principal_claim'   => PrincipalClaim::class,
            'support_ticket'    => SupportTicket::class,
            'claim_third_party' => ClaimThirdParty::class,
            'pipeline'          => PipelineHeader::class,
            'price_inquiry'     => PriceInquiry::class,
            'engineering'       => EngineeringRequest::class
        ];

        public static $emailConf = [
            'po_booking'           => ForwardOrderEmail::class,
            'principal_claim'      => PrincipalClaimEmail::class,
            'support_ticket'       => null,
            'claim_third_party'    => GlobalEmailConfig::class,
            'pipeline'             => null,
            'price_inquiry'        => GlobalEmailConfig::class,
            'engineering'          => GlobalEmailConfig::class
        ];

        public static $emailLog = [
            'po_booking'        => ForwardOrderRepository::class,
            'principal_claim'   => PrincipalClaimRepository::class,
            'support_ticket'    => SupportTicketRepository::class,
            'claim_third_party' => ClaimThirdPartyRepository::class,
            'pipeline'          => PipelineHeaderRepository::class,
            'price_inquiry'     => PriceInquiryRepository::class,
            'engineering'       => EngineeringRequestRepository::class
        ];

        public const module = [
            'po_booking'           => 'PO_BOOKING',
            'principal_claim'      => PrincipalClaim::app,
            'support_ticket'       => 'SUPPORT_TICKET',
            'claim_third_party'    => 'CLAIM_THIRD_PARTY',
            'pipeline'             => 'PIPELINE',
            'price_inquiry'        => PriceInquiry::app,
            'engineering'          => 'engineering'
        ];

        public const views = [
            'po_booking'           => 'forward-order.notify.notification',
            'principal_claim'      => 'principal-claim.notify.notification',
            'support_ticket'       => 'support.admin.email',
            'claim_third_party'    => 'claim-third-party.notify.notification',
            'pipeline'             => 'pipeline-channel-header.email',
            'price_inquiry'        => 'price-inquiry.email',
            'engineering'          => 'engineering.email'
        ];

        public const url = [
            'po_booking'           => 'forward-order',
            'principal_claim'      => 'principal-claim',
            'support_ticket'       => 'support-admin',
            'claim_third_party'    => 'claim-third-party',
            'pipeline'             => 'pipeline-channel-header',
            'price_inquiry'        => 'price-inquiry',
            'engineering'          => 'engineering/request'
        ];

        public static $docNumber = [
            'po_booking'           => 'doc_no',
            'principal_claim'      => 'doc_number',
            'support_ticket'       => 'id',
            'claim_third_party'    => 'doc_no',
            'pipeline'             => 'pipeline_no',
            'price_inquiry'        => 'doc_no',
            'engineering'          => 'doc_no'
        ];

        /*
        |--------------------------------------------------------------------------
        | FUNCTIONS
        |--------------------------------------------------------------------------
        */
        public static function getByModule($module)
        {
            return self::where('module_name', $module)
                ->get();
        }

        public static function findByModule($module, $docId)
        {
            return self::where('module_name', $module)
                ->where('doc_id', $docId)
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | RELATIONS
        |--------------------------------------------------------------------------
        */
        public function actionBy()
        {
            return $this->belongsTo(User::class, 'sender', 'email');
        }

        /*
        |--------------------------------------------------------------------------
        | SCOPES
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | ACCESORS
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | MUTATORS
        |--------------------------------------------------------------------------
        */
    }
