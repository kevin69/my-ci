define([],function(){var e={__template:{field:""},field:"$FIELD$",script:"",params:{},lang:"mvel"},_={__template:{field:""},field:"$FIELD$"},o={"*":{aggs:{__template:{NAME:{AGG_TYPE:{}}}},min:e,max:e,avg:e,stats:e,extended_stats:e,value_count:{__template:{field:""},field:"$FIELD$"},global:{},filter:{},missing:_,nested:{__template:{path:""},path:""},terms:{__template:{field:"",size:10},field:"$FIELD$",size:10,shard_size:10,order:{__template:{_term:"asc"},_term:{__one_of:["asc","desc"]},_count:{__one_of:["asc","desc"]},"*":{__one_of:["asc","desc"]}},min_doc_count:10,script:"_value",params:{},lang:"mvel",include:"*",exclude:"*",execution_hint:{__one_of:["asc","desc"]}},range:{__template:{field:"",ranges:[{from:50,to:100}]},field:"$FIELD$",ranges:[{to:50,from:100,key:""}],keyed:{__one_of:[!0,!1]},script:"_value",params:{},lang:"mvel"},date_range:{__template:{field:"",ranges:[{from:"now-10d/d",to:"now"}]},field:"$FIELD$",format:"MM-yyy",ranges:[{to:"",from:"",key:""}],keyed:{__one_of:[!0,!1]},script:"_value",params:{},lang:"mvel"},ip_range:{__template:{field:"",ranges:[{from:"10.0.0.5",to:"10.0.0.10"}]},field:"$FIELD$",format:"MM-yyy",ranges:[{to:"",from:"",key:"",mask:"10.0.0.127/25"}],keyed:{__one_of:[!0,!1]},script:"_value",params:{},lang:"mvel"},histogram:{__template:{field:"price",interval:50},field:"$FIELD$",interval:50,min_doc_count:0,order:{__template:{_key:"asc"},_key:{__one_of:["asc","desc"]},_count:{__one_of:["asc","desc"]},"*":{__one_of:["asc","desc"]}},keyed:{__one_of:[!0,!1]}},date_histogram:{__template:{field:"date",interval:"month"},field:"$FIELD$",interval:{__one_of:["year","quarter","week","day","hour","minute","second"]},min_doc_count:0,order:{__template:{_key:"asc"},_key:{__one_of:["asc","desc"]},_count:{__one_of:["asc","desc"]},"*":{__one_of:["asc","desc"]}},keyed:{__one_of:[!0,!1]},pre_zone:"-01:00",post_zone:"-01:00",pre_zone_adjust_large_interval:{__one_of:[!0,!1]},factor:1e3,pre_offset:"1d",post_offset:"1d",format:"yyyy-MM-dd"},geo_distance:{__template:{field:"location",origin:{lat:52.376,lon:4.894},ranges:[{from:100,to:300}]},field:"$FIELD$",origin:{lat:0,lon:0},unit:{__one_of:["mi","km","in","yd","m","cm","mm"]},ranges:[{from:50,to:100}],distance_type:{__one_of:["arc","sloppy_arc","plane"]}},geohash_grid:{__template:{field:"",precision:3},field:"$FIELD#",precision:{__one_of:[1,2,3,4,5,6,7,8,9,10,11,12]},size:10,shard_size:10}}};return function(e){e.addGlobalAutocompleteRules("aggregations",o),e.addGlobalAutocompleteRules("aggs",o)}});