<?php

namespace Alcon\Thirdparty\Wechat;

/**
 * 微信基础操作类.
 *
 * @author farwish
 */
class Wx extends WxAbstract
{
    /**
     * 微信客户端的登陆授权url.
     *
     * 参数:
     * appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect
     *
     */
    const AUTHORIZE_URI = 'https://open.weixin.qq.com/connect/oauth2/authorize?';

    /**
     * code 换取网页授权 access_token.
     *
     */
    const SNS_TOKEN_URI = 'https://api.weixin.qq.com/sns/oauth2/access_token?';

    /**
     * 刷新access_token的url.
     *
     */
    const REFRESH_TOKEN_URI = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?';

    /**
     * access_token 和 openid 拉取用户信息的url.
     *
     */
    const USERINFO_URI = 'https://api.weixin.qq.com/sns/userinfo?';

    /**
     * 获取接口访问的 access_token.
     *
     */
    const ACCESS_TOKEN_URI = 'https://api.weixin.qq.com/cgi-bin/token?';

    /**
     * 获取JS-SDK使用权限 jsapi_ticket.
     *
     */
    const JSSDK_TICKET_URI = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?';

    /**
     * openid 获取用户基本信息url.
     *
     */
    const CGI_USERINFO_URI = 'https://api.weixin.qq.com/cgi-bin/user/info?';


    /**
     * 新增临时素材url
     */
    const CGI_MEDIA_GET_URI = 'https://api.weixin.qq.com/cgi-bin/media/get?';


    /**
     * 小程序jscode换取session_key
     */
    const JSCODE_TO_SESSION_URI = 'https://api.weixin.qq.com/sns/jscode2session?';


    /**
     * 发送模板消息接口
     */
    const TEMPLATE_SEND_URI = 'https://api.weixin.qq.com/cgi-bin/message/template/send?';


    /**
     * 请求带参数的二维码二维码
     */
    const CGI_QRCODE_CREATE_URI = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?';

    /**
     * 获取用户信息
     */
    const CGI_USER_GET_URI = 'https://api.weixin.qq.com/cgi-bin/user/get?';


    /**
     * 1. 生成客户端的完整授权url.
     *
     * 用户获取Code.
     *
     * @param $redirect_uri
     * 必须.
     * @param $scope
     * 可选. 默认snsapi_base , 另有 snsapi_userinfo.
     * @param $state
     * 可选. 默认没有.
     *
     * @return string
     *
     * <code>
     *  Wx::init([$config->wechat->appid, $config->wechat->secret]);
     *  $uri = Wx::connect_authorize_uri($full_url);
     * </code>
     */
    public static function connect_authorize_uri($redirect_uri,  $scope = 'snsapi_base', $state = '')
    {
        $param = [
            'appid' => static::$appid,
            'redirect_uri' => $redirect_uri,
            'response_type' => 'code',
            'scope' => $scope,
        ];

        if ($state) $param['state'] = $state;

        return self::AUTHORIZE_URI . http_build_query($param);
    }

    /**
     * 2. 由code获取access_token的完整url.
     *
     * 获取网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同.
     *
     * @param string $code
     * @return string
     *
     * @access protected
     *
     * <code>
     *  Wx::init([$appid, $secret]);
     *  $uri = Wx::sns_access_token_uri($code);
     * </code>
     *
     */
    protected static function sns_token_uri($code)
    {
        $param = [
            'appid' => static::$appid,
            'secret' => static::$secret,
            'code' => $code,
            'grant_type' => 'authorization_code',
        ];

        return self::SNS_TOKEN_URI . http_build_query($param);
    }

    /**
     * 3. 用refresh_token刷新access_token的完整url(如果需要).
     *
     * @access protected
     *
     */
    protected static function refresh_token_uri($refresh_token)
    {
        $param = [
            'appid' => static::$appid,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
        ];

        return self::REFRESH_TOKEN_URI . http_build_query($param);
    }

    /**
     * 4. 拉取用户信息的完整url.
     *
     * @param string $access_token
     * @param string $openid
     * @param string $lang
     *
     * @return string
     *
     * @access protected
     */
    protected static function userinfo_uri($access_token, $openid, $lang = 'zh_CN')
    {
        $param = [
            'access_token' => $access_token,
            'openid' => $openid,
            'lang' => $lang,
        ];

        return self::USERINFO_URI . http_build_query($param);
    }

    /**
     * 接口访问的 access_token.
     *
     * @access protected
     *
     */
    protected static function access_token_uri()
    {
        $param = [
            'grant_type' => 'client_credential',
            'appid' => static::$appid,
            'secret' => static::$secret,
        ];

        return self::ACCESS_TOKEN_URI . http_build_query($param);
    }

