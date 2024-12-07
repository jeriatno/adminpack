<?php

use App\Models\Budgeting\OrgChartMapping;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

if (!function_exists('formatCurrency')) {
    /**
     * Get amount use currency format
     *
     * @param $price
     * @return string
     */
    function formatCurrency($price): string
    {
        return 'Rp '.number_format($price, 0, ',', '.');
    }
}

if (!function_exists('formatNumber')) {
    /**
     * Get number use IDR format
     *
     * @param $price
     * @return string
     */
    function formatNumber($price): string
    {
        return number_format($price, 0, ',', '.');
    }
}

if (!function_exists('parseDateRange')) {
    /**
     * Parse date range
     *
     * @param $dateRange
     * @return array|null
     */
    function parseDateRange($dateRange)
    {
        // Separate the start date and end date using '-' as a separator
        $dateParts = explode(' - ', $dateRange);

        if (count($dateParts) !== 2) {
            return null;
        }

        // Split the start date and end date into year, month, and day
        $start = date_parse_from_format('m/d/Y', $dateParts[0]);
        $end = date_parse_from_format('m/d/Y', $dateParts[1]);

        if ($start === false || $end === false) {
            return null;
        }

        $year = $start['year'];
        $month = $start['month'];
        $start_period = $year.'-'.$month.'-'.$start['day'];
        $end_period = $year.'-'.$month.'-'.$end['day'];

        return [
            'year'         => $year,
            'month'        => $month,
            'start_period' => $start_period,
            'end_period'   => $end_period,
        ];
    }
}

