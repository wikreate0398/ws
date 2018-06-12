<?php

if (!function_exists('key_to_id')) {
    function key_to_id($array) {
        if (empty($array)) {
            return array();
        }
        $new_arr = array();
        foreach ($array as $id => &$node) {
            $new_arr[$node['id']] =& $node;
        }
        return $new_arr;
    }
}

if (!function_exists('map_tree')) {
    function map_tree($dataset)
    {
        $dataset = key_to_id($dataset);
        $tree    = array();
        foreach ($dataset as $id => &$node) {
            if (empty($node['parent_id'])) {
                $tree[$id] =& $node;
            } else {
                $dataset[$node['parent_id']]['childs'][$id] =& $node;
            }
        }
        return $tree;
    }
}


function format_by_count($count, $form1, $form2, $form3)
{
    $count = abs($count) % 100;
    $lcount = $count % 10;
    if ($count >= 11 && $count <= 19) return($form3);
    if ($lcount >= 2 && $lcount <= 4) return($form2);
    if ($lcount == 1) return($form1);
    return $form3;
}

function dayCase($ndata)
{  
    return format_by_count($ndata, 'день', 'дня', 'дней');
}

function monthCase($month)
{
    if ($month == 1) {
        return 'месяц';
    } elseif ($month <= 4) {
        return 'месяца';
    } else{
        return 'месяцев';
    }
}

function lectionCase($lection)
{
    if( $lection == '1'){  
        return "лекция"; 
    } elseif( substr($lection, -1) == '2'){  
        return "лекции";  
    } elseif( substr($lection, -1) == '3'){  
        return "лекции";  
    } elseif( substr($lection, -1) == '4'){  
        return "лекции";  
    } else {  
        return "лекций";  
    } 
}

function dateDiff($date1, $date2)
{
    $d1 = new DateTime($date1);
    $d2 = new DateTime($date2); 
    return $d2->diff($d1);
} 
function dateToTimestamp($date)
{
    return strtotime($date . '00:00:00');
}

if (!function_exists('print_arr')) {
    function print_arr($array)
    {
        echo "<pre>" . print_r($array, true) . "</pre>";
    }
} 

function userRoute($route)
{
    $define = Auth::user()->userType->define;
    return $define . '_' . $route;
}

function sortValue($arr){
    if (empty($arr)) {
        return;
    }

    $data = array();
    foreach ($arr as $l_key => $l_value) {   
        $i=0;
        foreach ($l_value as $key => $value) {
            $data[$key][$l_key] = $arr[$l_key][$key];
            $i++;
        }
    } 

    return $data; 
}

function arrayNoEmpty($data)
{ 
    foreach ($data as $field => $value) 
    {
        if (!empty($value)) 
        {
            return true;
        }
    }
    return false;
}

function validateArray($data)
{
    foreach ($data as $row) {   

        if (empty($row['required']) && !empty($row['array']) or !empty($row['required'])) 
        { 
            foreach ($row['array'] as $key => $item) 
            {  
                foreach ($item as $field => $value) 
                { 
                    if (!in_array($field, $row['excepts']) && empty($value) && !empty($row['required'])) 
                    {  
                        return ['status' => false, 'field' => $row['fName'] . "[$field][]"];
                    } 
                }
            }
        }
    }
    return ['status' => true];
}

