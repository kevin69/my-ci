<?php
/**
 * Created by PhpStorm.
 * User: smzdm
 * Date: 14-9-24
 * Time: 上午11:07
 */

require_once APPPATH.'third_party/vendor/autoload.php';

class Demo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

    }

    public function test_create()
    {

        $serversParams = array(
            'servers' => array(
                array(
                    'host' => 'localhost',
                    'port' => 9200
                )
            ),
        );
        $client = new \Elastica\Client($serversParams);
        print_r($client);
        exit;


        $db = $this->load->database('product_read',TRUE);
        $db->from('product_index');
        $db->limit(2000,0);
        $query = $db->get();
        print_r($query);
        foreach ($query->result_array() as $key => $val) {
            print_r($val);
        }

    }


    public function test_es()
    {
        $db = $this->load->database('smzdm',TRUE);
        $db->from('wp_users');
        $db->limit(20000,0);
        $query = $db->get();
        $data = $query->result_array();
        $type = "users";
        foreach ($data as $item) {
            $id = $item['ID'];
            unset($item['ID']);
            $insertdata = $item;

           $query = $this->elasticsearch->add($type,$id,$insertdata);
            print_r($query);
        }

    }

    public function test_get()
    {
        $clientParams = array(
            'hosts' => array(
                'http://localhost'
            ),
        );
        $client = new Elasticsearch\Client($clientParams);
        $params = array();
        $params['index'] = 'smzdm_test_user';
        $params['type'] = 'users';
        //$params['body']['query']['match']['name'] = 'lzl';
        $params['id'] = 1885;
        $ret = $client->get($params);
        print_r($ret);
    }

    public function test_search()
    {
        $clientParams = array(
            'hosts' => array(
                'http://localhost'
            ),
        );

        $client = new Elasticsearch\Client($clientParams);

        //复杂搜索

        /*$params = array(
            'index' => 'smzdm_test_user',
            'type' => 'users',
            'body'=>array(
                'query' => array(
                    'filtered' => array(
                        'filter' => array(
                            'range' => array(
                                'user_registered'=> array(
                                    'gt' => '2011-06-14 16:19:29',
                                ),
                            )
                        ),
                        'query' => array(
                            'match' => array(
                                'user_nicename' => 'forkid'
                            ),
                        )
                    )
                ),
            )
        );*/
        // 全文检索
        /*$params = array(
            'index' => 'smzdm_test_user',
            'type' => 'users',
            'body' => array(
                'query'=>array(
                    'match'=>array(
                        'user_email' =>"@test204.com"
                    ),
                ),
            ),
        );*/

        //段落搜索
        $params = array(
            'index' => 'index',
            'type' => 'fulltext',
            'body' => array(
                'query' => array(
                    'match' => array(
                        'content' => '中国'
                    ),
                ),
            ),

        );
        $data = $client->search($params);
        print_r($data);
    }

    /**
     * 添加
     */
    public function test_index()
    {
        $clientParams = array(
            'hosts' => array(
                'http://localhost'
            ),
        );

        $client = new Elasticsearch\Client($clientParams);
        $db = $this->load->database('product_read',TRUE);
        $db->from('product_index');
        $db->limit(2000,0);
        $query = $db->get();
        $data = $query->result_array();
        foreach ($data as $item) {
            $id = $item['pro_id'];
            $params = array(
                'index' => 'product',
                'type' => 'last',

            );

        }

        $params = array(
          'index' => 'megacorp',
          'type' => 'employee',
           'id' => 3,
           'body'=>array(
               'first_name' => 'Douglas',
               'last_name'=>'Fir',
               'age'=>35,
               'about' => 'I like to build cabinets',
               'interests'=>array('forestry'),
           ),
        );
        $data = $client->index($params);
        print_r($data);
    }


}