if (!function_exists('getMonthName')) {
    /**
     * Get month name with ID language
     *
     * @param $month
     * @param $locale
     * @return string
     */
    function getMonthName($month, $locale = 'id_ID')
    {
        $month = intval($month);

        if ($month < 1 || $month > 12) {
            return 'Invalid month';
        }

        $monthName = [
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $monthName[$month];
    }
}

if (!function_exists('pathLast')) {
    /**
     * Get last path on current url
     *
     * @return mixed|string
     */
    function pathLast()
    {
        $path = array_slice(explode('/', URL::current()), -1, 1);

        return $path[0];
    }
}

if (!function_exists('pathFirst')) {
    /**
     * Get first path on current url
     *
     * @param  string|null $link
     * @return string
     */
    function pathFirst(?string $link = null): string
    {
        $baseUrl = isset($link) ? parse_url($link, PHP_URL_PATH) : request()->root();
        $basePath = '/admin/';
        $startIndex = strpos($baseUrl, $basePath);

        if ($startIndex !== false) {
            $pathAfterAdmin = substr($baseUrl, $startIndex + strlen($basePath));
            return trim($pathAfterAdmin, '/');
        } else {
            return rtrim($baseUrl, '/');
        }
    }
}

if (!function_exists('pathReverse')) {
    /**
     * Get a specific path segment from the current URL by reversed index.
     * The index counts from the end of the URL path.
     *
     * @param  int  $index The reversed index (starting from 1 as the last segment)
     * @return string
     */
    function pathReverse(int $index): string
    {
        $path = explode('/', URL::current());
        $reversedPath = array_reverse($path);
        return $reversedPath[$index - 1] ?? '';
    }
}

if (!function_exists('formatDate')) {
    /**
     * Show date with Asia/Makassar format
     *
     * @param $date
     * @return Carbon
     */
    function formatDate($date)
    {
        return Carbon::parse($date)->timezone('Asia/Makassar');
    }
}

if (!function_exists('formatCounted')) {
    /**
     * Show counted number with IDR format
     *
     * @param $number
     * @return string
     */
    function formatCounted($number)
    {
        $words = [
            '', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh',
            'Sebelas', 'Dua Belas', 'Tiga Belas', 'Empat Belas', 'Lima Belas', 'Enam Belas', 'Tujuh Belas',
            'Delapan Belas', 'Sembilan Belas'
        ];

        if ($number < 20) {
            return $words[$number];
        } elseif ($number < 100) {
            return $words[floor($number / 10)].' Puluh '.formatCounted($number % 10, 'IDR');
        } elseif ($number < 200) {
            return 'Seratus '.formatCounted($number - 100, 'IDR');
        } elseif ($number < 1000) {
            return $words[floor($number / 100)].' Ratus '.formatCounted($number % 100, 'IDR');
        } elseif ($number < 2000) {
            return 'Seribu '.formatCounted($number - 1000, 'IDR');
        } elseif ($number < 1000000) {
            return formatCounted(floor($number / 1000)).' Ribu '.formatCounted($number % 1000, 'IDR');
        } elseif ($number < 1000000000) {
            return formatCounted(floor($number / 1000000)).' Juta '.formatCounted($number % 1000000, 'IDR');
        } elseif ($number < 1000000000000) {
            return formatCounted(floor($number / 1000000000)).' Milyar '.formatCounted($number % 1000000000, 'IDR');
        } else {
            return 'Data terlalu besar!';
        }
    }
}

if (!function_exists('formatUsdCounted')) {
    /**
     * Show counted number with USD format
     *
     * @param $number
     * @return string
     */
    function formatUsdCounted($number, $curr = null)
    {
        $words = [
            '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
            'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
        ];

        $tens = [
            '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'
        ];

        $currency = $curr ?? 'Dollars';

        $number = number_format($number, 2, '.', '');

        list($dollars, $cents) = explode('.', $number);

        $dollars = ltrim($dollars, '0');
        $cents = rtrim($cents, '0');

        $result = '';

        if ($dollars > 0) {
            $result .= formatUsdCountedNumber($dollars).' ';
        }

        if ($cents > 0) {
            $result .= ' and '.formatUsdCountedNumber($cents).' Cents';
        }

        return $result.' '.$currency;
    }
}

if (!function_exists('formatUsdCountedNumber')) {
    /**
     * Show counted number with USD format
     *
     * @param $number
     * @return string
     */
    function formatUsdCountedNumber($number)
    {
        $words = [
            '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
            'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
        ];

        $tens = [
            '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'
        ];

        $result = '';

        $number = (int) $number;

        if ($number < 20) {
            $result .= $words[$number];
        } elseif ($number < 100) {
            $result .= $tens[$number / 10].' '.$words[$number % 10];
        } elseif ($number < 1000) {
            $result .= $words[$number / 100].' Hundred '.formatUsdCountedNumber($number % 100);
        } elseif ($number < 1000000) {
            $result .= formatUsdCountedNumber(floor($number / 1000)).' Thousand '.formatUsdCountedNumber($number % 1000);
        } elseif ($number < 1000000000) {
            $result .= formatUsdCountedNumber(floor($number / 1000000)).' Million '.formatUsdCountedNumber($number % 1000000);
        } elseif ($number < 1000000000000) {
            $result .= formatUsdCountedNumber(floor($number / 1000000000)).' Billion '.formatUsdCountedNumber($number % 1000000000);
        } elseif ($number < 1000000000000000) {
            $result .= formatUsdCountedNumber(floor($number / 1000000000000)).' Trillion '.formatUsdCountedNumber($number % 1000000000000);
        } else {
            $result .= 'Data is too large!';
        }

        return $result;
    }
}

if (!function_exists('assets')) {
    /**
     * Show file from storage directory
     *
     * @param $path
     * @param $secure
     * @return mixed
     */
    function assets($path, $secure = null)
    {
        return app('url')->asset('storage/'.$path, $secure);
    }
}

if (!function_exists('getUserSuperiors')) {
    /**
     * Get all superiors (up to the top) of a user
     *
     * @param  int  $userId
     * @return \Illuminate\Support\Collection
     */
    function getUserSuperiors($userId, $depth = 2, $isArray = false)
    {
        $superiors = collect();
        $user = User::find($userId);

        while ($user && $user->parentUser && $depth > 0) {
            $superiors->push($user->parentUser);
            $user = $user->parentUser;
            $depth--;
        }

        if ($isArray) {
            return $superiors->pluck('email', 'id')->toArray();
        }

        return $superiors;
    }
}

if (!function_exists('getUserSuperiors2')) {
    /**
     * Get all superiors (up to the top) of a user
     *
     * @param  int  $userId
     * @return \Illuminate\Support\Collection
     */
    function getUserSuperiors2($userId, $depth = 2, $isArray = false)
    {
        $superiors = collect();
        $user = User::find($userId);
        $user = OrgChartMapping::where('email', $user->email)->first();

        while ($user && $user->parentUser && $depth > 0) {
            $superiors->push($user->parentUser);
            $user = $user->parentUser;
            $depth--;
        }

        if ($isArray) {
            return $superiors->pluck('email')->toArray();
        }

        return $superiors;
    }
}

if (!function_exists('getUserSubordinates')) {
    /**
     * Get all subordinates (down to the bottom) of a user
     *
     * @param  int  $userId
     * @param  int  $depth
     * @return \Illuminate\Support\Collection
     */
    function getUserSubordinates($userId, $depth = 2, $isArray = false)
    {
        $subordinates = collect();
        $user = User::find($userId);

        if ($user) {
            $subordinates = $user->subordinates;

            // If depth is greater than 1, recursively get subordinates of subordinates
            if ($depth > 1) {
                foreach ($subordinates as $subordinate) {
                    $subordinates = $subordinates->merge(getUserSubordinates($subordinate->id, $depth - 1));
                }
            }
        }

        if ($isArray) {
            return $subordinates->pluck('id')->toArray();
        }

        return $subordinates;
    }
}

if (!function_exists('getUserSubordinates2')) {
    /**
     * Get all subordinates (down to the bottom) of a user
     *
     * @param  int  $userId
     * @param  int  $depth
     * @return \Illuminate\Support\Collection
     */
    function getUserSubordinates2($userId, $depth = 2, $isArray = false)
    {
        $subordinates = collect();
        $user = User::find($userId);
        $user = OrgChartMapping::where('email', $user->email)->first();

        if ($user) {
            // Find all users with the current user's email as their parent email
            $subordinates = OrgChartMapping::where('parent_email', $user->email)->get();

            // If depth is greater than 1, recursively get subordinates of subordinates
            if ($depth > 1) {
                foreach ($subordinates as $subordinate) {
                    $subordinates = $subordinates->merge(getUserSubordinates($subordinate->id, $depth - 1));
                }
            }
        }

        if ($isArray) {
            return $subordinates->pluck('id')->toArray();
        }

        return $subordinates;
    }
}

if (!function_exists('getParentUser')) {
    /**
     * Get the name of the parent user
     *
     * @param  int  $userId
     * @return \Illuminate\Support\Collection
     */
    function getParentUser($userId)
    {
        $user = User::find($userId);
        return $user->parentUser->name ?? null;
    }
}

if (!function_exists('ucword')) {
    /**
     * Custom ucwords
     */
    function ucword($input): string
    {
        $words = explode(' ', $input);
        $result = array_map(function ($word) {
            if (preg_match('/[A-Z]/', $word)) {
                return $word;
            }
            return ucwords($word);
        }, $words);

        return implode(' ', $result);
    }
}

if (!function_exists('alphabet')) {
    /**
     * Generate the alphabet
     */
    function alphabet()
    {
        return 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
}

if (!function_exists('roman')) {
    /**
     * Generate the roman
     */
    function roman()
    {
        return array('', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
    }
}

if (!function_exists('getYearFromAlphabet')) {
    /**
     * Generate year from alphabet
     */
    function getYearFromAlphabet($alphabet)
    {
        // Initialize the starting year
        $startYear = 2023;

        // Limit the allowed alphabet characters
        $alphabet = strtoupper($alphabet);
        $allowedAlphabets = alphabet();
        $alphabet = preg_replace("/[^$allowedAlphabets]/", "", $alphabet);

        // Calculate the difference between the given letter and the first letter 'A'
        $alphabetDifference = ord($alphabet) - ord('A');

        // Calculate the year by adding the difference to the starting year
        $resultYear = $startYear + $alphabetDifference;

        // Format the year into the desired string format
        $result = sprintf('%03d', $resultYear);

        // Return the result
        return $result;
    }
}

if (!function_exists('getAlphabetFromYear')) {
    /**
     * Generate alphabet from year
     */
    function getAlphabetFromYear($year)
    {
        // Initialize the starting year
        $startYear = 2023;

        // Calculate the difference between the given year and the starting year
        $yearDifference = (int) $year - $startYear;

        // Get the alphabet letter by adding the difference to the letter 'A'
        $resultAlphabet = chr(ord('A') + $yearDifference);

        // Return the result
        return $resultAlphabet;
    }
}

if (!function_exists('clearTable')) {
    /**
     * Truncate table
     *
     * @param $model
     *
     * @return void
     */
    function clearTable($modelOrTableName, $mode = 'truncate')
    {
        \DB::statement("SET FOREIGN_KEY_CHECKS=0;");

        if ($modelOrTableName instanceof \Illuminate\Database\Eloquent\Model) {
            $tableName = $modelOrTableName->getTable();

            if ($mode === 'delete') {
                $modelOrTableName->query()->delete();
            } else {
                $modelOrTableName->truncate();
            }
        } else {
            $tableName = $modelOrTableName;

            if ($mode === 'delete') {
                \DB::table($tableName)->delete();
            } else {
                \DB::table($tableName)->truncate();
            }
        }

        \DB::statement("SET FOREIGN_KEY_CHECKS=1;");
    }
}

if (!function_exists('prettyJson')) {
    /**
     * Pretty json format
     */
    function prettyJson($json, $ret = "\n", $ind = "\t")
    {
        if (!isset($json)) {
            return null;
        }

        $beauty_json = '';
        $quote_state = false;
        $level = 0;

        $json_length = strlen($json);

        for ($i = 0; $i < $json_length; $i++) {

            $pre = '';
            $suf = '';

            switch ($json[$i]) {
                case '"':
                    $quote_state = !$quote_state;
                    break;

                case '[':
                    $level++;
                    break;

                case ']':
                    $level--;
                    $pre = $ret;
                    $pre .= str_repeat($ind, $level);
                    break;

                case '{':

                    if ($i - 1 >= 0 && $json[$i - 1] != ',') {
                        $pre = $ret;
                        $pre .= str_repeat($ind, $level);
                    }

                    $level++;
                    $suf = $ret;
                    $suf .= str_repeat($ind, $level);
                    break;

                case ':':
                    $suf = ' ';
                    break;

                case ',':

                    if (!$quote_state) {
                        $suf = $ret;
                        $suf .= str_repeat($ind, $level);
                    }
                    break;

                case '}':
                    $level--;

                case ']':
                    $pre = $ret;
                    $pre .= str_repeat($ind, $level);
                    break;

            }

            $beauty_json .= $pre.$json[$i].$suf;

        }

        return $beauty_json;
    }
}

if (!function_exists('plainNumber')) {
    /**
     * Get number as plain text
     *
     * @param $price
     * @return string
     */
    function plainNumber($price): string
    {
        $price = (float) trim($price);
        return str_replace(',', '', $price);
    }
}

if (!function_exists('plainText')) {
    /**
     * Get text as plain text
     *
     * @param $text
     * @return string
     */
    function plainText($text): string
    {
        return ucwords(strtolower(str_replace('_', ' ', $text)));
    }
}

if (!function_exists('isEnv')) {
    /**
     * check environment
     * @return string
     */
    function isEnv()
    {
        $env = null;
        if (config('app.env') != 'production' && config('app.env') != 'local') {
            $env = '['.substr(strtoupper(config('app.env')), 0, 3).'] ';
        }

        return $env;
    }
}

if (!function_exists('isAdmin')) {
    /**
     * check is admin
     * @return string
     */
    function isAdmin()
    {
        return auth()->user()->hasRole('admin');
    }
}

if (!function_exists('HasAccess')) {
    /**
     * check is user auth
     */
    function HasAccess()
    {
        return auth()->user();
    }
}

if (!function_exists('getKeyPath')) {
    /**
     * Get the ID from the path in the current URL based on a given keyword
     *
     * @param  string  $keyword  The keyword to look for in the URL path
     * @return mixed|string|null The ID found after the keyword, or null if not found
     */
    function getKeyPath($keyword)
    {
        $path = explode('/', URL::current());

        // Find the index of the keyword in the path
        $keywordIndex = array_search($keyword, $path);

        // If the keyword is found and there's an ID after it
        if ($keywordIndex !== false && isset($path[$keywordIndex + 1])) {
            return $path[$keywordIndex + 1];
        }

        return null;
    }
}

if (!function_exists('formatWithStrike')) {
    function formatWithStrike($data, $field)
    {
        if ($data->$field) {
            return $data->status == -1 ? '<s>' . $data->$field . '</s>' : $data->$field;
        }
        return '-';
    }
}

if (!function_exists('formatSelectWithStrike')) {
    function formatSelectWithStrike($data, $field, $attribute)
    {
        if ($data->$field->isNotEmpty()) {
            return $data->status == -1 ? '<s>' . $data->$field[0]->$attribute . '</s>' : $data->$field[0]->$attribute;
        }
        return '-';
    }
}


if (!function_exists('parseXML')) {
    /**
     * parse xml
     */
    function parseXML($string)
    {
        $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", '$1$2$3', $string);

        $xmlObject = new \SimpleXMLElement($response);

        $body = $xmlObject->xpath('//executedResult')[0] ?? [];

        $array = json_decode(json_encode((array)$body), true);

        return $array;
    }
}

if (!function_exists('toFloatNumbering')) {
    function toFloatNumbering($value)
    {
        $value = str_replace('.', '', $value);
        return (float) $value;
    }
}

if (!function_exists('convertToTimeFormat')) {
    function convertToTimeFormat($minutes) {
        $seconds = $minutes * 60;

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        return sprintf("%02dh : %02dm", $hours, $minutes);
    }
}

if (!function_exists('price_format')) {
    function price_format($number, $decimalPlaces = 2): string
    {
        return $number == intval($number)
            ? number_format($number, 0)
            : number_format($number, $decimalPlaces);
    }
}

if (!function_exists('year')) {
    function year($data = null, $format = null): string
    {
        return Carbon::parse($data ?? now())->format($format ?? 'Y');
    }
}





