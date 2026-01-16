<?php

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getIndexValue')) {
    function getIndexValue(string $text, $index = 0)
    {

        if (str_contains($text, '|')) {
            $value = convertPipeToArray($text);
        } else {
            $value = $text;
        }

        if (is_array($value)) {
            if (!isset($value[$index])) {
                return '';
            }

            return $value[$index];
        }

        if($index == 0) {
            return $value;
        }
    }
}


if (!function_exists('setting')) {
    function setting(string $parameter)
    {
        $Setting = Setting::whereParameter($parameter)->first('value');

        if(!$Setting) {
            return null;
        }

        return $Setting->value;
    }
}

if (!function_exists('switchColLang')) {
    function switchColLang(string $enCol, string $bnCol)
    {
        return app()->getLocale() == 'bn' ? $bnCol : $enCol;
    }
}

if (!function_exists('perPageRows')) {
    function perPageRows($Data = [])
    {
        if (count($Data) > 0) {
            return $Data;
        }

        return [10, 25, 50, 100, 250];
    }
}


if (!function_exists('addAllField')) {
    function addAllField($Data)
    {
        if (count($Data) > 0) {
            return [ null => 'All'] + $Data->toArray();
        }

        return [ null => 'All'];
    }
}


if (!function_exists('routeHome')) {
    function routeHome()
    {
        if (checkModule('Website')) {
            return route('website.home');
        }

        return route('user.dashboard');
    }
}

if (!function_exists('checkModule')) {
    function checkModule($moduleName)
    {
        if (Module::has($moduleName) && Module::isEnabled($moduleName)) {
            return true;
        }

        return false;
    }
}


if (!function_exists('ucan')) {
    function ucan($permission)
    {
        if(empty($permission)) {
            return true;
        }

        if (is_string($permission)) {
            $permission = convertPipeToArray($permission);
        }

        return Auth::user()->canany($permission);
    }
}


if (!function_exists('ucanh')) {
    function ucanh($permission)
    {
        if (ucan($permission)) {
            return '';
        }
        return ' d-none';
    }
}

if (!function_exists('exprienceTime')) {
    function exprienceTime()
    {
        $start  = new Carbon('1983');

        return [
            'started' => $start->format('Y'),
            'exp'   => $start->diffInYears(now())
        ];
    }
}

if (!function_exists('filterOption')) {
    function filterOption($configName, $placeholder = 'All')
    {
        return collect([['id' => null, 'name' => $placeholder]])->merge(config($configName))->pluck('name', 'id')->toArray();
    }
}

if (!function_exists('isApp')) {
    function isApp()
    {
        $userAgent = request()->server('HTTP_USER_AGENT');
        if ($userAgent == 'alliesbd-app') {
            return true;
        }

        return false;
    }
}

if (!function_exists('cartProductExists')) {
    function cartProductExists($productId, $sessionArray = null)
    {
        if (!$sessionArray) {
            $sessionArray = collect(session()->get('cart'))->toArray();
        }

        if (array_key_exists($productId, $sessionArray)) {
            return true;
        }

        return false;
    }
}

if (!function_exists('textShort')) {
    function textShort($text, $limit = 150, $sign = ' ...')
    {
        return Str::limit(strip_tags($text), $limit, $sign);
    }
}

if (!function_exists('pointFormat')) {
    function pointFormat($value, $sign = false, $decimal = false, $thousend = '')
    {
        $value = preg_replace('/[^0-9.-]/', '', $value);

        if (empty($value)) {
            $value = 0;
        }

        if (!$decimal) {
            $decimal = 2;
        }

        if ($sign) {
            if (!is_string($sign)) {
                $sign = config('app.point_sign');
            }

            return number_format((float) $value, $decimal) . ' ' . $sign;
        }

        return number_format((float) $value, $decimal, '.', $thousend);
    }
}

if (!function_exists('numberFormat')) {
    function numberFormat($value, $sign = false, $decimal = false, $thousend = '')
    {
        $value = preg_replace('/[^0-9.-]/', '', $value);

        if (empty($value)) {
            $value = 0;
        }

        if (!$decimal) {
            $decimal = 2;
        } elseif (is_string($decimal)) {
            $decimal = $decimal;
        }


        if ($sign) {
            if (!is_string($sign)) {
                $sign = currencySymbol();
            }

            return number_format((float) $value, $decimal) . ' ' . $sign;
        }

        return number_format((float) $value, $decimal, '.', $thousend);
    }
}

