<?php

if(isset($_POST)) {

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function resizeImage($distWidth, $distHeight, $srcWidth, $scrHeight, $path, $type)
    {
        $from = call_user_func('imagecreatefrom'.$type, $path);
        $to = imagecreatetruecolor($distWidth, $distHeight);
        imagecopyresampled($to, $from, 0, 0, 0, 0, $distWidth, $distHeight, $srcWidth, $scrHeight);
        call_user_func('image'.$type, $to, $path);
    }

    $path = $_FILES['file']['tmp_name'];
    $type = $_FILES['file']['type'];
    $size = $_FILES['file']['size'];

    $tempArray = explode('/', $type);
    $type = end($tempArray);
    $size = getimagesize($path);

    resizeImage(300, 200, $size[0], $size[1], $path, $type);

    $type = $type === 'jpeg' ? 'jpg' : $type;
    $name = generateRandomString();
    $dist = $name.'.'.$type;

    move_uploaded_file($path, $dist);
}

