<?php

//  方便的写入日志方法, 两点能写入多维数组
file_put_contents('./log.txt', var_export($arr, true), FILE_APPEND);


################ 加密解密函数 ####################
/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key 加密密钥
 * @param int $expire 过期时间 单位 秒
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_encrypt($data, $key = 'ctyes.com2018', $expire = 0)
{
    $key = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
    $data = base64_encode($data);
    $x = 0;
    $len = strlen($data);
    $l = strlen($key);
    $char = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    $str = sprintf('%010d', $expire ? $expire + time() : 0);

    for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1))) % 256);
    }
    return str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($str));
}

/**
 * 系统解密方法
 * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param  string $key 加密密钥
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_decrypt($data, $key = 'ctyes.com2018')
{
    $key = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
    $data = str_replace(array('-', '_'), array('+', '/'), $data);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    $data = base64_decode($data);
    $expire = substr($data, 0, 10);
    $data = substr($data, 10);

    if ($expire > 0 && $expire < time()) {
        return '';
    }
    $x = 0;
    $len = strlen($data);
    $l = strlen($key);
    $char = $str = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        } else {
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return base64_decode($str);
}

################ 加密解密函数 ####################

################ base64图片转化为图片并保存 ####################
function base64_to_iamge($base64_image_content, $path)
{
    //匹配出图片的格式
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
        $type = $result[2];
        $new_file = $path . "/" . date('Ymd', time()) . "/";
        if (!file_exists($new_file)) {
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($new_file, 0777, 1);
        }
        $new_file = $new_file . time() . ".{$type}";
        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
            return '/' . $new_file;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

###################将超大量数据转换为excel文件并下载
class Excel
{
    /**
     * @desc 数据导出到excel(csv文件)
     * @param string $filename 导出的csv文件名称 如date("Y年m月j日").'-test.csv'
     * @param array $tileArray 所有列名称的一维数组
     * @param array $dataArray 所有列数据的二维数组
     */
    public function exportToExcel($filename, $tileArray = [], $dataArray = [])
    {
//        ini_set('memory_limit','512M');
        ini_set('max_execution_time', 0);
        ob_end_clean();
        ob_start();
        header("Content-Type: text/csv");
        header("Content-Disposition:filename=" . $filename);
        $fp = fopen('php://output', 'w');
        fwrite($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));//转码 防止乱码(比如微信昵称(乱七八糟的))
        fputcsv($fp, $tileArray);
        $index = 0;
        foreach ($dataArray as $item) {
            if ($index == 1000) {
                $index = 0;
                ob_flush();
                flush();
            }
            $index++;
            fputcsv($fp, $item);
        }

        ob_flush();
        flush();
        ob_end_clean();
    }
}

################不用递归格式化字节为易读形式

function getSymbolByQuantity($bytes)
{
    $symbols = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
    $exp = $bytes ? floor(log($bytes) / log(1024)) : 0;

    return sprintf('%.2f ' . $symbols[$exp], ($bytes / pow(1024, floor($exp))));
}

function human_filesize($bytes, $decimals = 2)
{
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

################遍历目录, 转换为数组或格式为树形目录
//输出树形结构目录
$tree = new RecursiveTreeIterator(new RecursiveDirectoryIterator('D:\phpstudy2018\PHPTutorial\WWW\tp5.1'));
foreach ($tree as $item) {
    echo $item . "\n";
}

//输出所有的子目录,文件
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('D:\phpstudy2018\PHPTutorial\WWW\tp5.1'));
foreach ($tree as $item) {
    echo $item . "\n";
}
//还可以转化为数组
$array = iterator_to_array($iterator);

######获取客户ip#######

public static function getClientIp()
{
    //IP V4
    $ip = '';
    $unknown = 'unknown';
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) {
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $clientIp = trim(current($ipList));
        if (ip2long($clientIp) !== false) {
            $ip = $clientIp;
        }
    }
    if (!$ip && !empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) {
        $ip = trim($_SERVER['REMOTE_ADDR']);
    }

    return $ip;
}
