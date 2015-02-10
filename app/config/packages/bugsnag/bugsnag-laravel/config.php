<?php return array(
    /**
     * Set your Bugsnag API Key.
     * You can find your API Key on your Bugsnag dashboard.
     */
//    'api_key' => getenv('bugsnag_api_key') ?: 'meilunzhi@gmail.com',

      'api_key' => getenv('bugsnag_api_key'),
      'api_key' => getenv('bugsnag_api_key') ?: '',

     /**
      * Set which release stages should send notifications to Bugsnag
    /**
     * Set which release stages should send notifications to Bugsnag
     * E.g: array('development', 'production')
     */
//    'notify_release_stages' => ['production'],
);
