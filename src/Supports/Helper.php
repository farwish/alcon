<?php

namespace Alcon\Supports;

/**
 * 静态调用系列函数.
 *
 * @author farwish <farwish@foxmail.com>
 */
class Helper
{
    /**
     * 取得接口签名结果.
     *
     * @param $url 请求参数如 b=v1&a=v2
     * @param $key client与service通用私钥
     * @param $encode true签名/false校验
     *
     * @return string
     *
     * @farwish
     */
    public static function getSign($url, $key, $encode = true)
    {
        parse_str($url, $arr);

        if (! $encode) {
            unset($arr['sign']);
        }

        // 首字母排序
        ksort($arr, SORT_REGULAR);

        $str = http_build_query($arr);

        // 带上私钥
        $new_str = $str . '&' . $key;

        // 签名
        $sign = openssl_encrypt($new_str, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, substr($key, 0, 16));

        return md5($sign);
    }

    /**
     * 先后调用 array_column 与 array_combine .
     *
     * @farwish
     */
    public static function arrayColumnCombine($array, $column)
    {
        $res = array_column($array, $column); 

        return array_combine($res, $array);
    }

    /**
     * date 封装默认格式.
     *
     * @farwish
     */
    public static function formatDate($time = '', $format = 'Y-m-d H:i:s')
    {
        $time = $time ?: time();

        return date($format, $time);
    }

    /**
     * 简化IN条件拼接.
     *
     * @param string | array $data
     * @param string 
     * @param boolean in or not in, default is in.
     *
     * @farwish
     */
    public static function joinCondition($data, $column, $in = true)
    {
        $join = is_array($data) ? (join(',', $data) ?: -1) : ($data ?: -1);
        $kw = $in ? "IN" : "NOT IN";
        return "$column $kw(" . $join . ")";
    }

    /**
     * 唯一值生成规则.
     *
     * @farwish
     */
    public static function customMtUniqid($prefix = 'YK')
    {
        $value = mt_rand();

        $str = md5 ( uniqid($prefix, TRUE) . microtime() . $value . str_shuffle($value) );

        $new_str = '';

        for ($i = 0; $i < 10; $i++) {
            $rand[] = mt_rand(10, 31);
        }
        
        $rand = array_unique($rand);

        for ($i = 0; $i < 32; $i++) {

            if (in_array($i, $rand)) {
                $new_str .= strtoupper($str[$i]);
            } else {
                $new_str .= $str[$i];
            }
        }

        return date('mY') . $new_str;
    }

    /**
     * 批量insert语句.
     *
     * @param string $table
     * @param string $column Example: id,name
     * @param array $data
     *
     * @return string
     *
     * @farwish
     */
    public static function buildInsertSql($table, $column, array $data)
    {
        $sql = "INSERT INTO {$table} ({$column}) VALUES ";

        $value = '';

        foreach ($data as $val) {
            $value = ($value ? ',' : '') . '("' . join('","', $val) . '")';
            $sql .= $value;
        }

        return $sql;
    }

    /** 
     * 构造 AND 条件语句.
     *
     * @param array $array.
     *
     * @farwish
     */
    public static function buildAndCondition(array $array)
    {   
        $str = ''; 
        foreach ($array as $key => $val) {
            $kv = "{$key}='{$val}'";
            $str .= $str ? ' AND ' . $kv : $kv;
        }
        return $str;
    } 

    /**
     * 使用的server_name.
     *
     * @deprecated 目前作为 full_server_name() 的别名
     *
     * @farwish
     */
    public static function realServer()
    {
        return static::fullServerName();
    }

    /**
     * 含协议和端口的完整server_name.
     *
     * protocol 是通过判断 SERVER_PORT 确定，或者直接用REQUEST_SCHEME (http,https).
     *
     * @farwish
     */
    public static function fullServerName()
    {
        //$protocol = ($_SERVER['SERVER_PORT'] == '443') ? 'https://' : 'http://';
        $protocol = $_SERVER['REQUEST_SCHEME'] . '://';

        if ( isset($_SERVER['HTTP_X_FORWARDED_SERVER']) ) {
            $host = $_SERVER['HTTP_X_FORWARDED_SERVER'];
        } else {
            $host = $_SERVER['SERVER_NAME'] ?? '';
        }

        $port = ($_SERVER['SERVER_PORT'] == 80) ? '' : ":{$_SERVER['SERVER_PORT']}";

        return $protocol . $host . $port;
    }