    /**
     * JS—SDK 使用权限的 jssdk_ticket.
     *
     * @param string $access_token
     *
     * @access protected
     */
    protected static function jssdk_ticket_uri($access_token)
    {
        $param = [
            'access_token' => $access_token,
            'type' => 'jsapi',
        ];

        return self::JSSDK_TICKET_URI . http_build_query($param);
    }

    /**
     * openid 获取用户信息的完整url.
     *
     * @access protected
     */
    protected static function cgi_userinfo_uri($access_token, $openid, $lang = 'zh_CN')
    {
        $param = [
            'access_token' => $access_token,
            'openid' => $openid,
            'lang' => $lang,
        ];

        return self::CGI_USERINFO_URI . http_build_query($param);
    }

    /**
     * @param $access_token
     *
     * @param $media_id
     *
     * @desc 获取临时文件下载的完整url.
     *
     * @return string
     */

    protected static function cgi_media_uri($access_token, $media_id)
    {
        $param = [
            'access_token' => $access_token,
            'media_id' => $media_id,
        ];

        return self::CGI_MEDIA_GET_URI . http_build_query($param);
    }

    /**
     * @param $appid
     *
     * @param $secret
     *
     * @param $js_code
     *
     * @desc  小程序jscode换取session_key的完整uri
     *
     * @author charlesyq
     * @return string
     */
    protected static function jscode_to_session_uri($appid, $secret,$js_code)
    {
        $param = [
            'appid' => $appid,
            'secret' => $secret,
            'js_code'=>$js_code,
            'grant_type' => 'authorization_code'
        ];

        return self::JSCODE_TO_SESSION_URI. http_build_query($param);
    }

    /**
     * @param $access_token
     *
     * @desc  发送模板消息
     *
     * @author charlesyq
     *
     * @return string
     */
    protected static function send_template_uri($access_token){
        $param = [
            'access_token' => $access_token,
        ];
        return self::TEMPLATE_SEND_URI.http_build_query($param);

    }


    /**
 * @param $access_token
 *
 * @desc  发送模板消息
 *
 * @author charlesyq
 *
 * @return string
 */
    protected static function cgi_qrcode_create_uri($access_token){
        $param = [
            'access_token' => $access_token,
        ];
        return self::CGI_QRCODE_CREATE_URI.http_build_query($param);

    }

    /**
     * @param $access_token
     * @param $next_openid
     *
     * @desc  获取用户信息
     *
     * @author charlesyq
     *
     * @return string
     */
    protected static function cgi_user_get_uri($access_token,$next_openid){
        $param = [
            'access_token' => $access_token,
            'next_openid'  =>$next_openid
        ];
        return self::CGI_USER_GET_URI.http_build_query($param);

    }

    /**
     * (网页授权access_token), 用它可以进行授权后接口调用, 如获取用户基本信息.
     *
     * 非基础支持中的“获取access_token”接口获取到的普通access_token.
     *
     * @param string $code
     *
     * @return array
     *
     * {
    "access_token":"ACCESS_TOKEN",
    "expires_in":7200,
    "refresh_token":"REFRESH_TOKEN",
    "openid":"OPENID",
    "scope":"SCOPE"
    }
     */
    public static function get_sns_token($code)
    {
        return static::parseJson( static::sns_token_uri($code) );
    }

    /**
     * 用 access_toke 和 openid 拉取用户信息.
     *
     * @param string $access_token
     * @param string $openid
     *
     * @return array
     *
    {
    "openid":" OPENID",
    " nickname": NICKNAME,
    "sex":"1",
    "province":"PROVINCE"
    "city":"CITY",
    "country":"COUNTRY",
    "headimgurl":    "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46",
    "privilege":[
    "PRIVILEGE1"
    "PRIVILEGE2"
    ],
    "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
    }
     */
    public static function get_userinfo($access_token, $openid)
    {
        return static::parseJson( static::userinfo_uri($access_token, $openid) );
    }

    /**
     * 获取接口访问的 access_token.
     *
     * Doc:
     * https://mp.weixin.qq.com/wiki/14/9f9c82c1af308e3b14ba9b973f99a8ba.html
     *
     *   {"access_token":"ACCESS_TOKEN","expires_in":7200}
     *   {"errcode":40013,"errmsg":"invalid appid"}
     */
    public static function access_token()
    {
        return static::parseJson( static::access_token_uri() );
    }

    /**
     * 获取 jssdk_ticket.
     *
     * @param string $access_token
     *
     * @return array
     *
     *  {
     *  "errcode":0,
     *  "errmsg":"ok",
     *  "ticket":"bxLdikRXVbTPdHSM05e5u5sUoXNKdvsdshFKA",
     *  "expires_in":7200
     *  }
     *
     * Doc:
     * http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
     */
    public static function jssdk_ticket($access_token)
    {
        return static::parseJson( static::jssdk_ticket_uri($access_token) );
    }

