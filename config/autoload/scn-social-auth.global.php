<?php
/**
 * ScnSocialAuth Configuration
 *
 * If you have a ./config/autoload/ directory set up for your project, you can
 * drop this config file in it and change the values as you wish.
 */
$settings = array(
    /**
     * Facebook Enabled
     *
     * Please specify if Facebook is enabled
     */
    'facebook_enabled' => true,

	/**
     * Facebook Scope
     *
     * Please specify a Facebook scope
     *
     * A comma-separated list of permissions you want to request from the user.
     * See the Facebook docs for a full list of available permissions:
     * http://developers.facebook.com/docs/reference/api/permissions.
     */
    'facebook_scope' => '',

	/**
     * Facebook Display
     *
     * Please specify a Facebook display
     *
     * The display context to show the authentication page.
     * Options are: page, popup, iframe, touch and wap.
     * Read the Facebook docs for more details:
     * http://developers.facebook.com/docs/reference/dialogs#display. Default: page
     */
    'facebook_display' => 'popup',

    /**
     * Foursquare Enabled
     *
     * Please specify if Foursquare is enabled
     */
    //'foursquare_enabled' => true,

    /**
     * Google Enabled
     *
     * Please specify if Google is enabled
     */
    'google_enabled' => false,

    /**
     * Google Scope
     *
     * Please specify a Google scope
     *
     * A space-separated list of permissions you want to request from the user.
     * See the Google docs for a full list of available permissions:
     * https://developers.google.com/accounts/docs/OAuth2Login#scopeparameter.
     */
    //'google_scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',

    /**
     * LinkedIn Enabled
     *
     * Please specify if LinkedIn is enabled
     */
    //'linkedIn_enabled' => true,

    /**
     * Twitter Enabled
     *
     * Please specify if Twitter is enabled
     */
    //'twitter_enabled' => true,
);

/**
 * You do not need to edit below this line
 */
return array(
    'scn-social-auth' => $settings,
    'service_manager' => array(
        'aliases' => array(
            'ScnSocialAuth_ZendDbAdapter' => (isset($settings['zend_db_adapter'])) ? $settings['zend_db_adapter']: 'Zend\Db\Adapter\Adapter',
        ),
    ),
);