function ifNull($data=''){
    if (empty($data)) {
        return '';
    }
    return $data;
}
  
  
if (!function_exists('newthumbs')) {
    function newthumbs($photo = '', $dir = '', $width = 0, $height = 0, $version = 0, $zc = 0)
    {
        return '';
        //echo $dir; 
        if (empty($photo) or !file_exists($dir . '/' . $photo)) {
            $photo = "no-image.png";
            if (!file_exists($dir . "/no-image-no-image-no-image.png")) {
                copy(realpath('uploads') . "/no-image.png", $dir . "/" . $photo);
            }
        }
        if (!file_exists($dir . '/' . $photo)) {
            if (file_exists($dir . '/' . str_replace('.jpg', '.JPG', $photo))) {
                $photo = str_replace('.jpg', '.JPG', $photo);
            } elseif (file_exists($dir . '/' . str_replace(' .jpg', '.jpg', $photo))) {
                $photo = str_replace(' .jpg', '.jpg', $photo);
            } elseif (file_exists($dir . '/' . substr($photo, 1))) {
                $photo = substr($photo, 1);
            }
        }
        require_once(public_path('libs/phpthumb/phpthumb.class.php')); 
        // echo $dir;exit();
        $result = is_dir(realpath($dir) . '/thumbs');
        if ($result) {
            $prevdir = $dir . '/thumbs';
        } else {
            if (mkdir(realpath($dir) . '/thumbs')) {
                $prevdir = $dir . '/thumbs';
            } else {
                return realpath('uploads') . '/no-image.png';
            }
        }
        if (!empty($version)) {
            $result = is_dir(realpath($dir) . '/thumbs/version_' . $version);
            if ($result) {
                $prevdir = $dir . '/thumbs/version_' . $version;
            } else {
                if (mkdir(realpath($dir) . '/thumbs/version_' . $version)) {
                    $prevdir = $dir . '/thumbs/version_' . $version;
                } else {
                    return realpath('uploads') . '/no-image.png';
                }
            }
        }
        //$ext=end(explode('.',$photo));
        $ext    = pathinfo($photo, PATHINFO_EXTENSION);
        $timg   = realpath($dir) . '/' . $photo;
        $catimg = realpath($prevdir) . '/' . $photo;
        if (is_file($timg) && !is_file($catimg)) {
            $opath1   = realpath($dir) . '/';
            $opath2   = realpath($prevdir) . '/';
            $dest     = $opath2 . $photo;
            $source   = $opath1 . $photo;
            $phpThumb = new phpThumb();
            $phpThumb->setSourceFilename($source);
            if (!empty($width))
                $phpThumb->setParameter('w', $width);
            if (!empty($height))
                $phpThumb->setParameter('h', $height);
            if ($ext == 'png')
                $phpThumb->setParameter('f', 'png');
            if (!empty($zc)) {
                $phpThumb->setParameter('zc', '1');
            }
            $phpThumb->setParameter('q', 100);
            if ($phpThumb->GenerateThumbnail()) {
                if ($phpThumb->RenderToFile($dest)) {
                    $img = $prevdir . '/' . $photo;
                } else {
                    return realpath('uploads') . '/no-image.png';
                }
            }
        } elseif (is_file($catimg)) {
            $img = $prevdir . '/' . $photo;
        } else {
            return realpath('uploads') . '/no-image.png';
        }
        return $img;
    }
}

function noImg()
{
    return '/public/uploads/no-image.png';
}

function uri($segment)
{
    return request()->segment($segment);
}

function isActive($route, $domain='')
{   
    return (request()->url() == $route) ? true :  false;
}

