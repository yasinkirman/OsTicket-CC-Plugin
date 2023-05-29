<?php
require_once INCLUDE_DIR . 'class.plugin.php';

class OsticketYeniPluginConfig extends PluginConfig {

    function translate() {

        return Plugin::translate('yeni');
    }

    function getOptions() {
        list($__, $_N) = self::translate();        
        return array(
            'customcodeHeading' => new SectionBreakField(array(
                'label' => $__('Enter your custom code')
            )),
            'custom-code-css' => new TextareaField(array(
                'label' => $__('Custom CSS'),
                'configuration' => array('rows'=>10, 'cols'=>80, 'html'=>false),                
            )),
        );
    }

    function pre_save(&$config, &$errors) {
         try {

            $filepath = INCLUDE_DIR . "../ajax.php";

            $find = "url('^/i18n/(?P<lang>[\w_]+)/', patterns('ajax.i18n.php:i18nAjaxAPI',";
            $tag_start = "url('^/users', patterns('ajax.users.php:UsersAjaxAPI',
        url_get('^$', 'search'),
        url_get('^/local$', 'search', array('local')),
        url_get('^/remote$', 'search', array('remote')),
        url_get('^/(?P<id>\d+)$', 'getUser'),
        url_post('^/(?P<id>\d+)$', 'updateUser'),
        url_get('^/(?P<id>\d+)/preview$', 'preview'),
        url_get('^/(?P<id>\d+)/edit$', 'editUser'),
        url('^/lookup$', 'getUser'),
        url_get('^/lookup/form$', 'lookup'),
        url_post('^/lookup/form$', 'addUser'),
        url_get('^/add$', 'addUser'),
        url('^/import$', 'importUsers'),
        url_get('^/select$', 'selectUser'),
        url_get('^/select/(?P<id>\d+)$', 'selectUser'),
        url_get('^/select/auth:(?P<bk>\w+):(?P<id>.+)$', 'addRemoteUser'),
        url_get('^/(?P<id>\d+)/register$', 'register'),
        url_post('^/(?P<id>\d+)/register$', 'register'),
        url_get('^/(?P<id>\d+)/delete$', 'delete'),
        url_post('^/(?P<id>\d+)/delete$', 'delete'),
        url_get('^/(?P<id>\d+)/manage(?:/(?P<target>\w+))?$', 'manage'),
        url_post('^/(?P<id>\d+)/manage(?:/(?P<target>\w+))?$', 'manage'),
        url_get('^/(?P<id>\d+)/org(?:/(?P<orgid>\d+))?$', 'updateOrg'),
        url_post('^/(?P<id>\d+)/org$', 'updateOrg'),
        url_get('^/staff$', 'searchStaff'),
        url_post('^/(?P<id>\d+)/note$', 'createNote'),
        url_get('^/(?P<id>\d+)/forms/manage$', 'manageForms'),
        url_post('^/(?P<id>\d+)/forms/manage$', 'updateForms'),
        url('^/(?P<id>\d+)/tickets/export$', 'exportTickets')
    )),
    url('^/i18n/(?P<lang>[\w_]+)/', patterns('ajax.i18n.php:i18nAjaxAPI',";

            $contents = file_get_contents($filepath);

            $contents = str_replace("url('^/i18n/(?P<lang>[\w_]+)/', patterns('ajax.i18n.php:i18nAjaxAPI',", "url('^/users', patterns('ajax.users.php:UsersAjaxAPI',
        url_get('^$', 'search'),
        url_get('^/local$', 'search', array('local')),
        url_get('^/remote$', 'search', array('remote')),
        url_get('^/(?P<id>\d+)$', 'getUser'),
        url_post('^/(?P<id>\d+)$', 'updateUser'),
        url_get('^/(?P<id>\d+)/preview$', 'preview'),
        url_get('^/(?P<id>\d+)/edit$', 'editUser'),
        url('^/lookup$', 'getUser'),
        url_get('^/lookup/form$', 'lookup'),
        url_post('^/lookup/form$', 'addUser'),
        url_get('^/add$', 'addUser'),
        url('^/import$', 'importUsers'),
        url_get('^/select$', 'selectUser'),
        url_get('^/select/(?P<id>\d+)$', 'selectUser'),
        url_get('^/select/auth:(?P<bk>\w+):(?P<id>.+)$', 'addRemoteUser'),
        url_get('^/(?P<id>\d+)/register$', 'register'),
        url_post('^/(?P<id>\d+)/register$', 'register'),
        url_get('^/(?P<id>\d+)/delete$', 'delete'),
        url_post('^/(?P<id>\d+)/delete$', 'delete'),
        url_get('^/(?P<id>\d+)/manage(?:/(?P<target>\w+))?$', 'manage'),
        url_post('^/(?P<id>\d+)/manage(?:/(?P<target>\w+))?$', 'manage'),
        url_get('^/(?P<id>\d+)/org(?:/(?P<orgid>\d+))?$', 'updateOrg'),
        url_post('^/(?P<id>\d+)/org$', 'updateOrg'),
        url_get('^/staff$', 'searchStaff'),
        url_post('^/(?P<id>\d+)/note$', 'createNote'),
        url_get('^/(?P<id>\d+)/forms/manage$', 'manageForms'),
        url_post('^/(?P<id>\d+)/forms/manage$', 'updateForms'),
        url('^/(?P<id>\d+)/tickets/export$', 'exportTickets')
    )),
    url('^/i18n/(?P<lang>[\w_]+)/', patterns('ajax.i18n.php:i18nAjaxAPI',", $contents);

            file_put_contents($filepath, $contents);

        } catch(Exception $e) {
            error_log($e->getMessage());
        }
        return true;
     }
}