if (!function_exists('currencySymbol')) {
    function currencySymbol()
    {
        return '৳';
    }
}

if (!function_exists('asset_storage')) {
    function asset_storage($path)
    {
        return asset('storage/' . $path);
    }
}


if (!function_exists('asset_favicon')) {
    function asset_favicon($path = null)
    {
        return asset($path ? $path : config('app.logo'));
    }
}


if (!function_exists('asset_logo')) {
    function asset_logo($path = null)
    {
        return asset($path ? $path : config('app.logo'));
    }
}


if (!function_exists('asset_powered_logo')) {
    function asset_powered_logo($path = null)
    {
        return 'https://www.pounce.fi/wp-content/uploads/2021/06/pounce-trans.png';
        return asset($path ? $path : config('app.logo_powered'));
    }
}


if (!function_exists('asset_dark_logo')) {
    function asset_dark_logo($path = null)
    {
        return asset($path ? $path : config('app.dark_logo'));
    }
}


if (!function_exists('asset_profile_picture')) {
    function asset_profile_picture()
    {
        return asset('backend/images/users/avatar-1.jpg');
        // $User = Auth::user();
        // return asset($User ? $User : '');
    }
}



if (!function_exists('numberFormatConverted')) {
    function numberFormatConverted($value, $sign = false, $decimal = false, $thousend = '')
    {
        if (!$decimal) {
            $decimal = 2;
        }

        if ($sign) {
            return $sign . number_format((float) $value, $decimal);
        }

        return number_format((float) $value, $decimal, '.', $thousend);
    }
}

if (!function_exists('percentFormat')) {
    function percentFormat($value, $decimal = 2, $percentSign = '%')
    {
        $value = preg_replace('/[^0-9-.%]/', '', $value);

        if ($percentSign) {
            return round($value, $decimal) . $percentSign;
        }

        return round($value, $decimal);
    }
}

if (!function_exists('numberFormatOrPercent')) {
    function numberFormatOrPercent($value, $sign = false, $decimal = false, $thousend = '')
    {
        $value = preg_replace('/[^0-9-.%]/', '', $value);

        if (strpos($value, '%')) {
            return $value;
        }

        return numberFormat($value, $sign, $decimal, $thousend);
    }
}

if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 20)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('getPercentOfValue')) {
    function getPercentOfValue($percentage, $amount, $percenSign = true)
    {
        if ($percenSign) {
            return ($amount / 100) * str_replace('%', '', $percentage);
        }

        return ($amount / 100) * $percentage;
    }
}

if (!function_exists('getValueOfPercent')) {
    function getValueOfPercent($profit, $amount)
    {
        $profitAmount = $profit - $amount;

        if ($profitAmount !== 0) {
            $totalProfitMargin = ($profitAmount / $amount) * 100;
        } else {
            $totalProfitMargin = 0.00;
        }

        return $totalProfitMargin;
    }
}

if (!function_exists('getTimeFormat')) {
    function getTimeFormat($timeFormat = null)
    {
        if ($timeFormat == 1) {
            return 'F j, Y';
        } elseif ($timeFormat == 2) {
            return 'D F j, Y';
        } elseif ($timeFormat == 3) {
            return 'D F j, Y';
        } elseif ($timeFormat == 4) {
            return 'F j, Y';
        } elseif ($timeFormat == 5) {
            return 'D M j Y';
        } elseif ($timeFormat == 6) {
            return 'D M j Y';
        } elseif ($timeFormat == 7) {
            return 'j, n, Y';
        } elseif ($timeFormat == 8) {
            return 'j/n/Y';
        } elseif ($timeFormat == 9) {
            return 'j, n, Y';
        } elseif ($timeFormat == 10) {
            return 'j/n/Y';
        } elseif ($timeFormat == 11) {
            return 'd, m, Y';
        } elseif ($timeFormat == 12) {
            return 'd/m/Y';
        } elseif ($timeFormat == 13) {
            return 'd/m/Y';
        } elseif ($timeFormat == 14) {
            return 'd-m-Y';
        } elseif ($timeFormat == 15) {
            return 'd-m-Y';
        } elseif ($timeFormat == 16) {
            return 'd-m-y';
        } elseif ($timeFormat == 17) {
            return 'd-m-y';
        } else {
            return 'd-m-Y';
        }
    }
}

