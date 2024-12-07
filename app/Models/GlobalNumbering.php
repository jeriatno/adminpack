<?php

namespace App\Models;

use App\Models\ClaimThirdParty\ClaimThirdParty;
use App\Models\Engineering\EngineeringRequest;
use App\Models\ForwardOrder\ForwardOrder;
use App\Models\Pipeline\PipelineHeader;
use App\Models\Huawei\HuaweiInvoice;
use App\Models\PriceInquiry\PriceInquiry;
use App\Models\PrincipalClaim\PrincipalClaim;
use App\Models\RentStock\RentStockSPPB;
use App\Models\Traits\UsesUuid;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GlobalNumbering extends Model
{
    use CrudTrait, UsesUuid, SoftDeletes;

    public const DEFAULT  = 'default';
    public const FORMAT   = 'format';
    public const ALPHABET = 'alphabet';
    public const RESET    = 'reset';
    public const ROMAN    = 'roman';


    const module = [
        'principal_claim'   => 'PrincipalClaim',
        'forward_order'     => 'ForwardOrder',
        'claim_third_party' => 'ClaimThirdParty',
        'pipeline'          => 'PipelineHeader',
        'huawei_invoice'    => 'HuaweiInvoice',
        'price_inquiry'     => PriceInquiry::app,
        'rent_stock'        => 'rent_stock',
        'engineering'       => EngineeringRequest::app,
    ];

    const for    = [
        'principal_claim'   => 'doc_number',
        'forward_order'     => 'doc_no',
        'claim_third_party' => 'doc_no',
        'pipeline'          => 'pipeline_no',
        'huawei_invoice'    => 'po_number',
        'price_inquiry'     => 'doc_no',
        'rent_stock'        => 'doc_number',
        'engineering'       => 'doc_no',
    ];

    public static $forModel = [
        'principal_claim'   => PrincipalClaim::class,
        'forward_order'     => ForwardOrder::class,
        'claim_third_party' => ClaimThirdParty::class,
        'pipeline'          => PipelineHeader::class,
        'huawei_invoice'    => HuaweiInvoice::class,
        'price_inquiry'     => PriceInquiry::class,
        'rent_stock'        => RentStockSPPB::class,
        'engineering'       => EngineeringRequest::class,
    ];

    public $guarded = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];
}
