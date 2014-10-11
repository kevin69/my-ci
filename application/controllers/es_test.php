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
        //$p['sort'] = array('pro_id' => array('order' => 'desc'));
        $p['body']['sort'] = array('pro_id' => array('order'=>'desc'));
        $p['body']['highlight']['fields']['pro_name'] = '';

        var_dump($this->es->search($p));
    }

    function search2()
    {
        //URI Request
        $p['index'] = 'my_product';
        $p['type'] = 'product';
        $p['q']['pro_name'] = '京东 ';
//        //$p['q']['pro_url'] = 'jd ';
//        //$p['analyze_wildcard'] = true;
//        $p['from'] = 0;
//        $p['size'] = 10;
//        $p['default_operator'] = 'AND';
//        $p['explain'] = false;
        $p['fields'] = array('pro_name','pro_url','pro_id');
        //$p['sort']['pro_id']['order'] = 'desc';
        $p['sort'] = array('pro_id' => array('order' => 'desc'));
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

        $p['index'] = 'lzl_product';
        $p['type'] = 'product';
        $p['body']['query']['term']['pro_name'] = 'iphone';
        $p['body']['highlight']['fields']['pro_name'] = '';
        //$p['fields'] = array('pro_name','pro_url','pro_id');
        print_r($this->es->search($p));

    }

    public function c1()
    {
       $p['index'] = 'lzl_product';
       $P['type'] = 'product';
        var_dump($this->es->create_index($p));
    }

    public function put_mappings()
    {
        $mappings = array(
            '_source' => array(
                'enabled' => true,
            ),
                '_all' => array(
                    'indexAnalyzer' => 'ik',
                    'searchAnalyzer' => 'ik',
                    'term_vector' => 'no',
                    'store' => false,
                ),
                'properties' => array(
                    'pro_id'    => array(
                        'type' => 'integer',
                    ),
                    'pro_name'  => array(
                        'type'           => 'string',
                        "store"          => "no",
                        "term_vector"    => "with_positions_offsets",
                        "indexAnalyzer"  => "ik",
                        "searchAnalyzer" => "ik",
                        "include_in_all" => "true",
                        "boost"          => 8
                    ),
                    'pro_url'   => array(
                        'type'     => 'string',
                        'analyzer' => 'standard',
                    ),
                    'pro_price' => array(
                        'type' => 'integer'
                    ),
                    'pro_state' => array(
                        'type' => 'integer'
                    ),
                    'pro_level' => array(
                        'type' => 'integer'
                    ),
                    'pro_pic' => array(
                        'type' => 'string',
                    ),
                    'pro_brand_id' => array(
                        'type' => 'integer'
                    ),
                    'pro_category_id' => array(
                        'type' => 'integer'
                    ),
                    'pro_editdate' => array(
                        'type' => 'date',
                    ),
                    'pro_editor' => array(
                        'type' => 'string',
                    ),
                )
        );
        $p['index'] = 'lzl_product';
        $p['type'] = 'product';
        $p['body']['product'] = $mappings;
        var_dump($this->es->put_index_mapping($p));
    }

    function into()
    {
        $db = $this->load->database('product_read',TRUE);
        $db->from('product_index');
        $db->limit(20000,10);
        $query = $db->get();
        foreach ($query->result_array() as $key => $val) {
            $p['index'] = 'lzl_product';
            $p['type'] = 'product';
            $p['id'] = $val['pro_id'];
            $p['body']['pro_brand_id'] = $val['pro_brand_id'];
            $p['body']['pro_category_id'] = $val['pro_category_id'];
            $p['body']['pro_editdate'] = time();
            $p['body']['pro_editor'] = $val['pro_editor'];
            $p['body']['pro_id'] = $val['pro_id'];
            $p['body']['pro_level'] = $val['pro_level'];
            $p['body']['pro_name'] = $val['pro_name'];
            $p['body']['pro_pic'] = $val['pro_pic'];
            $p['body']['pro_price'] = (int)$val['pro_price'];
            $p['body']['pro_state'] = $val['pro_state'];
            $p['body']['pro_url'] = $val['pro_url'];
            $ret = $this->es->index($p);
            if ($ret) {
                echo "success \n";
            } else {
                echo "error \n";
            }
        }
    }

    //高亮
    function gl()
    {
        $p['index'] = 'lzl_product';
        $p['type'] = 'product';
        $p['body']['query']['term']['pro_name'] = 'iphone';
        // 高亮
        $p['body']['highlight']['fields'] = array('pro_name'=>array('fragment_size'=>150));
        $p['body']['highlight']['pre_tags'] = array("<tag1>","<tag2>");
        $p['body']['highlight']['post_tags'] = array("</tag1>","</tag2>");

        // 排序
        $p['body']['sort']['pro_id']['order'] = 'desc';
        //选择显示字段
        $p['body']['fields'] = array('pro_name','pro_id');
        //explain
        $p['body']['explain'] = false;
        $p['body']['version'] = true;
        //$p['fields'] = array('pro_name','pro_url','pro_id');
        print_r($this->es->search($p));
    }

    function percolate()
    {
        $params['index'] = 'lzl_product';
        $params['type'] = 'product';
        $params['body']['prefer_local'] = false;
        $params['body']['query']['term']['pro_name'] = 'iphone';
        $params['body']['fields'] = array('pro_name','pro_id');
        print_r($this->es->percolate($params));

    }

}