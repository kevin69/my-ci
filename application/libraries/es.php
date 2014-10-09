<?php
/**
 * Created by PhpStorm.
 * User: smzdm
 * Date: 14-10-9
 * Time: 下午6:03
 */

require_once APPPATH . 'third_party/vendor/autoload.php';

class Es
{
    public $client = NULL;

    function __construct()
    {
        $ci = & get_instance();
        $ci->config->load('es');
        // 加载配置信息
        $es_params = $ci->config->item('es');
        $this->client = new Elasticsearch\Client($es_params);
    }

    public function ping()
    {
        return $this->client->ping();
    }

    public function info()
    {
        return $this->client->info();
    }

}