if (!function_exists('getTimeFormatJs')) {
    function getTimeFormatJs()
    {
        $getTimeFormat = getTimeFormat();

        $getTimeFormat = Str::replace('g', 'h', $getTimeFormat);
        $getTimeFormat = Str::replace('G', 'H', $getTimeFormat);
        $getTimeFormat = Str::replace('a', 'K', $getTimeFormat);
        $getTimeFormat = Str::replace('A', 'K', $getTimeFormat);

        return $getTimeFormat;
    }
}

if (!function_exists('getfirstAndLastName')) {
    function getfirstAndLastName($name, $callBack)
    {
        $splitName = explode(' ', $name, 2);

        if ($callBack == 'first') {
            return !empty($splitName[1]) ? $splitName[0] : '';
        } else {
            return !empty($splitName[1]) ? $splitName[1] : $splitName[0];
        }
    }
}

if (!function_exists('getFormatSize')) {
    function getFormatSize($bytes)
    {
        $kb = 1024;
        $mb = $kb * 1024;
        $gb = $mb * 1024;
        $tb = $gb * 1024;
        if (($bytes >= 0) && ($bytes < $kb)) {
            return $bytes . ' B';
        } elseif (($bytes >= $kb) && ($bytes < $mb)) {
            return ceil($bytes / $kb) . ' KB';
        } elseif (($bytes >= $mb) && ($bytes < $gb)) {
            return ceil($bytes / $mb) . ' MB';
        } elseif (($bytes >= $gb) && ($bytes < $tb)) {
            return ceil($bytes / $gb) . ' GB';
        } elseif ($bytes >= $tb) {
            return ceil($bytes / $tb) . ' TB';
        } else {
            return $bytes . ' B';
        }
    }
}

if (!function_exists('getFolderSize')) {
    function getFolderSize($dir)
    {
        $total_size = 0;
        $count = 0;
        $dir_array = scandir($dir);
        foreach ($dir_array as $key => $filename) {
            if ($filename != '..' && $filename != '.') {
                if (is_dir($dir . '/' . $filename)) {
                    $new_foldersize = foldersize($dir . '/' . $filename);
                    $total_size = $total_size + $new_foldersize;
                } elseif (is_file($dir . '/' . $filename)) {
                    $total_size = $total_size + filesize($dir . '/' . $filename);
                    ++$count;
                }
            }
        }

        return $total_size;
    }
}

if (!function_exists('checkDevice')) {
    function checkDevice()
    {
        $userAgent = request()->server('HTTP_USER_AGENT');

        $check = false;

        if ($userAgent == 'app-android') {
            $check = 1;
        } elseif ($userAgent == 'app-ios') {
            $check = 2;
        } elseif ($userAgent == 'app-windows') {
            $check = 3;
        }

        return $check;
    }
}
if (!function_exists('generateDepth')) {
    function generateDepth($depth, $sign = '-')
    {
        $prefix = '';
        for ($i = 0; $i < $depth; ++$i) {
            $prefix .= $sign;
        }

        return $prefix;
    }
}

if (!function_exists('convertPipeToArray')) {
    function convertPipeToArray(string $pipeString)
    {
        $pipeString = trim($pipeString);

        if (strlen($pipeString) <= 2) {
            return $pipeString;
        }

        $quoteCharacter = substr($pipeString, 0, 1);
        $endCharacter = substr($quoteCharacter, -1, 1);

        if ($quoteCharacter !== $endCharacter) {
            return explode('|', $pipeString);
        }

        if (!in_array($quoteCharacter, ["'", '"'])) {
            return explode('|', $pipeString);
        }

        return explode('|', trim($pipeString, $quoteCharacter));
    }
}
if (!function_exists('status_config')) {
    function status_config($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('config');
        }

        if (is_array($key)) {
            return app('config')->set($key);
        }

        return app('config')->get($key, $default);
    }
}
