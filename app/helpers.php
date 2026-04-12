<?php 

use Illuminate\Support\Facades\Session;

function money($amount, $monedaCode = 'CRC', $decimal = 2)
{
    $symbol = $monedaCode == "CRC" ? '¢' : '$';
    return (!$symbol) ? number_format($amount, $decimal, '.', ',') : $symbol . number_format($amount, $decimal, '.', ',');
}
function number($amount)
{
    return preg_replace('/([^0-9\\.])/i', '', $amount);
}
function percent($amount, $symbol = '%')
{
    return number_format($amount, 0, '.', ',') .$symbol;
}
function roundM($num, $multiple = 1)
{
    return round($num, 2);//ceil($num / $multiple) * $multiple; //ceil(num/multiple)* multiple;//number_format($amount, 0, '.', ',') .$symbol;
}

function flash($message, $level = 'info')
{
    session()->flash('flash_message', $message);
    session()->flash('flash_message_level', $level);
}
function paginate($items, $perPage)
{
    $pageStart = \Request::get('page', 1);
    $offSet = ($pageStart * $perPage) - $perPage;
    $itemsForCurrentPage = array_slice($items, $offSet, $perPage, true);

    return new Illuminate\Pagination\LengthAwarePaginator(
        $itemsForCurrentPage,
        count($items),
        $perPage,
        Illuminate\Pagination\Paginator::resolveCurrentPage(),
        ['path' => Illuminate\Pagination\Paginator::resolveCurrentPath()]
    );
}

function set_active($path, $active = 'active')
{
    return Request::is($path) ? $active : '';
}

function dayName($day)
{
    $dayName = '';

    if (Carbon\Carbon::SUNDAY == $day) {                          // int(0)
        $dayName = 'Domingo';
    }

    if (Carbon\Carbon::MONDAY == $day) {                       // int(1)
        $dayName = 'Lunes';
    }

    if (Carbon\Carbon::TUESDAY == $day) {                         // int(2)
        $dayName = 'Martes';
    }

    if (Carbon\Carbon::WEDNESDAY == $day) {                       // int(3)
        $dayName = 'Miércoles';
    }

    if (Carbon\Carbon::THURSDAY == $day) {                       // int(4)
        $dayName = 'Jueves';
    }

    if (Carbon\Carbon::FRIDAY == $day) {                          // int(5)
        $dayName = 'Viernes';
    }

    if (Carbon\Carbon::SATURDAY == $day) {                        // int(6)
        $dayName = 'Sábado';
    }

    return $dayName;
}

function getAvatar($user)
{
    $url = '';

    if (Storage::disk('public')->exists('avatars/' . $user->id . '/avatar.jpg')) {
        $url = Storage::url('avatars/' . $user->id . '/avatar.jpg');
    } else {
        $url = '/img/default-avatar.jpg';
    }

    return $url;
}

function getPhoto($id)
{
    $url = '';

    if (Storage::disk('public')->exists('products/' . $id . '/photo.jpg')) {
        $url = Storage::url('products/' . $id . '/photo.jpg');
    } else {
        $url = '';
    }

    return $url;
}


function existsXML($xml = 'factura')
{
    $resp = false;


    if (Storage::disk('local')->exists('facturaelectronica/' . $xml . '.xml')) {
        $resp = true;
    }


    return $resp;
}

function existsFirmador($name = 'xadessignercrv2')
{
    $resp = false;


    if (Storage::disk('local')->exists('facturaelectronica/' . $name . '.jar')) {
        $resp = true;
    }


    return $resp;
}
function existsCertFile($config)
{
    $resp = false;

    $cert = 'cert';
    if ($config) {
        if (Storage::disk('local')->exists('facturaelectronica/' . $config->id . '/' . $cert . '.p12')) {
            $resp = true;
        }
    }

    return $resp;
}

function fillZeroLeftNumber($value, $lenght = 9)
{
    return str_pad($value, $lenght, '0', STR_PAD_LEFT);
}
function fillZeroRightNumber($value, $lenght = 2)
{
    return $value * 100;//$value. "00";
}

function getUniqueNumber($length = 9, $id = null)
{
    $d = date('d');
    $m = date('m');
    $y = date('Y');
    $t = time();
    $dmt = $d + $m + $y + $t;
    $ran = rand(0, 10000000);
    $dmtran = $dmt + $ran;
    if ($id) {
        $dmtran = $dmtran + $id;
    }
    //$un = uniqid();
    //$dmtun = $dmt . $un;
    //$mdun = md5($dmtran . $un);
    $sort = substr($dmtran, 0, $length);
    return $sort;
}

function is_blank($value)
{
    return empty($value) && !is_numeric($value);
}

function array_pluck($array, $key) {
    return array_map(function($v) use ($key) {
      return is_object($v) ? $v->$key : $v[$key];
    }, $array);
}