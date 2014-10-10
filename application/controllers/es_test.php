<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 14-10-10
 * Time: 上午11:57
 */

class Es_test extends CI_Controller
{
    function __construct()
    {

        parent::__construct();
        $this->load->library('es');
        echo "<pre>";
    }

    function get()
    {

        $p = array(
            'index' => 'my_product',
            //'id' => '1240',
            'type' =>'product',
            '_source' => false, //是否返回全部资源

            'fields' => array( // 返回字段
                'pro_name',
                'pro_editdate'
            )
        );
        echo "<pre>";
        var_dump($this->es->get_doc($p));
    }

    function getSource()
    {
        $p = array(
            'index' => 'my_product',
            'id' => '1241',
            'type' =>'product',
        );
        echo "<pre>";
        var_dump($this->es->get_doc_source($p));
    }
    function delete_doc()
    {
        $p = array(
            'index' => 'my_product',
            'id' => '1242',
            'type' =>'product',
        );
        var_dump($this->es->delete_doc($p));
    }
    function ping()
    {
        echo "<pre>";
        var_dump($this->es->ping());
    }
    function info()
    {
        echo "<pre>";
        var_dump($this->es->info());
    }

    public function create_index()
    {
        $p = array(
            'index' =>'aaa',
        );
        var_dump($this->es->create_index($p));
    }

    public function delete_index()
    {
        $p = array(
            'index' => ''
        );
        echo "<pre>";
        var_dump($this->es->delete_index($p));
    }

    public function get_index_settings()
    {
        $p = array(
            'index' => 'xx',
        );
        var_dump($this->es->get_index_settings($p));
    }

    function delete_by_query()
    {
        $p = array(
            'index' => 'my_product',
            'type' => 'product',
            'body'=>array(),
        );
        var_dump($this->es->delete_doc_by_query($p));
    }

    function get_count()
    {
        $p = array(
            'index' => 'my_product',
            'type' => 'product',
            //'body'=>array(),
        );
        var_dump($this->es->get_doc_count($p));
    }

    function mtermvectors()
    {
        $p = array(
            'index' => 'my_product',
            'type' => 'product',
            'ids' => array('1','2'),
            'body'=>array(
                'query' => array(
                    'match' => array(
                        'pro_name' => '苹果'
                    ),
                )
            ),
        );
        var_dump($this->es->client->mtermvectors($p));
    }

    function search1()
    {
        //Request Body
        $p['index'] = 'my_product';
        $p['type'] = 'product';
        $p['from'] = 0;
        $p['size'] = 10;
        $p['body']['query']['term']['pro_name'] = '京东';
        //$p['body']['query']['term']['pro_url'] = 'jd';
        $p['sort'] = array('pro_id' => array('order'=>'desc'));

        var_dump($this->es->search($p));
    }

    function search2()
    {
        //URI Request
        $p['index'] = 'my_product';
        $p['type'] = 'product';
//        $p['q']['pro_name'] = '京东 ';
//        //$p['q']['pro_url'] = 'jd ';
//        //$p['analyze_wildcard'] = true;
//        $p['from'] = 0;
//        $p['size'] = 10;
//        $p['default_operator'] = 'AND';
//        $p['explain'] = false;
        $p['fields'] = array('pro_name','pro_url','pro_id');
        //$p['sort']['pro_id']['order'] = 'desc';
        $p['sort'] = json_encode(array('pro_id' => array('order' => 'desc')));
        //$p['sort']['pro_id'] = array('order' => 'desc');


        //$p['search_type'] = 'query_and_fetch';
        print_r($this->es->search($p));
    }

    function search3()
    {
        $p['index'] = 'twitter';
        //$p['type'] = 'product';
        $p['body']['query']['term']['message'] = 'something';
        $p['body']['facets']['tag']['terms']['field'] = 'tag';
        $p['body']['filter']['term']['tag'] = 'green';
        var_dump($this->es->search($p));
    }

    function s4()
    {

        $p['index'] = 'my_product';
        $p['type'] = 'product';
        $p['body']['query']['term']['pro_name'] = '京东';
        $p['body']['highlight']['fields']['pro_name'] = '';
        //$p['fields'] = array('pro_name','pro_url','pro_id');
        print_r($this->es->search($p));

    }
}