    /**
     * 当前页面完整Url.
     *
     * @farwish
     */
    public static function fullUrl()
    {
        $full_server_name = static::fullServerName();

        $uri = $_SERVER['REQUEST_URI'] ?? '';

        return $full_server_name . $uri;
    }

    /**
     * 来路地址url, 没有到首页.
     *
     * @return string
     *
     * @farwish
     */
    public static function referer()
    {
        //$protocol = ($_SERVER['SERVER_PORT'] == '443') ? 'https://' : 'http://';
        $protocol = $_SERVER['REQUEST_SCHEME'] . '://';
        
        if ( isset($_SERVER['HTTP_REFERER']) ) {
            // 来路
            $direct = $_SERVER['HTTP_REFERER'];
        } else if ( isset($_SERVER['HTTP_X_FORWARDED_SERVER']) ) {
            // 代理地址
            $direct = $protocol . $_SERVER['HTTP_X_FORWARDED_SERVER'];
        } else {
            // 默认
            $direct = $protocol . $_SERVER['SERVER_NAME'];
        }

        return $direct;
    }

    /**
     * TOKEN 生成.
     *
     * @param $uid
     *
     * @return string
     *
     * @farwish
     */
    public static function gentoken($uid = '')
    {
        $str = microtime() . (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknow') . 
            $uid . '7200';

        $md5 = md5($str);

        $crypt = crypt($md5, 'CRYPT_SHA256');

        $md5 = md5($crypt);

        return substr(strrev($md5), 1);
    }

    /**
     * 是否微信客户端打开.
     *
     * @return bool
     *
     * @farwish
     */
    public static function isInWechat()
    {
        return isset( $_SERVER['HTTP_USER_AGENT'] )
            ? (bool)(stristr($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger'))
            : false;
    }

    /**
     * order_id 生成, 36+ 位数.
     *
     * @param string $prefix
     *
     * @return string
     *
     * @farwish
     */
    public static function genOrderid($prefix = 'YK')
    {
        $uniq = uniqid(TRUE);

        return $prefix . date('Ymd') . $uniq . str_shuffle($uniq);
    }

    /**
     * 新 order_id 生成，32位内.
     *
     * @param $salt integer
     *
     * @return string
     *
     * @farwish
     */
    public static function orderid($salt = '')
    {
        // 14 + 8 + 5 + 3 = 30
        return str_replace('.', '', microtime(true)) . 
            date('Ymd') .
            str_pad(substr($salt, 0, 3), 5, 0) . 
            mt_rand(100, 999);
    }

    /**
     * 红包金额生成.
     *
     * 默认 1 ~ 1.5
     *
     * @param int $min
     * @param int $max
     *
     * @return float.
     *
     * @farwish
     */
    public static function redbag($min = 1, $max = 1)
    {
        $yuan = ($min === $max) ? $min : mt_rand($min, $max);

        return $yuan + (mt_rand(0, 50) / 100);
    }

    /**
     * Mobile check.
     *
     * @param mixed
     *
     * @return boolean true验证通过
     *
     * @farwish
     */
    public static function isMobile($string)
    {
        if ( preg_match('/^1\d{10}$/', $string, $matches) ) {
            return true;
        }
        return false;
    }

    /**
     * Curl post.
     *
     * @param 
     * @param 
     * @param 
     * @param 
     *
     * @return string json
     *
     * @farwish
     */
    public static function sendPost($url, array $data, $client_ip = '')
    {
        $ch = curl_init();

        $params = http_build_query($data);

        $opt = [ 
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_RETURNTRANSFER => 1,
        ];

        if ($client_ip) {
            $opt[CURLOPT_HTTPHEADER] = [ 
                "CLIENT-IP: {$client_ip}", "X-FORWARDED-FOR: {$client_ip}"
            ];
        }

        curl_setopt_array($ch, $opt);

        $json = curl_exec($ch);

        return $json; 
    }

    /**
     * Send request and fetch page.
     *
     * @license Apache
     * @author farwish <farwish@foxmail.com>
     *
     * @param string $url
     * @param array  $options 
        [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content'=> http_build_query([
                    'username' => 'user',
                    'password' => 'user',
                ]),
                'max_redirects' => 0, # Ignore redirects.
                'ignore_errors' => 1, # Fetch the content even on failure status codes.
            ],
        ];
     * @see http://php.net/manual/en/context.http.php
     */
    public static function sendRequest($url, $options)
    {
        $context = stream_context_create($options);

        $result = file_get_contents($url, false, $context);

        return $result;
    }

    /**
     * Is Wap.
     *
     * @easychen
     */
    public static function isMobileRequest()
    {
        $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
     
        $mobile_browser = '0';
     
        if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
            $mobile_browser++;
     
        if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))
            $mobile_browser++;
     
        if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
            $mobile_browser++;
     
        if(isset($_SERVER['HTTP_PROFILE']))
            $mobile_browser++;
     
        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
        $mobile_agents = array(
                            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
                            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
                            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
                            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
                            'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
                            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
                            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
                            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
                            'wapr','webc','winw','winw','xda','xda-'
                            );
     
        if(in_array($mobile_ua, $mobile_agents))
            $mobile_browser++;
     
        if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
            $mobile_browser++;
     
        // Pre-final check to reset everything if the user is on Windows
        if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
            $mobile_browser=0;
     
        // But WP7 is also Windows, with a slightly different characteristic
        if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
            $mobile_browser++;
     
        if($mobile_browser>0)
            return true;
        else
            return false;
    }

    /**
     * 多任务处理
     *
     * @author farwish
     *
     * @param int $worker_num     worker数
     * @param array $groups       分组数据
     * @param callable $callback($current_group, $worker_no)  回调函数
     *
     * @return int
     * @throws \Exception
     */
    public static function multiProcess(int $worker_num, array $groups, callable $callback)
    {
        if (!extension_loaded('pcntl')) {
            throw new \Exception('Pcntl extension missed!');
        }
        if (!$worker_num) {
            throw new \Exception("Worker_num can't be zero!");
        }

        $pids = [];
        for ($i = 0; $i < $worker_num; $i++) {
            $pid = pcntl_fork();
            switch ($pid) {
                case -1:
                    throw new \Exception('Fork fail!');
                    break;
                case 0:
                    // child
                    call_user_func_array($callback, [ $groups[$i], $i+1 ]);
                    die;
                    break;
                default:
                    // parent: $pid > 0
                    $pids[$pid] = $pid;
                    break;
            }
        }

        $terminated_num = 0;
        // `man 2 wait` for more comment.
        foreach ($pids as $pid) {
            if ($pid) {
                $status = 0;
                // Wait for process to change state ( 3 situation ).
                // Perform a wait allows the system to release the resources associated with the child.
                $pid_terminated = pcntl_waitpid($pid, $status);
                if ($pid_terminated) {
                    $terminated_num++;
                }
            }
        }

        return $terminated_num;
    }

    /**
     * 通用检测转换字符编码
     *
     * @author farwish
     *
     * @param string $string
     * @param bool   $utf8_first 编码检测的顺序是将最大可能性放在前面
     *
     * @return string
     */
    public static function commonConvertEncode($string, $to_encoding = 'utf-8', $utf8_first = true)
    {
        $encoding_list = [
            "ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5',
        ];

        if (! $utf8_first) {
            $encoding_list = [
                "ASCII", "GB2312", "GBK", 'UTF-8', 'BIG5',
            ];
        }

        $from_encoding = mb_detect_encoding($string, $encoding_list);

        return mb_convert_encoding(trim($string), $to_encoding, $from_encoding);
    }
}
