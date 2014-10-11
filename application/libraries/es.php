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
    public $result_data = array(
        'error_msg' => '',
        'data' => ''
    );

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
        try {
            $this->result_data['data'] = $this->client->ping();
        } catch (Exception $e) {
            $this->result_data['error_msg'] = $e->getMessage();
        }
        return $this->result_data;
    }

    public function info()
    {
        try {
            $this->result_data['data'] = $this->client->info();
        } catch (Exception $e) {
            $this->result_data['error_msg'] = $e->getMessage();
        }
        return $this->result_data;
    }

    /**
     * 创建索引.
     *
     * @param array $index_params
     *              $index_params['index'] = '索引名称' (必须)
     *              $index_params['body']['settings']['number_of_shards'] = 5;集群片什么的相关 默认是5
     *              $index_params['body']['settings']['number_of_replicas'] = 1;集群片什么的相关 默认是1
     *              $index_params['body']['mappings']['索引名称'] = array(
     *                  '_source' => array(
     *                      'enabled' => true,
     *                  ),
     *                  //字段属性设置
     *                  'properties' => array(
     *                      'pro_id' => array(
     *                          'type' => 'integer',
     *                      ),
     *                      'pro_name' => array(
     *                          'type'           => 'string',
     *                          "store"          => "no",
     *                          "term_vector"    => "with_positions_offsets",
     *                          "indexAnalyzer"  => "ik",
     *                          "searchAnalyzer" => "ik",
     *                          "include_in_all" => "true",
     *                          "boost"          => 8
     *                      ),
     *                      .....
     *                  ),
     *              );
     *
     *
     * @return array
     */
    public function create_index($index_params = array())
    {
        $index_options = array(
            'index' => '',
        );
        if (is_array($index_params))
            $index_options = array_merge($index_options,$index_params);
        extract($index_options);
        try {
            $this->result_data['data'] = $this->client->indices()->create($index_options);
        } catch (Exception $e) {
            $this->result_data['error_msg'] = $e->getMessage();
        }
        return $this->result_data;
    }

    /**
     * 删除索引.
     *
     * @param array $index_params
     *              $index_params['index'] = '索引名称' (必须)
     *
     * @return array
     */
    public function delete_index($index_params = array())
    {
         $index_options = array(
             'index' => '',
         );
        if (is_array($index_params))
            $index_options = array_merge($index_options,$index_params);
        extract($index_options);
        try {
            $this->result_data['data'] = $this->client->indices()->delete($index_options);
        } catch (Exception $e) {
            $this->result_data['error_msg'] = $e->getMessage();
        }

        return $this->result_data;
    }

    /**
     * 获取索引设置.
     *
     * @param array $index_params
     *              $index_params['index'] = '索引名称' (必须) 可以是数组返回多个索引的设置信息.
     *
     * @return array
     */
    public function get_index_settings($index_params = array())
    {
        $index_options = array(
            'index' => '',
        );
        if (is_array($index_params))
            $index_options = array_merge($index_options,$index_params);
        extract($index_options);
        try {
            $this->result_data['data'] = $this->client->indices()->getSettings($index_options);
        } catch (Exception $e) {
            $this->result_data['error_msg'] = $e->getMessage();
        }
        return $this->result_data;
    }

    /**
     * 修改索引设置.
     *
     * @param array $index_params
     *              $index_params['index'] = '索引名称' (必须)
     *
     * @return array
     */
    public function put_index_settings($index_params = array())
    {
        $index_options = array(
            'index' => '',
        );
        if (is_array($index_params))
            $index_options = array_merge($index_options,$index_params);
        extract($index_options);
        try {
            $this->result_data['data'] = $this->client->indices()->putSettings($index_options);
        } catch (Exception $e) {
            $this->result_data['error_msg'] = $e->getMessage();
        }
        return $this->result_data;
    }

    /**
     * 获取索引的mapping
     *
     * @param array $index_params
     *              $index_params['index'] = '索引名称' (必须) 可以是数组返回多个索引的设置信息.
     * @return array
     */
    public function get_index_mapping($index_params = array())
    {
        $index_options = array(
            'index' => ''
        );
        if (is_array($index_params))
            $index_options = array_merge($index_options,$index_params);
        extract($index_options);
        try {
            $this->result_data['data'] = $this->client->indices()->getMapping($index_options);
        } catch (Exception $e) {
            $this->result_data['error_msg'] = $e->getMessage();
        }
        return $this->result_data;
    }

    /**
     * 修改mapping.
     *
     * @param array $index_params
     *              $index_params['index'] = '索引名称' (必须)
     *
     * @return array
     */
    public function put_index_mapping($index_params = array())
    {
        $index_options = array(
            'index' => '',
            'type' => ''
        );
        if (is_array($index_params))
            $index_options = array_merge($index_options,$index_params);
        extract($index_options);
        try {
            $this->result_data['data'] = $this->client->indices()->putMapping($index_options);
        } catch (Exception $e) {
            $this->result_data['error_msg'] = $e->getMessage();
        }

        return $this->result_data;
    }

    /**
     * 创建文档.
     *
     * @param array $index_params
     *              $index_params['index'] = '索引名称' (必须)
     *              $index_params['type'] = '索引类型' (必须)
     *
     * @return array
     */
    public function index($index_params = array())
    {
        $index_options = array(
            'index' => '',
            'type' =>'',
            'id' => '',
            'body' => ''
        );
        if (is_array($index_params))
            $index_options = array_merge($index_options,$index_params);
        extract($index_options);
        try {
            $this->result_data['data'] = $this->client->index($index_options);
        } catch (Exception $e) {
            $this->result_data['error_msg'] = $e->getMessage();
        }
        return $this->result_data;
    }

    /**
     * 通过id获取文档信息 包括_index,_type 等等.
     *
     * @param array $params['id']              = (string) The document ID (Required)
     *                     ['index']           = (string) The name of the index (Required)
     *                     ['type']            = (string) The type of the document (use `_all` to fetch the first document matching the ID across all types) (Required)
     *                     ['_source']         = (list) True or false to return the _source field or not, or a list of fields to return
     *                     ['fields']          = (list) A comma-separated list of fields to return in the response
     *                     ['refresh']         = (boolean) Refresh the shard containing the document before performing the operation
     *                     ['parent']         = (string) The ID of the parent document
     *                     ['preference']     = (string) Specify the node or shard the operation should be performed on (default: random)
     *
     * @return array
     */
    public function get_doc($params = array())
    {
        $options = array(
            'index' => '',
            'id' => '',
            'refresh' => true,
            'type' => '_all',
            '_source' => true,
            'realtime' => false,
        );
        if (is_array($params))
            $options = array_merge($options,$params);
        extract($options);
        try {
            $this->result_data['data'] = $this->client->get($options);
        } catch (Exception $e) {
            $this->result_data['error_msg'] = $e->getMessage();
        }
        return $this->result_data;
    }

    /**
     * 通过id获取文档信息 不包括_index,_type 等等.
     *
     * @param array $params['id']              = (string) The document ID (Required)
     *                     ['index']           = (string) The name of the index (Required)
     *                     ['type']            = (string) The type of the document (use `_all` to fetch the first document matching the ID across all types) (Required)
     *
     * @return array
     */
    public function get_doc_source($params = array())
    {
        $options = array(
            'index' => '',
            'id' => '',
            'refresh' => true,
            'type' => '_all',
            'realtime' => true
        );
        if (is_array($params))
            $options = array_merge($options,$params);
        extract($options);
        try {
            $this->result_data['data'] = $this->client->getSource($options);
        } catch (Exception $e) {
            $this->result_data['error_msg'] = $e->getMessage();
        }
        return $this->result_data;
    }

    /**
     * 删除文档.
     *
     * $params['id']           = (string) The document ID (Required)
     *        ['index']        = (string) The name of the index (Required)
     *        ['type']         = (string) The type of the document (Required)
     *        ['consistency']  = (enum) Specific write consistency setting for the operation
     *        ['parent']       = (string) ID of parent document
     *        ['refresh']      = (boolean) Refresh the index after performing the operation
     *        ['replication']  = (enum) Specific replication type
     *        ['routing']      = (string) Specific routing value
     *        ['timeout']      = (time) Explicit operation timeout
     *        ['version_type'] = (enum) Specific version type
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function delete_doc($params = array())
    {
        $options = array(
            'index' => '',
            'id' => '',
            'type' => '_all',
        );
        if (is_array($params))
            $options = array_merge($options,$params);
        extract($options);
        try {
            $this->result_data['data'] = $this->client->delete($options);
        } catch (Exception $e) {
            $this->result_data['error_msg'] = $e->getMessage();
        }
        return $this->result_data;
    }

    /**
     * 基于查询删除索引；
     * $params[''] @todo finish the rest of these params
     *        ['ignore_unavailable'] = (bool) Whether specified concrete indices should be ignored when unavailable (missing or closed)
     *        ['allow_no_indices']   = (bool) Whether to ignore if a wildcard indices expression resolves into no concrete indices. (This includes `_all` string or when no indices have been specified)
     *        ['expand_wildcards']   = (enum) Whether to expand wildcard expression to concrete indices that are open, closed or both.
     *
     * @param array $params
     *
     * @return array
     */
    public function delete_doc_by_query($params = array())
    {
        $options = array(
            'index' => '',
            'type' => '',
            'body' => '',
        );
        if (is_array($params))
            $options = array_merge($options,$params);
        extract($options);
        try {
            $this->result_data['data'] = $this->client->deleteByQuery($options);
        } catch (Exception $e) {
            $this->result_data['error_msg'] = $e->getMessage();
        }
        return $this->result_data;
    }

    /**
     * 获取符合条件的文档总数.
     *
     * $params['index']              = (list) A comma-separated list of indices to restrict the results
     *        ['type']               = (list) A comma-separated list of types to restrict the results
     *        ['min_score']          = (number) Include only documents with a specific `_score` value in the result
     *        ['preference']         = (string) Specify the node or shard the operation should be performed on (default: random)
     *        ['routing']            = (string) Specific routing value
     *        ['source']             = (string) The URL-encoded query definition (instead of using the request body)
     *        ['body']               = (array) A query to restrict the results (optional)
     *        ['ignore_unavailable'] = (bool) Whether specified concrete indices should be ignored when unavailable (missing or closed)
     *        ['allow_no_indices']   = (bool) Whether to ignore if a wildcard indices expression resolves into no concrete indices. (This includes `_all` string or when no indices have been specified)
     *        ['expand_wildcards']   = (enum) Whether to expand wildcard expression to concrete indices that are open, closed or both.
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function get_doc_count($params = array())
    {
        $options = array(
            'index' => '',
            'type' => '',
            'body' => ''
        );
        if (is_array($params))
            $options = array_merge($options,$params);
        extract($options);
        try {
            $this->result_data['data'] = $this->client->count($options);
        } catch (Exception $e) {
            $this->result_data['error_msg'] = $e->getMessage();
        }
        return $this->result_data;
    }

    /**
     * $params['index']                    = (list) A comma-separated list of index names to search; use `_all` or empty string to perform the operation on all indices
     *        ['type']                     = (list) A comma-separated list of document types to search; leave empty to perform the operation on all types
     *        ['analyzer']                 = (string) The analyzer to use for the query string
     *        ['analyze_wildcard']         = (boolean) Specify whether wildcard and prefix queries should be analyzed (default: false)
     *        ['default_operator']         = (enum) The default operator for query string query (AND or OR)
     *        ['df']                       = (string) The field to use as default where no field prefix is given in the query string
     *        ['explain']                  = (boolean) Specify whether to return detailed information about score computation as part of a hit
     *        ['fields']                   = (list) A comma-separated list of fields to return as part of a hit
     *        ['from']                     = (number) Starting offset (default: 0)
     *        ['ignore_indices']           = (enum) When performed on multiple indices, allows to ignore `missing` ones
     *        ['indices_boost']            = (list) Comma-separated list of index boosts
     *        ['lenient']                  = (boolean) Specify whether format-based query failures (such as providing text to a numeric field) should be ignored
     *        ['lowercase_expanded_terms'] = (boolean) Specify whether query terms should be lowercased
     *        ['preference']               = (string) Specify the node or shard the operation should be performed on (default: random)
     *        ['q']                        = (string) Query in the Lucene query string syntax
     *        ['routing']                  = (list) A comma-separated list of specific routing values
     *        ['scroll']                   = (duration) Specify how long a consistent view of the index should be maintained for scrolled search
     *        ['search_type']              = (enum) Search operation type
     *        ['size']                     = (number) Number of hits to return (default: 10)
     *        ['sort']                     = (list) A comma-separated list of <field>:<direction> pairs
     *        ['source']                   = (string) The URL-encoded request definition using the Query DSL (instead of using request body)
     *        ['_source']                  = (list) True or false to return the _source field or not, or a list of fields to return
     *        ['_source_exclude']          = (list) A list of fields to exclude from the returned _source field
     *        ['_source_include']          = (list) A list of fields to extract and return from the _source field
     *        ['stats']                    = (list) Specific 'tag' of the request for logging and statistical purposes
     *        ['suggest_field']            = (string) Specify which field to use for suggestions
     *        ['suggest_mode']             = (enum) Specify suggest mode
     *        ['suggest_size']             = (number) How many suggestions to return in response
     *        ['suggest_text']             = (text) The source text for which the suggestions should be returned
     *        ['timeout']                  = (time) Explicit operation timeout
     *        ['version']                  = (boolean) Specify whether to return document version as part of a hit
     *        ['body']                     = (array|string) The search definition using the Query DSL
     *
     *      1.Request Body
     *          $params['index'] = 'my_product';
     *          $params['type'] = 'product';
     *          $params['body']['query']['term']['pro_name'] = '京东';
     *          $params['body']['query']['term']['pro_url'] = 'jd';
     *          $params['timeout'] = ;
     *          $params['from'] = 0; 默认0
     *          $params['size'] = 10; 默认10
     *
     *      2.URI Request
     *          $params['index'] = 'my_product';
     *          $params['type'] = 'product';
     *          $params['q']['pro_name'] = '苹果';
     *          $params['q']['pro_url'] = 'jd';
     *          $params['df'] = ''; //The default field to use when no field prefix is defined within the query.
     *          $params['analyzer'] = ''; //The analyzer name to be used when analyzing the query string..
     *          $params['default_operator'] = 'AND' //  'AND'或是'OR' 默认是'OR'
     *          $params['explain'] = 'true' //true 或是false For each hit, contain an explanation of how scoring of the hits was computed.
     *          $params['fields'] = array('pro_name','pro_url'); //需要返回的查询字段 ,不设置则返回全部
     *
     *          $params['from'] = 0; 默认0
     *          $params['size'] = 10; 默认10
     *          $params['search_type'] = The type of the search operation to perform. Can be dfs_query_then_fetch, dfs_query_and_fetch, query_then_fetch, query_and_fetch. Defaults to query_then_fetch.
     *          $params['lowercase_expanded_terms'] = Should terms be automatically lowercased or not. Defaults to true.
     *          $params['analyze_wildcard'] = Should wildcard and prefix queries be analyzed or not. Defaults to false.
     *
     *      3.Filter
     *          $params['index'] = 'my_product';
     *          $params['type'] = 'product';
     *          $params['body']['query']['term']['message'] = 'something';
     *          $params['body']['filter']['term']['tag'] = 'green';
     *          $params['body']['facets']['tag']['terms']['field'] = 'tag';
     *
     *      4.Sort
     *          $params['index'] = 'my_product';
     *          $params['type'] = 'product';
     *          $params['body']['query']['term']['message'] = 'iphone';
     *          $params['body']['sort']['pro_id']['order'] = 'desc';
     *
     *      5.Highlighting
     *          详见 http://www.elasticsearch.cn/guide/reference/api/search/highlighting.html
     *          $params['index'] = 'my_product';
     *          $params['type'] = 'product';
     *          $params['body']['query']['term']['message'] = 'iphone';
     *          //高亮
     *          $params['body']['highlight']['fields'] = array('pro_name'=>array('fragment_size'=>150));
     *          $params['body']['highlight']['pre_tags'] = array("<tag1>","<tag2>");
     *          $params['body']['highlight']['post_tags'] = array("</tag1>","</tag2>");
     *
     *      6.Fields
     *         详见 http://www.elasticsearch.cn/guide/reference/api/search/fields.html
     *         $params['index'] = 'my_product';
     *         $params['type'] = 'product';
     *         $params['body']['query']['term']['message'] = 'iphone';
     *         $params['body']['fields'] = array('pro_name','pro_id');
     *
     *
     *      7.Preference
     *         详见:http://www.elasticsearch.cn/guide/reference/api/search/preference.html
     *
     *      8.Filters
     *        详见:http://www.elasticsearch.cn/guide/reference/api/search/named-filters.html
     *
     *      9.Search Type
     *        详见:http://www.elasticsearch.cn/guide/reference/api/search/search-type.html
     *
     *      10.explain
     *          详见:http://www.elasticsearch.cn/guide/reference/api/search/explain.html
     *
     *      $params['index'] = 'my_product';
     *         $params['type'] = 'product';
     *         $params['body']['query']['term']['message'] = 'iphone';
     *         $params['body']['explain'] = true;
     *
     *      11.version
     *          详见:http://www.elasticsearch.cn/guide/reference/api/search/version.html
     *          $params['type'] = 'product';
     *          $params['body']['query']['term']['message'] = 'iphone';
     *          $params['body']['version'] = true;
     *
     *
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function search($params = array())
    {
        $options = array(
            'index' => '',
            'type' => '',
            'body' => ''
        );
        if (is_array($params))
            $options = array_merge($options,$params);
        extract($options);
        try {
            $this->result_data['data'] = $this->client->search($options);
        } catch (Exception $e) {
            $this->result_data['error_msg'] = $e->getMessage();
        }
        return $this->result_data;
    }

    /**
     * $params['index']        = (string) The name of the index with a registered percolator query (Required)
     *        ['type']         = (string) The document type (Required)
     *        ['prefer_local'] = (boolean) With `true`, specify that a local shard should be used if available, with `false`, use a random shard (default: true)
     *        ['body']         = (array) The document (`doc`) to percolate against registered queries; optionally also a `query` to limit the percolation to specific registered queries
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function percolate($params = array())
    {
        $options = array(
            'index' => '',
            'type' => '',
            'body' => ''
        );
        if (is_array($params))
            $options = array_merge($options,$params);
        extract($options);
        try {
            $this->result_data['data'] = $this->client->percolate($options);
        } catch (Exception $e) {
            $this->result_data['error_msg'] = $e->getMessage();
        }
        return $this->result_data;
    }

}