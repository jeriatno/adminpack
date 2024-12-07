<?php

namespace App\Utils;

use App\Models\ClaimThirdParty\ClaimThirdParty;
use App\Models\Engineering\EngineeringRequest;
use App\Models\GlobalNumbering;
use App\Models\Pipeline\PipelineHeader;
use App\Models\PriceInquiry\PriceInquiry;
use App\Models\RentStock\RentStockSPPB;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GenerateNumber
{
    /*
    |--------------------------------------------------------------------------
    | DOCUMENT NUMBER CONVERSION
    |--------------------------------------------------------------------------
    */
    public static function convert($forType, $defaultFormat = null, $number = null, $withKey = null, $withIncrement = false, $withTrashed = null)
    {
        $for = GlobalNumbering::for[$forType];
        $module = GlobalNumbering::module[$forType];
        $model = new GlobalNumbering::$forModel[$forType];
        $date = Carbon::now();

        // get global numbering
        $data = GlobalNumbering::query()
            ->where('module', $module)
            ->where('for', $for)
            ->where('is_active', 1)
            ->first();

        // get format & prefix
        $format = $data->format ?? $defaultFormat;
        $prefix = $data->prefix ?? null;

        // get key
        if ($withKey == GlobalNumbering::ROMAN) {
            $yearKey = roman();
        } elseif ($withKey == GlobalNumbering::ALPHABET) {
            $yearKey = getAlphabetFromYear($date->format('Y'));
        } elseif ($withKey == GlobalNumbering::FORMAT) {
            $yearKey = $date->format('Y');
        } else {
            $yearKey = $date->format('y');
        }

        if ($withKey == GlobalNumbering::FORMAT) {
            $monthKey = $date->format('m');
        } else {
            $monthKey = $date->format('n');
        }

        // get sequence number
        if ($withKey == GlobalNumbering::RESET) {
            $year = $date->format('Y');
            $monthKey = $date->format('m');
            $dateFormat = $prefix.substr($year, 2).$monthKey;

            $splitFormat = preg_split('/(\[[^\]]+\])/', $format, -1, PREG_SPLIT_DELIM_CAPTURE);
            $splitFormat = array_filter($splitFormat, function($value) {
                return !empty($value);
            });

            $splitFormat = array_values($splitFormat);
            $countPadding = substr_count($splitFormat[2], 'i');

            $lastRecord = $model::where(DB::raw("LEFT($for, " . strlen($dateFormat) . ")"), $dateFormat)
                ->orderBy(DB::raw("RIGHT($for, $countPadding)"), 'desc')
                ->first();

            if ($lastRecord) {
                $lastSequence = (int)substr($lastRecord->$for, -$countPadding);
                $seqNumber = $lastSequence + 1;
            } else {
                $seqNumber = 1;
            }
        } else {
            if ($withIncrement) {
                $latestModel = $model->orderBy('id', 'desc')->first();

                if ($latestModel) {
                    $seqNumber = $latestModel->id + 1;
                } else {
                    $seqNumber = 1;
                }
            } else {
                if($number) {
                    $seqNumber = $number;
                } else {
                    if ($withTrashed) {
                        $seqNumber = $model->query()->withTrashed()->count('id') + 1;
                    } else {
                        $seqNumber = $model->query()->count('id') + 1;
                    }
                }
            }
        }

        return $prefix . str_replace(
                ['[d]', '[m]', '[Y]', '[iii]', '[iiii]', '[iiiii]', '[iiiiii]', '[iiiiiii]', '[iiiiiiii]'],
                [
                    $date->format('d'),
                    $monthKey ?? null,
                    $yearKey ?? null,
                    str_pad($seqNumber, 3, '0', STR_PAD_LEFT),
                    str_pad($seqNumber, 4, '0', STR_PAD_LEFT),
                    str_pad($seqNumber, 5, '0', STR_PAD_LEFT),
                    str_pad($seqNumber, 6, '0', STR_PAD_LEFT),
                    str_pad($seqNumber, 7, '0', STR_PAD_LEFT),
                    str_pad($seqNumber, 8, '0', STR_PAD_LEFT),
                ],
                $format
            );
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER DOCUMENT NUMBER
    |--------------------------------------------------------------------------
    */
    public static function get($class)
    {
        return GlobalNumbering::where('module', $class)->where('is_active', 1)->first();
    }

    public static function generate($model, $number, $withKey, $withIncrement)
    {
        if ($model instanceof RentStockSppb) {
            return self::rentStock($number, $withKey, $withIncrement);
        } else if ($model instanceof EngineeringRequest) {
            return self::engineering($number, $withKey, $withIncrement);
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | SPECIFIC DOCUMENT FORMATS
    |--------------------------------------------------------------------------
    */
    public static function principalClaim($number = null, $withKey = null, $withIncrement = false)
    {
        return self::convert('principal_claim', '[Y][m][iiiiii]', $number, $withKey, $withIncrement);
    }

    public static function forwardOrder($number = null, $withKey = null, $withIncrement = false)
    {
        return self::convert('forward_order', '[Y][m][iiiiii]', $number, $withKey, $withIncrement);
    }

    public static function claimThirdParty($number = null, $withKey = null, $withIncrement = false)
    {
        return self::convert(ClaimThirdParty::APP, '[Y][m][iiiiii]', $number, $withKey, $withIncrement);
    }

    public static function pipelineChannel($number = null, $withKey = null, $withIncrement = false)
    {
        return self::convert(PipelineHeader::APP, '[Y][m][iiii]', $number, $withKey, $withIncrement);
    }

    public static function huaweiInvoice($number = null, $withKey = null, $withIncrement = false)
    {
        return self::convert('huawei_invoice', '[Y][m][iiiiii]', $number, $withKey, $withIncrement);
    }

    public static function priceInquiry($number = null, $withKey = null, $withIncrement = false)
    {
        return self::convert(PriceInquiry::app, '[Y][m][iiii]', $number, $withKey, $withIncrement);
    }

    public static function rentStock($number = null, $withKey = null, $withIncrement = false)
    {
        return self::convert(RentStockSPPB::app, '[Y][m][iiiii]', $number, $withKey, $withIncrement);
    }

    public static function engineering($number = null, $withKey = null, $withIncrement = false)
    {
        return self::convert(EngineeringRequest::app, '[Y][m][iiii]', $number, $withKey, $withIncrement);
    }
}