    /**
     * @param $access_token
     * @param $openid : 用户openid
     * @param $detail_url : 详情 url
     * @param $template_id
     * @param $data
     * @param string $topcolor :模板颜色
     *
     * @desc   发送模板消息
     *
     * Doc:
     * https://mp.weixin.qq.com/wiki/17/304c1885ea66dbedf7dc170d84999a9d.html
     *
     *
    {
    "errcode":0,
    "errmsg":"ok",
    "msgid":200228332
    }
     *
     * @author charlesyq
     * @return string
     */
    public static function  send_template($access_token,$detail_url,$openid, $template_id, $data, $topcolor = '#7B68EE'){
        /*
         * data=>array(
                'first'=>array('value'=>urlencode("您好,您已购买成功"),'color'=>"#743A3A"),
                'name'=>array('value'=>urlencode("商品信息:微时代电影票"),'color'=>'#EEEEEE'),
                'remark'=>array('value'=>urlencode('永久有效!密码为:1231313'),'color'=>'#FFFFFF'),
            )
         */

        $template = array(
            'touser' => $openid,
            'template_id' => $template_id,
            'url' => $detail_url,
            'topcolor' => $topcolor,
            'data' => $data
        );
        $json_template = json_encode($template);

        $url = static::send_template_uri($access_token);

        return static::parsePostJson($url, urldecode($json_template));

    }

    /**
     * @param $access_token
     * @param $scene_str
     * @desc  生成永久带参数二维码
     * @author charlesyq
     * @return bool|mixed
     */
    public static function qrcode_forever_create($access_token,$scene_str){
        $data = [
            "action_name" => "QR_LIMIT_STR_SCENE",
            "action_info" =>[
                "scene"=>[
                    "scene_str" =>$scene_str
                ]
            ]
        ];
        $json_data = json_encode($data);
        $url = static::cgi_qrcode_create_uri($access_token);

        return static::parsePostJson($url, urldecode($json_data));

    }



    /**
     * @param $access_token
     * @param $scene_str
     * @param $time
     * @desc  生成临时带参数二维码
     * @author charlesyq
     * @return bool|mixed
     */
    public static function qrcode_tmp_create($access_token,$scene_str,$time=2592000){
        $data = [
            "expire_seconds"=> $time,
            "action_name" => "QR_STR_SCENE",
            "action_info" =>[
                "scene"=>[
                    "scene_str" =>$scene_str
                ]
            ]
        ];
        $json_data = json_encode($data);
        $url = static::cgi_qrcode_create_uri($access_token);

        return static::parsePostJson($url, urldecode($json_data));

    }


    /**
     * @param $access_token
     *
     * @param $media_id
     *
     * @desc 获取上传到微信的文件
     *
     * @return array
     */
    public static function media_get($access_token, $media_id)
    {
        $url = static::cgi_media_uri($access_token, $media_id);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $package = curl_exec($ch);
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);
        $imageAll = array_merge(array('header' => $httpinfo), array('body' => $package));

