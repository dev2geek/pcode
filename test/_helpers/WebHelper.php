<?php
namespace Codeception\Module;

use Codeception\Util\Connector\Goutte;
use Guzzle\Http\Client;
use Codeception\TestCase;
use Symfony\Component\BrowserKit\Request;

// here you can define custom functions for WebGuy 

class WebHelper extends PhpBrowser {

    protected $curl_defaults = array(
        CURLOPT_SSL_VERIFYPEER => false
    );

    public function _initialize() {
        $this->goutte = new Goutte();
        $driver = new \Behat\Mink\Driver\GoutteDriver($this->goutte);

        // build up a Guzzle friendly list of configuration options
        // passed in both from our defaults and the respective
        // yaml configuration file (if applicable)
        $curl_config['curl.options'] = $this->curl_defaults;
        foreach ($this->config['curl'] as $key => $val) {
            if (defined($key)) $curl_config['curl.options'][constant($key)] = $val;
        }

        // Guzzle client requires that we set the ssl.certificate_authority config
        // directive if we wish to disable SSL verification
        if ($curl_config['curl.options'][CURLOPT_SSL_VERIFYPEER] !== true) {
            $curl_config['ssl.certificate_authority'] = false;
        }

        $this->goutte->setClient($this->guzzle = new Client('', $curl_config));
        $this->session = new \Behat\Mink\Session($driver);
        //parent->parent::pa_initialize();
    }
}
