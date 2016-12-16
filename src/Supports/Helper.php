<?php

namespace Alcon\Supports;

/**
 * 静态调用系列函数.
 *
 * @farwish
 */
class Helper
{
	/**
	 * 先后调用 array_column 与 array_combine .
	 *
	 * @farwish
	 */
	public static function array_column_combine($array, $column)
	{
		$res = array_column($array, $column); 

		return array_combine($res, $array);
	}

	/**
	 * date 封装默认格式.
	 *
	 * @farwish
	 */
	public static function format_date($time = '', $format = 'Y-m-d H:i:s')
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
    public static function join_condition($data, $column, $in = true)
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
	public static function custom_mt_uniqid($prefix = 'YK')
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
    public static function build_insert_sql($table, $column, array $data)
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
     * 使用的server_name.
     *
     * @farwish
     */
    public static function real_server()
    {
        $protocal = ($_SERVER['SERVER_PORT'] == '443') ? 'https://' : 'http://';

        if ( isset($_SERVER['HTTP_X_FORWARDED_SERVER']) ) {
            $host = $_SERVER['HTTP_X_FORWARDED_SERVER'];
        } else {
            $host = $_SERVER['SERVER_NAME'] ?: '';
        }

        return $protocal . $host;
    }

    /**
     * 当前页面完整Url.
     *
     * @farwish
     */
    public static function full_url()
    {
        $protocal = ($_SERVER['SERVER_PORT'] == '443') ? 'https://' : 'http://';

        if ( isset($_SERVER['HTTP_X_FORWARDED_SERVER']) ) {
            $host = $_SERVER['HTTP_X_FORWARDED_SERVER'];
        } else {
            $host = $_SERVER['SERVER_NAME'] ?: '';
        }

        $uri = $_SERVER['REQUEST_URI'] ?: '';

        return $protocal . $host . $uri;
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
        $protocal = ($_SERVER['SERVER_PORT'] == '443') ? 'https://' : 'http://';
        
        if ( isset($_SERVER['HTTP_REFERER']) ) {
            // 来路
            $direct = $_SERVER['HTTP_REFERER'];
        } else if ( isset($_SERVER['HTTP_X_FORWARDED_SERVER']) ) {
            // 代理地址
            $direct = $protocal . $_SERVER['HTTP_X_FORWARDED_SERVER'];
        } else {
            // 默认
            $direct = $protocal . $_SERVER['SERVER_NAME'];
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
    public static function gen_orderid($prefix = 'YK')
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

}
