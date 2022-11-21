<?php

define('ROOT_DIR', realpath(__DIR__."/..")); //App dir root
define('RELATIVE_PATH', '/pub/wawe_app'); //Relative path of app
define('DEFAULT_LANG', 'en'); //Default language
define('LIST_LANGS', array('en', 'ru')); //List languages
define('SITE_DOMAIN', 'https://'.$_SERVER['HTTP_HOST']);
define('LOG_CLEAR_DAY', 7); //days save logs

define('C_REST_CLIENT_ID'. ''); //marketplace CLIENT_ID
define('C_REST_CLIENT_SECRET'. ''); //marketplace CLIENT_SECRET


define('WAWE_REDIRECT_URL', SITE_DOMAIN.RELATIVE_PATH.'/wawe');
define('WAWE_STATE', 'DJkSFfg');
define('WAWE_URL_AUTH', 'https://api.waveapps.com/oauth2/authorize/');
define('WAWE_URL_TOKEN', 'https://api.waveapps.com/oauth2/token/');
define('WAWE_URL_REQUEST', 'https://gql.waveapps.com/graphql/public');
define('WAWE_URL_SCOPE', 'customer:* invoice:read invoice:write product:* account:* business:* user:* vendor:*');

define('ADMIN_PANEL_LOGIN', 'admin');
define('ADMIN_PANEL_PASSWORD', 'Hkr4U851pef');