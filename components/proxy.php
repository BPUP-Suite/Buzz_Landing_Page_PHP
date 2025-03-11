<?php
$opts = [
    "http" => [
        "header" => "User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/537.36 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/537.36"
    ]
];
$context = stream_context_create($opts);
echo file_get_contents("https://web.messanger.bpup.israiken.it", false, $context);
?>
