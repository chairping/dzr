<?php
/**
 * Created by PhpStorm.
 * User: cp
 * Date: 16/11/15
 * Time: 00:37
 */

namespace Common\Lib;


class Base64Image {

    public $dirname;
    public $base64Img;

    public function __construct($dirname, $base64Img) {
        $this->dirname = $dirname;
        $this->base64Img = $base64Img;
    }


    public function deal() {
        $webPath = dirname(realpath(APP_PATH));
        $imagePath = '/Public/upload/' . $this->dirname . DIRECTORY_SEPARATOR. date("Y-m-d") . DIRECTORY_SEPARATOR;
        $saleImagePath =  $webPath . $imagePath;

        if (!file_exists($saleImagePath)) {
            if(!mkdir($saleImagePath)) {
                throw new \LogicException("图片保存失败，{$saleImagePath}目录不可写");
            }
        }

        $type = 'jpg';

        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $this->base64Img, $result)){
            $type = $result[2];

            if ($type == 'jpeg') {
                $type = 'jpg';
            }

        }

        $fileName =  time() . '.' . $type;

        $finalFilePath = $saleImagePath. $fileName;

        $new_file = $finalFilePath;
        $base64_body = substr(strstr($this->base64Img,','),1);
        if (file_put_contents($new_file, base64_decode($base64_body))){
        } else{
        }

        return $imagePath . $fileName;

    }

}