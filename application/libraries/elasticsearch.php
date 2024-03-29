<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Elasticsearch Library
 *
 * @package OpenLibs
 *
 */
class ElasticSearch
{
    public $index;

    /**
     * constructor setting the config variables for server ip and index.
     */

    public function __construct()
    {
        $ci = & get_instance();
        $ci->config->load("elasticsearch");
        $this->server = $ci->config->item('es_server');
        $this->index  = $ci->config->item('index');
    }

    /**
     * Handling the call for every function with curl
     *
     * @param type $path
     * @param type $method
     * @param type $data
     *
     * @return type
     * @throws Exception
     */

    private function call($path, $method = 'GET', $data = NULL)
    {
        var_dump($path);
        if (!$this->index) {
            throw new Exception('$this->index needs a value');
        }

        $url = $this->server . '/' . $this->index . '/' . $path;

        $headers = array('Accept: application/json', 'Content-Type: application/json',);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        switch ($method) {
            case 'GET' :
                break;
            case 'POST' :
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;
            case 'PUT' :
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case 'DELETE' :
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }

        $response = curl_exec($ch);
        $code     = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return json_decode($response, TRUE);
    }


    /**
     * create a index with mapping or not
     *
     * @param json $map
     */

    public function create($map = FALSE)
    {
        if (!$map) {
            $this->call(NULL, 'PUT');
        } else {
            $this->call(NULL, 'PUT', $map);
        }
    }

    /**
     * get status
     *
     * @return array
     */

    public function status()
    {
        return $this->call('_status');
    }

    /**
     * count how many indexes it exists
     *
     * @param string $type
     *
     * @return array
     */

    public function count($type)
    {
        return $this->call($type . '/_count?' . http_build_query(array(NULL => '{matchAll:{}}')));
    }

    /**
     * set the mapping for the index
     *
     * @param string $type
     * @param json   $data
     *
     * @return array
     */

    public function map($type, $data)
    {
        return $this->call($type . '/_mapping', 'PUT', $data);
    }

    /**
     * set the mapping for the index
     *
     * @param type $type
     * @param type $id
     * @param type $data
     *
     * @return type
     */

    public function add($type, $id, $data)
    {
        return $this->call($type . '/' . $id, 'PUT', $data);
    }

    /**
     * delete a index
     *
     * @param type $type
     * @param type $id
     *
     * @return type
     */

    public function delete($type, $id)
    {
        return $this->call($type . '/' . $id, 'DELETE');
    }

    /**
     * make a simple search query
     *
     * @param type $type
     * @param type $q
     *
     * @return type
     */

    public function query($type, $q)
    {
        return $this->call($type . '/_search?' . http_build_query(array('q' => $q)));
    }

    /**
     * make a advanced search query with json data to send
     *
     * @param type $type
     * @param type $query
     *
     * @return type
     */

    public function advancedquery($type, $query)
    {
        return $this->call($type . '/_search', 'POST', $query);
    }

    /**
     * make a search query with result sized set
     *
     * @param string  $type  what kind of type of index you want to search
     * @param string  $query the query as a string
     * @param integer $size  The size of the results
     *
     * @return array
     */

    public function query_wresultSize($type, $q, $size = 999)
    {
        return $this->call($type . '/_search?' . http_build_query(array('q' => $q, 'size' => $size)));
    }

    /**
     * get one index via the id
     *
     * @param string  $type The index type
     * @param integer $id   the indentifier for a index
     *
     * @return type
     */

    public function get($type, $id)
    {
        return $this->call($type . '/' . $id, 'GET');
    }

    /**
     * Query the whole server
     *
     * @param type $query
     *
     * @return type
     */

    public function query_all($query)
    {
        return $this->call('_search?' . http_build_query(array('q' => $query)));
    }

    /**
     * get similar indexes for one index specified by id - send data to add filters or more
     *
     * @param string  $type
     * @param integer $id
     * @param string  $fields
     * @param string  $data
     *
     * @return array
     */

    public function morelikethis($type, $id, $fields = FALSE, $data = FALSE)
    {
        if ($data != FALSE && !$fields) {
            return $this->call($type . '/' . $id . '/_mlt', 'GET', $data);
        } else if ($data != FALSE && $fields != FALSE) {
            return $this->call($type . '/' . $id . '/_mlt?' . $fields, 'POST', $data);
        } else if (!$fields) {
            return $this->call($type . '/' . $id . '/_mlt');
        } else {
            return $this->call($type . '/' . $id . '/_mlt?' . $fields);
        }
    }

    /**
     * make a search query with result sized set
     *
     * @param type $query
     * @param type $size
     *
     * @return type
     */
    public function query_all_wresultSize($query, $size = 999)
    {
        return $this->call('_search?' . http_build_query(array('q' => $query, 'size' => $size)));
    }

}
