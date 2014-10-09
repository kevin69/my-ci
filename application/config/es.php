<?php
/**
 * Created by PhpStorm.
 * User: smzdm
 * Date: 14-10-9
 * Time: 下午6:04
 */
$config = array(
     'es' =>array(
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
));