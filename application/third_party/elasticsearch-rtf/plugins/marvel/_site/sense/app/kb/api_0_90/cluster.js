define([],function(){return function(t){t.addEndpointDescription("_cluster/state"),t.addEndpointDescription("_cluster/health"),t.addEndpointDescription("_cluster/settings",{methods:["GET","PUT"],data_autocomplete_rules:{persistent:{"routing.allocation.same_shard.host":{__one_of:[!1,!0]}},"transient":{__scope_link:".persistent"}}})}});