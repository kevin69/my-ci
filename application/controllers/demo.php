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
    public $paramDefaults = array(
        'connectionClass'       => '\Elasticsearch\Connections\GuzzleConnection',
        'connectionFactoryClass'=> '\Elasticsearch\Connections\ConnectionFactory',
        'connectionPoolClass'   => '\Elasticsearch\ConnectionPool\StaticNoPingConnectionPool',
        'selectorClass'         => '\Elasticsearch\ConnectionPool\Selectors\RoundRobinSelector',
        'serializerClass'       => '\Elasticsearch\Serializers\SmartSerializer',
        'sniffOnStart'          => false,
        'connectionParams'      => array(),
        'logging'               => false,
        'logObject'             => null,
        'logPath'               => 'elasticsearch.log',
        'logLevel'              => Psr\Log\LogLevel::INFO,
        'traceObject'           => null,
        'tracePath'             => 'elasticsearch.log',
        'traceLevel'            => Psr\Log\LogLevel::INFO,
        'guzzleOptions'         => array(),
        'connectionPoolParams'  => array(
            'randomizeHosts' => true
        ),
        'hosts' => array(
            'localhost:9200',
        ),
        'retries'               => null
    );
    public $client = NULL;
    function __construct()
    {
        parent::__construct();
        $this->client = new Elasticsearch\Client($this->paramDefaults);
    }

    public function test_create()
    {


        $serversParams = array(
            'hosts' => array(
                'localhost'
            ),
        );
        $client = new Elasticsearch\Client($serversParams);
        $db = $this->load->database('product_read',TRUE);
        $db->from('product_index');
        $db->limit(2000,2000);
        $query = $db->get();
        print_r($query);
        foreach ($query->result_array() as $key => $val) {
            $params = array();
            $id = $val['pro_id'];
            $params['body'] = $val;
            $params['index'] = 'test_product';
            $params['type'] = 'product';
            $params['id'] = $id;
            $ret = $client->index($params);
            if ($ret['created']) {
                echo "success \n";
            } else {
                echo "error $id\n";
            }
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

//        //段落搜索
//        $params = array(
//            'index' => 'index',
//            'type' => 'fulltext',
//            'body' => array(
//                'query' => array(
//                    'match' => array(
//                        'content' => '中国'
//                    ),
//                ),
//            ),
//
//        );
        //模糊搜索
        $params = array(
            'index' => 'test_product',
            'type' => 'product',
            'body' => array(
                'query' => array(
                    'bool' => array(
                    'should' => array(
                        'wildcard' => array(
                            'pro_name' => 'SONY',
                        )
                    )
                ),
            )),
            'from' => '0',
            'size' => '100'
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

    public function test_ignore()
    {
        $client = new Elasticsearch\Client();
        $params = array(
            'index'  => 'test_product',
            'type'   => 'product',
            'id'     => 11111,
            //'ignore' => [400,404]
        );

        var_dump( $client->get($params) );
    }

    //日志
    public function test_logger()
    {
        $params = array(
            'hosts' => array(
                'localhost:9200'
            ), //host
            'logging' => true,
            'logPath' => '/Users/smzdm/xhproflog/es_log/elasticsearch.log',
            //'logPermission' => 0664
            'logLevel' => Psr\Log\LogLevel::INFO, //错误级别
        );
        $client = new Elasticsearch\Client($params);
        $sp =  array(
            'index'  => 'test_product',
            'type'   => 'product',
            'id'     => 1,
            //'ignore' => [400,404]
        );
        var_dump( $client->get($sp) );
    }

    //测试 default config
    public function test_default_config()
    {
        $client = new Elasticsearch\Client($this->paramDefaults);
        $sp =  array(
            'index'  => 'test_product',
            'type'   => 'product',
            'id'     => 1,
            'ignore' => [400,404]
        );
        var_dump( $client->get($sp) );
    }

  //测试search
   public function test_search2()
   {
       /*//高亮
       $params = array(
           'index' => 'test_product',
           'type' => 'product',
           'body' => array(
               'query' => array(
                   'match' => array(
                    'pro_name' => '苹果'
                   ),
               ),
               'highlight' => array(
                   'fields' => array(
                       'pro_name' => ['苹果']
                   )
               )
           ),
       );*/

       $params['index'] = 'test_product';
       $params['type'] = 'product';


       $params['body'] = array(
           'query' => array(
               'match' => array(
                   'pro_name' => 'sony'
               ),
           ),
           //排序
           'sort' => array(
               array(
                   'pro_id' => array(
                       'order' => 'desc',
                   ),
               ),
               array(
                   'pro_editdate' => array(
                       'order' => 'desc'
                   )
               ),
           ),
           'from' => 0,
           'size' => 100
       );
       $data = $this->client->search($params);
       var_dump($data);
   }

    /**
     * ++++++++++++++++++++++++++++++++
     * 索引相关 start
     * ++++++++++++++++++++++++++++++++
     */

    public function create_index()
    {
        $indexParams['index'] = 'my_product2';

        //索引设置
        $indexParams['body']['settings']['number_of_shards'] = 3; // 貌似跟集群碎片有关，不知道干啥的
        $indexParams['body']['settings']['number_of_replicas'] = 2; // 貌似跟集群碎片有关，不知道干啥的

        //example index mapping

        $myTypeMapping = array(
            '_source'    => array(
                'enabled' => TRUE
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
                    'type' => 'string',
                ),
                'pro_editor' => array(
                    'type' => 'string',
                ),
            )
        );

        //$indexParams['body']['mappings']['my_product2'] = $myTypeMapping;

        $indexParams2 = [
            'index' => 'reuters',
            'body' => [
                'settings' => [
//                    'number_of_shards' => 1,
//                    'number_of_replicas' => 0,
                    'analysis' => [
                        'filter' => [
                            'shingle' => [
                                'type' => 'shingle'
                            ]
                        ],
                        'char_filter' => [
                            'pre_negs' => [
                                'type' => 'pattern_replace',
                                'pattern' => '(\\w+)\\s+((?i:never|no|nothing|nowhere|noone|none|not|havent|hasnt|hadnt|cant|couldnt|shouldnt|wont|wouldnt|dont|doesnt|didnt|isnt|arent|aint))\\b',
                                'replacement' => '~$1 $2'
                            ],
                            'post_negs' => [
                                'type' => 'pattern_replace',
                                'pattern' => '\\b((?i:never|no|nothing|nowhere|noone|none|not|havent|hasnt|hadnt|cant|couldnt|shouldnt|wont|wouldnt|dont|doesnt|didnt|isnt|arent|aint))\\s+(\\w+)',
                                'replacement' => '$1 ~$2'
                            ]
                        ],
                        'analyzer' => [
                            'reuters' => [
                                'type' => 'custom',
                                'tokenizer' => 'standard',
                                'filter' => ['lowercase', 'stop', 'kstem']
                            ]
                        ]
                    ]
                ],
                'mappings' => [
                    '_default_' => [
                        'properties' => [
                            'pro_name' => [
                                'type' => 'string',
                                'analyzer' => 'reuters',
                                'term_vector' => 'yes',
                                'copy_to' => 'combined'
                            ],
                            'pro_url' => [
                                'type' => 'string',
                                'analyzer' => 'reuters',
                                'term_vector' => 'yes',
                                'copy_to' => 'combined'
                            ],
                            'pro_pic' => [
                                'type' => 'string',
                                'analyzer' => 'reuters',
                                'term_vector' => 'yes'
                            ],
                            'pro_id' => [
                                'type' => 'string',
                                'index' => 'not_analyzed'
                            ],
                        ]
                    ],
                    'my_type' => [
                        'properties' => [
                            'my_field' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        //创建索引
        var_dump($this->client->indices()->create($indexParams2));



    }

    //删除索引
    public function delete_index()
    {
        $deleteParams['index'] = 'my_product2';
        var_dump($this->client->indices()->delete($deleteParams));
    }

    //put setting api
    function put_index_setting()
    {
        $params['index'] = 'my_product';
        $params['body']['index']['number_of_replicas'] = 0;
        $params['body']['index']['refresh_interval'] = -1;

        $ret = $this->client->indices()->putSettings($params);
        var_dump($ret);
    }

    //get setting api
    function get_index_setting()
    {
        //获取一个索引的设置
        /*$params['index'] = 'my_product';
        $ret = $this->client->indices()->getSettings($params);
        var_dump($ret);*/

        //获取多个
        $params['index'] = array('my_product','test_product');
        $ret = $this->client->indices()->getSettings($params);
        var_dump($ret);
    }

    //get mapings api
    function get_mappings()
    {
        // Get mappings for all indexes and types
        $ret = $this->client->indices()->getMapping();
        //var_dump($ret);


        // Get mappings for all types in 'test_product'
        $params['index'] = 'test_product';

        $ret = $this->client->indices()->getMapping($params);

        $params['type'] = 'product';
        $ret = $this->client->indices()->getMapping($params);

        // Get mapping 'my_type' in 'my_index'
        $params['index'] = 'my_index';
        $params['type']  = 'my_type';
        $ret = $this->client->indices()->getMapping($params);

        // Get mappings for two indexes
        $params['index'] = array('my_index', 'my_index2');
        $ret = $this->client->indices()->getMapping($params);
       var_dump($ret);
    }

    //put mappings api
    function put_mappings()
    {
        $p['index'] = 'test_product';
        $p['type'] = 'product';

        $mappings = array(
            '_source' => array(
                'enabled' => true
            ),
            'properties' => array(
                'pro_name'  => array(
                    'type'           => 'string',
                    "store"          => "no",
                    "term_vector"    => "with_positions_offsets",
                    "indexAnalyzer"  => "ik",
                    "searchAnalyzer" => "ik",
                    "include_in_all" => "true",
                    "boost"          => 8
                ),
            )
        );

        $p['body']['product'] = $mappings;

        //更新mapping
        var_dump($this->client->indices()->putMapping($p));
    }


    /**
     * ++++++++++++++++++++++++++++++++
     * 索引相关 end
     * ++++++++++++++++++++++++++++++++
     */

}