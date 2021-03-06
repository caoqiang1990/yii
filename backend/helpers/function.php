<?php


function getInfo()
{
    echo 'ddd';
}

/**
 * 可逆的字符串加密函数[无依赖简版]
 * @param int $txtStream 待加密的字符串内容
 * @param int $password 加密密码
 * @return string 加密后的字符串
 */
function enCrypt($txtStream, $password = 'ENCRYPT_KEY')
{
    //密锁串，不能出现重复字符，内有A-Z,a-z,0-9,/,=,+,_,
    $lockstream = 'st=lDEFABCNOPyzghi_jQRST-UwxkVWXYZabcdef+IJK6/7nopqr89LMmGH012345uv';
    //随机找一个数字，并从密锁串中找到一个密锁值
    $lockLen = strlen($lockstream);
    $lockCount = rand(0, $lockLen - 1);
    $randomLock = $lockstream[$lockCount];
    //结合随机密锁值生成MD5后的密码
    $password = md5($password . $randomLock);
    //开始对字符串加密
    $txtStream = base64_encode($txtStream);
    $tmpStream = '';
    $i = 0;
    $j = 0;
    $k = 0;
    for ($i = 0; $i < strlen($txtStream); $i++) {
        $k = ($k == strlen($password)) ? 0 : $k;
        $j = (strpos($lockstream, $txtStream[$i]) + $lockCount + ord($password[$k])) % ($lockLen);
        $tmpStream .= $lockstream[$j];
        $k++;
    }
    return $tmpStream . $randomLock;

}

/**
 * 可逆的字符串解密函数[无依赖简版]
 * @param int $txtStream 待加密的字符串内容
 * @param int $password 解密密码
 * @return string 解密后的字符串
 */
function deCrypt($txtStream, $password = 'ENCRYPT_KEY')
{
    //密锁串，不能出现重复字符，内有A-Z,a-z,0-9,/,=,+,_,
    $lockstream = 'st=lDEFABCNOPyzghi_jQRST-UwxkVWXYZabcdef+IJK6/7nopqr89LMmGH012345uv';

    $lockLen = strlen($lockstream);
    //获得字符串长度
    $txtLen = strlen($txtStream);
    //截取随机密锁值
    $randomLock = $txtStream[$txtLen - 1];
    //获得随机密码值的位置
    $lockCount = strpos($lockstream, $randomLock);
    //结合随机密锁值生成MD5后的密码
    $password = md5($password . $randomLock);
    //开始对字符串解密
    $txtStream = substr($txtStream, 0, $txtLen - 1);
    $tmpStream = '';
    $i = 0;
    $j = 0;
    $k = 0;
    for ($i = 0; $i < strlen($txtStream); $i++) {
        $k = ($k == strlen($password)) ? 0 : $k;
        $j = strpos($lockstream, $txtStream[$i]) - $lockCount - ord($password[$k]);
        while ($j < 0) {
            $j = $j + ($lockLen);
        }
        $tmpStream .= $lockstream[$j];
        $k++;
    }
    return base64_decode($tmpStream);
}

/**
 *
 * 根据类型获取对应的中文翻译
 *
 *
 **/
function getQuestionText($type = 1)
{
    $text = [1 => '单选', 2 => '多选'];
    return $text[$type];
}

/**
 *
 * 根据状态获取对应的中文翻译
 *
 **/
function getPitchStatusText($type = 10)
{
    $text = ['wait' => '新建比稿', 'auditor' => '发送邮件成功', '10' => '比稿结束'];
    return $text[$type];
}

/**
 * Name: truncate_utf8_string
 * User: aimer
 * Date: 2019/5/6
 * Time: 上午10:33
 * @param $string
 * @param $length
 * @param string $etc
 * @return string
 */
function truncate_utf8_string($string, $length, $etc = '...')
{
    $result = '';
    $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
    $strlen = strlen($string);
    for ($i = 0; (($i < $strlen) && ($length > 0)); $i++) {
        if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0')) {
            if ($length < 1.0) {
                break;
            }
            $result .= substr($string, $i, $number);
            $length -= 1.0;
            $i += $number - 1;
        } else {
            $result .= substr($string, $i, 1);
            $length -= 0.5;
        }
    }
    $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
    if ($i < $strlen) {
        $result .= $etc;
    }
    return $result;
}

?>