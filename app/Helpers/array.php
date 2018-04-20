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
            if (!$node['parent_id']) {
                $tree[$id] =& $node;
            } else {
                $dataset[$node['parent_id']]['childs'][$id] =& $node;
            }
        }
        return $tree;
    }
}

if (!function_exists('print_arr')) {
    function print_arr($array)
    {
        echo "<pre>" . print_r($array, true) . "</pre>";
    }
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

function ifNull($data=''){
    if (empty($data)) {
        return '';
    }
    return $data;
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
                    if (!in_array($field, $row['excepts']) && empty($value)) 
                    {  
                        return ['status' => false, 'field' => $row['fName'] . "[$field][]"];
                    } 
                }
            }
        }
    }
    return ['status' => true];
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
                ] 
            ]
        ],  
 
        'users' => [
            'name'   => 'Пользователи', 
            'icon'   => '<i class="fa fa-users" aria-hidden="true"></i>',
            'link'   => '/admin/users/',
            'view'   => true,
            'edit'   => 'Редактировать',
            'childs' => [
                'disciple' => [
                    'name' => 'Ученики', 
                    'icon' => '<i class="fa fa-book" aria-hidden="true"></i>',
                    'link' => '/admin/users/disciple/',
                    'view' => true,
                    'edit' => 'Редактировать' 
                ],

                'teachers' => [
                    'name' => 'Учителя', 
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