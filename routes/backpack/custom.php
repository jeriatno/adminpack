<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

use App\Http\Controllers\Admin\Asset\AssetControllingController;
use App\Http\Controllers\Admin\Asset\AssetCrudController;
use App\Http\Controllers\Admin\Asset\AssetOutCrudController;
use App\Http\Controllers\Admin\Asset\ExtendCrudController;
use App\Http\Controllers\Admin\Asset\GoodsIssueCrudController;
use App\Http\Controllers\Admin\Asset\LoanCheckingCrudController;
use App\Http\Controllers\Admin\Asset\LoanSkipItemCrudController;
use App\Http\Controllers\Admin\Asset\PendingAssetCrudController;
use App\Http\Controllers\Admin\Asset\ReceiveAssetCrudController;
use App\Http\Controllers\Admin\Asset\RequestAssetOutCrudController;
use App\Http\Controllers\Admin\Asset\ReturnAssetCrudController;
use App\Http\Controllers\Admin\Asset\ReturnAssetPrincipalCrudController;
use App\Http\Controllers\Admin\Asset\SaleAssetCrudController;
use App\Http\Controllers\Admin\Asset\StockCardCrudController;
use App\Http\Controllers\Admin\ClaimThirdParty\AccountingCrudController;
use App\Http\Controllers\Admin\ClaimThirdParty\ClaimThirdPartyCrudController;
use App\Http\Controllers\Admin\ClaimThirdParty\DmLogisticCrudController;
use App\Http\Controllers\Admin\ClaimThirdParty\FinanceCrudController;
use App\Http\Controllers\Admin\ClaimThirdParty\LogisticCrudController;
use App\Http\Controllers\Admin\ClaimThirdParty\ManagerLogisticCrudController;
use App\Http\Controllers\Admin\ClaimThirdParty\ProductAdminCrudController;
use App\Http\Controllers\Admin\Engineering\EngineeringActivityCrudController;
use App\Http\Controllers\Admin\Engineering\EngineeringModuleCrudController;
use App\Http\Controllers\Admin\Engineering\EngineeringMyActivityCrudController;
use App\Http\Controllers\Admin\Engineering\EngineeringRequestCrudController;
use App\Http\Controllers\Admin\Engineering\EngineeringTeamsCrudController;
use App\Http\Controllers\Admin\Engineering\Report\EngineeringDailyActivityReportCrudController;
use App\Http\Controllers\Admin\Engineering\Report\EngineeringWeeklyGraphicReportCrudController;
use App\Http\Controllers\Admin\ForcastController3;
use App\Http\Controllers\Admin\ForwardOrder\ForwardOrderAgingReportCrudController;
use App\Http\Controllers\Admin\ForwardOrder\ForwardOrderCrudController;
use App\Http\Controllers\Admin\ForwardOrder\ForwardOrderEmailCrudController;
use App\Http\Controllers\Admin\ForwardOrder\ForwardOrderRoleCrudController;
use App\Http\Controllers\Admin\Huawei\HuaweiInvoiceCrudController;
use App\Http\Controllers\Admin\Huawei\HuaweiPartnumberCrudController;
use App\Http\Controllers\Admin\PartNumber\PartNumberApprovalItemCrudController;
use App\Http\Controllers\Admin\PartNumber\PartNumberCompleteCrudController;
use App\Http\Controllers\Admin\PartNumber\PartNumberCrudController;
use App\Http\Controllers\Admin\PartNumber\PartNumberRequestCrudController;
use App\Http\Controllers\Admin\Pipeline\DashboardPipelineCrudController;
use App\Http\Controllers\Admin\Pipeline\PipelineChannelHeaderCrudController;
use App\Http\Controllers\Admin\Pipeline\PipelineCrudController;
use App\Http\Controllers\Admin\PriceInquiry\PriceInquiryCommentCrudController;
use App\Http\Controllers\Admin\PriceInquiry\PriceInquiryCrudController;
use App\Http\Controllers\Admin\PriceInquiry\PriceInquiryHistoryCrudController;
use App\Http\Controllers\Admin\PriceInquiry\PriceInquiryItemCrudController;
use App\Http\Controllers\Admin\PriceInquiry\PriceInquiryReportCrudController;
use App\Http\Controllers\Admin\PrincipalClaim\PrincipalClaimCrudController;
use App\Http\Controllers\Admin\PrincipalClaim\PrincipalClaimRolesCrudController;
use App\Http\Controllers\Admin\RentStock\RentStockLogisticCrudController;
use App\Http\Controllers\Admin\RentStock\RentStockCardCrudController;
use App\Http\Controllers\Admin\RentStock\RentStockImportCrudController;
use App\Http\Controllers\Admin\RentStock\RentStockSPPBCrudController;
use App\Http\Controllers\Admin\StdQuotation\QuotationApprovalCrudController;
use App\Http\Controllers\Admin\StdQuotation\QuotationDashboardCrudController;
use App\Http\Controllers\Admin\StdQuotation\QuotationRequestCrudController;
use App\Http\Controllers\Admin\SolutionArchitect\BrandCategoriesCrudController;
use App\Http\Controllers\Admin\SolutionArchitect\SolutionMappingCrudController;
use App\Http\Controllers\Admin\SupportTicket\SupportAdminCrudController;
use App\Http\Controllers\Admin\SupportTicket\SupportTicketCrudController;
use App\Http\Controllers\Admin\SupportTicket\SupportTicketReportCrudController;

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    /*Welcome page*/
    CRUD::resource('welcome', 'WelcomeController');

    /*
    |--------------------------------------------------------------------------
    | Ensure this route is always placed at the very bottom of this file
    |--------------------------------------------------------------------------
    */
    Route::group([
        'prefix' => 'master-data',
    ], function () {
        CRUD::resource('forecast-product-office-toc', 'MForecastProductOfficeToCCrudController');
    });

    Route::group([
        'prefix' => 'settings',
    ], function () {
        CRUD::resource('holidays', 'HolidayCrudController');
    });

    Route::group([
        'prefix' => 'global-config',
        'as' => '.global-config',
    ], function () {
        CRUD::resource('number-format', 'GlobalNumberingCrudController');
        CRUD::resource('environment', 'GlobalEnvironmentCrudController');
    });
}); // this should be the absolute last line of this file
