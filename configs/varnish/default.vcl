backend default {
        .host = "127.0.0.1";
        .port = "8080";
}

sub vcl_recv {
        if(req.url ~ "^/login"){
                return(lookup);
        } else {
                return(pipe);
        }
}
sub vcl_fetch {
        if (req.url ~ "login") {
                set beresp.ttl = 0.2s;
                set beresp.grace = 0.2s;
        }
        return (deliver);
}

