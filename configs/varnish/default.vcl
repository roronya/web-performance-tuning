backend default {
        .host = "127.0.0.1";
        .port = "8080";
}

sub vcl_recv {
	if (req.request == "REFRESH") {
		ban("req.url ~ " + "^/exercise/part4");
		set req.request = "GET";
		error 200 "refresh.";
	}
	if (req.url ~ "^/exercise/part1") {
		return(lookup);
	}
	if (req.url ~ "^/exercise/part4") {
		return(lookup);
	}
	if (req.url ~ "^/exercise/part5"){
		return(lookup);
	}
        else {
                return(pipe);
        }
}
