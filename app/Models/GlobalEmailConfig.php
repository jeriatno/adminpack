<?php

    namespace App\Models;

    use App\Models\ClaimThirdParty\ClaimThirdParty;
    use Backpack\CRUD\CrudTrait;
    use Illuminate\Database\Eloquent\Model;

    class GlobalEmailConfig extends Model
    {
        use CrudTrait;

        /*
        |--------------------------------------------------------------------------
        | GLOBAL VARIABLES
        |--------------------------------------------------------------------------
        */

        protected $table = 'global_email_configs';
        // protected $primaryKey = 'id';
        // public $timestamps = false;
        protected $guarded = ['id'];
        // protected $fillable = [];
        // protected $hidden = [];
        // protected $dates = [];

        public const GetRejectStatus = [
            ClaimThirdParty::REJECTED_LOGISTIC_MANAGER
        ];

        /*
        |--------------------------------------------------------------------------
        | CONST VARIABLES
        |--------------------------------------------------------------------------
        */
        public const module = [
            'po_booking'           => 'PO_BOOKING',
            'principal_claim'      => 'PRINCIPAL_CLAIM',
            'support_ticket_admin' => 'SUPPORT_TICKET_ADMIN',
            'support_ticket_user'  => 'SUPPORT_TICKET_USER',
            'claim_third_party'    => 'CLAIM_THIRD_PARTY'
        ];

        /*
        |--------------------------------------------------------------------------
        | FUNCTIONS
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | RELATIONS
        |--------------------------------------------------------------------------
        */

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
