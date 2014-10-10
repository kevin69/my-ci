define([],function(){return function(e){function t(e){for(var t,o=e.editor.iterForCurrentLoc(),n=o.getCurrentToken();n&&n.type.indexOf("url")<0;){if("variable"===n.type&&'"type"'===n.value){if(n=e.editor.parser.nextNonEmptyToken(o),!n||"punctuation.colon"!==n.type)break;n=e.editor.parser.nextNonEmptyToken(o),n&&"string"===n.type&&(t=n.value.replace(/"/g,""));break}n=e.editor.parser.prevNonEmptyToken(o)}return t}e.addEndpointDescription("restore_snapshot",{methods:["POST"],patterns:["_snapshot/{id}/{id}/_restore"],url_params:{wait_for_completion:"__flag__"},data_autocomplete_rules:{indices:"*",ignore_unavailable:{__one_of:[!0,!1]},include_global_state:!1,rename_pattern:"index_(.+)",rename_replacement:"restored_index_$1"}}),e.addEndpointDescription("single_snapshot",{methods:["GET","DELETE"],patterns:["_snapshot/{id}/{id}"]}),e.addEndpointDescription("all_snapshots",{methods:["GET"],patterns:["_snapshot/{id}/_all"]}),e.addEndpointDescription("put_snapshot",{methods:["PUT"],patterns:["_snapshot/{id}/{id}"],url_params:{wait_for_completion:"__flag__"},data_autocomplete_rules:{indices:"*",ignore_unavailable:{__one_of:[!0,!1]},include_global_state:{__one_of:[!0,!1]},partial:{__one_of:[!0,!1]}}}),e.addEndpointDescription("put_repository",{methods:["PUT"],patterns:["_snapshot/{id}"],data_autocomplete_rules:{__scope_link:function(e){var o=t(e);return o?{settings:{__scope_link:function(e){var o={fs:{__template:{location:"path"},location:"path",compress:{__one_of:[!0,!1]},concurrent_streams:5,chunk_size:"10m",max_restore_bytes_per_sec:"20mb",max_snapshot_bytes_per_sec:"20mb"},url:{__template:{url:""},url:"",concurrent_streams:5},s3:{__template:{bucket:""},bucket:"",region:"",base_path:"",concurrent_streams:5,chunk_size:"10m",compress:{__one_of:[!0,!1]}},hdfs:{__template:{path:""},uri:"",path:"some/path",load_defaults:{__one_of:[!0,!1]},conf_location:"cfg.xml",concurrent_streams:5,compress:{__one_of:[!0,!1]},chunk_size:"10m"}},n=t(e);return n||(console.log("failed to resolve snapshot, defaulting to 'fs'"),n="fs"),o[n]}}}:{type:{__one_of:["fs","url","s3","hdfs"]}}}}})}});