<?php

use Codeception\Module\PhpBrowser;

class MyBrowser extends PhpBrowser{

    protected $curl_defaults = array(
        CURLOPT_SSL_VERIFYPEER => false
    );
} 