function adminMenu()
{
    return [
        'menu' => [
            'name' => 'Разделы сайта', 
            'icon' => '<i class="fa fa-bars" aria-hidden="true"></i>',
            'link' => '/admin/menu/',
            'view' => true,
            'edit' => 'Редактировать' 
        ], 

        'location' => [
            'name' => 'Области', 
            'icon' => '<i class="fa fa-map" aria-hidden="true"></i>',
            'link' => '/admin/location/',
            'view' => true,
            'edit' => 'Города' 
        ],  

        'course' => [
            'name'   => 'Курсы', 
            'icon'   => '<i class="fa fa-graduation-cap" aria-hidden="true"></i>',
            'link'   => '/admin/course/',
            'view'   => true,
            'edit'   => 'Редактировать',
            'childs' => [
                'category' => [
                    'name' => 'Категории', 
                    'icon' => '<i class="fa fa-book" aria-hidden="true"></i>',
                    'link' => '/admin/course/category/',
                    'view' => true,
                    'edit' => 'Редактировать' 
                ],

                // 'teacher-course' => [
                //     'name' => 'Категории', 
                //     'icon' => '<i class="fa fa-book" aria-hidden="true"></i>',
                //     'link' => '/admin/course/teacher-course/',
                //     'view' => true,
                //     'edit' => 'Редактировать' 
                // ] 
            ]
        ], 

        'user-profile' => [
            'name'   => 'Профиль пользователей', 
            'icon'   => '<i class="fa fa-cogs" aria-hidden="true"></i>',
            'link'   => '/admin/user-profile/',
            'view'   => true,
            'edit'   => 'Редактировать'
        ],  
 
        'users' => [
            'name'   => 'Пользователи', 
            'icon'   => '<i class="fa fa-users" aria-hidden="true"></i>',
            'link'   => '/admin/users/',
            'view'   => true,
            'edit'   => 'Редактировать',
            'childs' => [
                'pupil' => [
                    'name' => 'Ученики', 
                    'icon' => '<i class="fa fa-book" aria-hidden="true"></i>',
                    'link' => '/admin/users/pupil/',
                    'view' => true,
                    'edit' => 'Редактировать' 
                ],

                'teachers' => [
                    'name' => 'Преподаватели', 
                    'icon' => '<i class="fa fa-book" aria-hidden="true"></i>',
                    'link' => '/admin/users/teachers/',
                    'view' => true,
                    'edit' => 'Редактировать' 
                ],

                'university' => [
                    'name' => 'Учебные заведения', 
                    'icon' => '<i class="fa fa-book" aria-hidden="true"></i>',
                    'link' => '/admin/users/university/',
                    'view' => true,
                    'edit' => 'Редактировать' 
                ],
            ]
        ], 

        // 'constants' => [
        //     'name' => 'Константы', 
        //     'icon' => '<i class="fa fa-anchor" aria-hidden="true"></i>',
        //     'link' => '/admin/constants/',
        //     'view' => true,
        //     'edit' => 'Редактировать' 
        // ],

        'settings' => [
            'name' => 'Настройки', 
            'icon' => '<i class="fa fa-sliders" aria-hidden="true"></i>',
            'link' => '/admin/settings/',
            'view' => false,
            'edit' => 'Редактировать' 
        ],

        // Скрытые страницы

        'profile' => [
            'name' => 'Разделы сайта',  
            'link' => '/admin/profile/',
            'view' => false,
            'edit' => 'Редактировать' 
        ], 
    ]; 
}

function priceString($price){ 
    if (empty($price)) return '0.00'; 
    return number_format($price, 0, '.', ' ');
}

function toFloat($s) {
    // convert "," to "."
    $s = str_replace(',', '.', $s);

    // remove everything except numbers and dot "."
    $s = preg_replace("/[^0-9\.]/", "", $s);

    // remove all seperators from first part and keep the end
   // $s = str_replace('.', '',substr($s, 0, -3)) . substr($s, -3);

    // return float
    return (float) $s;
}  

function uploadBase64($base64, $path){
    $data = $base64;
    $data = str_replace('data:image/png;base64,', '', $data);
    $data = str_replace(' ', '+', $data);
    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));    
    file_put_contents($path, $data); 
}

function imageThumb($image, $path, $width, $height, $v)
{
    $path = str_replace('.', '/', $path); 

    $thumbPath = '/thumb';
    if (!is_dir(public_path($path . "/thumb"))) 
    {  
        mkdir(public_path($path . "/thumb"), 0777);
        chmod(public_path($path . "/thumb"), 0777);
    }

    if (!empty($v)) 
    {
        if (!is_dir(public_path($path . "/thumb/version_$v"))) 
        { 
            mkdir(public_path($path . "/thumb/version_$v"), 0777);
            chmod(public_path($path . "/thumb/version_$v"), 0777);
        }
        $thumbPath .= "/version_$v";
    }
    
    $imgeThumbnailPath = public_path($path . $thumbPath . "/$image");
    $filePath          = public_path($path . "/$image");

    if (!file_exists($imgeThumbnailPath) && file_exists($filePath)) 
    {   
        $img = Image::make($filePath)->fit($width, $height, function ($constraint) {
            $constraint->upsize();
        });
        $img->save($imgeThumbnailPath);
    }  

    if (!file_exists($imgeThumbnailPath) or empty($image)) 
    {
        return "http://via.placeholder.com/{$width}x{$height}/00d2ff/ffffff";
    }

    return env('APP_URL') . '/' . $path . $thumbPath . "/$image"; 
}

function setScript($js_folder, $path){
    if (strpos($path, 'full:') !== false) {
        $path = str_replace('full:', '', $path); 
    }else{
        $path = $js_folder.$path.'?v='.time();
    }
    return "<script src='{$path}'></script>";
}

function getUserYears($birthDate)
{
    $d1 = new DateTime(date('Y-m-d'));
    $d2 = new DateTime($birthDate); 
    $diff = $d2->diff($d1);  
    return $diff->y;
}