        return $imageAll;

    }





    /**
     * 通过 openid 获取用户基本信息, 需要关注了公众号才能获取到个人信息.
     * (已登陆, 有 openid 的时候, 可以通过它获取用户信息.)
     *
     * 这里的 access_token 是调用各接口的 access_token,
     *  不是网页授权 access_token.
     *
     * Doc:
     * https://mp.weixin.qq.com/wiki/1/8a5ce6257f1d3b2afb20f83e72b72ce9.html
     *
     * {
        "subscribe": 1,
        "openid": "o6_bmjrPTlm6_2sgVt7hMZOPfL2M",
        "nickname": "Band",
        "sex": 1,
        "language": "zh_CN",
        "city": "广州",
        "province": "广东",
        "country": "中国",
        "headimgurl":    "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0",
        "subscribe_time": 1382694957,
        "unionid": " o6_bmasdasdsad6_2sgVt7hMZOPfL"
        "remark": "",
        "groupid": 0
     }
     *
     */
    public static function cgi_userinfo($access_token, $openid)
    {
        return static::parseJson( static::cgi_userinfo_uri($access_token, $openid) );
    }


    /**
     * @param $access_token
     * @param $next_openid
     * @desc
     * 批量获取用户信息接口
     * @author charlesyq
     * @return string
     */
    public static function cgi_user_get($access_token,$next_openid)
    {
        return static::parseJson( static::cgi_user_get_uri($access_token,$next_openid) );
    }



    /**
     * @param $appid
     * @param $secret
     * @param $js_code
     * @desc  小程序jscode换取session_key
     * @author charlesyq
     * @return mixed
     */
    public static function jscode_to_session($appid, $secret,$js_code){

        return static::parseJson( static::jscode_to_session_uri($appid, $secret,$js_code) );
    }





    /**
     * 方便查看代码 将相关模块放到一起
     */


    /**
     *  获取第三方平台component_access_token 的URL
     */

    const COMPONENT_TOKEN_URI = "https://api.weixin.qq.com/cgi-bin/component/api_component_token";


    /**
     * @param $component_appid
     * @param $component_appsecret
     * @param $component_verify_ticket
     *
     * @desc
     * 获取第三方平台component_access_token
     *
     * @author charlesyq
     * @return bool|mixed
     */
    public static function get_component_token($component_appid,$component_appsecret,$component_verify_ticket){

        $url= self::COMPONENT_TOKEN_URI;

        $data = [
            'component_appid'    => $component_appid,
            'component_appsecret'=> $component_appsecret,
            'component_verify_ticket' => $component_verify_ticket

        ];
        $json_data = json_encode($data);
        return static::parsePostJson($url, urldecode($json_data));
    }


    const COMPONENT_JSCODE_TO_SESSION_URI ='https://api.weixin.qq.com/sns/component/jscode2session?';
    /**
     * 小程序第三方平台登录
     *
     */


    /**
     * @param $appid
     *
     * @param $component_appid
     *
     * @param $component_access_token
     *
     * @param $js_code
     *
     * @desc  小程序jscode换取session_key的完整uri
     *
     * @author charlesyq
     * @return string
     */
    protected static function third_jscode_to_session_uri($appid,$component_appid, $component_access_token,$js_code)
    {
        $param = [
            'appid' => $appid,
            'js_code'=>$js_code,
            'grant_type' => 'authorization_code',
            'component_appid' => $component_appid,
            'component_access_token' =>$component_access_token
        ];

        return self::COMPONENT_JSCODE_TO_SESSION_URI. http_build_query($param);
    }

    /**
     * @param $appid
     * @param $component_appid
     * @param $component_access_token
     * @param $js_code
     * @desc  小程序jscode换取session_key
     * @author charlesyq
     * @return mixed
     */
    public static function third_jscode_to_session($appid, $component_appid,$component_access_token,$js_code){

        return static::parsePostJson( static::third_jscode_to_session_uri($appid,$component_appid, $component_access_token,$js_code) );
    }


    /**
     * 小程序获取token
     */
    const SP_TOKEN_URI = "https://api.weixin.qq.com/cgi-bin/token?";


    const SP_SEND_TEMPLATE_URI = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?";



    /**
     * @param $appid
     * @param $appsecret
     * @desc  小程序获取token的完整uri
     * @author charlesyq
     * @return string
     */
    protected static function sp_token_uri($appid,$appsecret)
    {
        $param = [
            'appid' => $appid,
            'secret'=>$appsecret,
            'grant_type' => 'client_credential',
        ];

        return self::SP_TOKEN_URI. http_build_query($param);
    }


    /**
     * 获取接口访问的 access_token.
     *
     * Doc:
     * https://mp.weixin.qq.com/wiki/14/9f9c82c1af308e3b14ba9b973f99a8ba.html
     *
     *   {"access_token":"ACCESS_TOKEN","expires_in":7200}
     *   {"errcode":40013,"errmsg":"invalid appid"}
     */
    public static function sp_access_token($appid,$appsecret)
    {
        return static::parseJson( static::sp_token_uri($appid,$appsecret) );
    }




    /**
     * @param $access_token
     *
     * @desc  小程序发送模板消息
     *
     * @author charlesyq
     *
     * @return string
     */
    protected static function sp_send_template_uri($access_token){
        $param = [
            'access_token' => $access_token,
        ];
        return self::SP_SEND_TEMPLATE_URI.http_build_query($param);

    }


    /**
     * @param $access_token
     * @param $openid
     * @param $template_id
     * @param $data
     * @param string $page
     * @param string $form_id
     *
     * @desc   发送模板消息
     *
     * Doc:
     * https://mp.weixin.qq.com/debug/wxadoc/dev/api/notice.html#接口说明
     *
     *
    {
    "errcode":0,
    "errmsg":"ok",
    "msgid":200228332
    }
     *
     * @author charlesyq
     * @return string
     */
    public static function  sp_send_template($access_token,$openid, $template_id, $data,$page='',$form_id='form_id'){
        /*
         * data=>array(
                'first'=>array('value'=>urlencode("您好,您已购买成功"),'color'=>"#743A3A"),
                'name'=>array('value'=>urlencode("商品信息:微时代电影票"),'color'=>'#EEEEEE'),
                'remark'=>array('value'=>urlencode('永久有效!密码为:1231313'),'color'=>'#FFFFFF'),
            )
         */

        $template = array(
            'touser' => $openid,
            'template_id' => $template_id,
            'page' => $page,
            'form_id' => $form_id,
            'data' => $data
        );
        $json_template = json_encode($template);

        $url = static::sp_send_template_uri($access_token);

        return static::parsePostJson($url, urldecode($json_template));

    }
}
