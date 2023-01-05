<?php

use MWStake\MediaWiki\ComponentLoader\Bootstrapper;

if ( defined( 'MWSTAKE_MEDIAWIKI_COMPONENT_EVENTS_VERSION' ) ) {
	return;
}

define( 'MWSTAKE_MEDIAWIKI_COMPONENT_EVENTS_VERSION', '1.0.4' );

Bootstrapper::getInstance()
	->register( 'events', function () {
		$GLOBALS['wgServiceWiringFiles'][] = __DIR__ . '/includes/ServiceWiring.php';
		$GLOBALS['wgMWStakeNotificationEventConsumers'] = [];
	} );
