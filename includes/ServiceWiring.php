<?php

return [
	'MWStake.Notifier' => static function ( \MediaWiki\MediaWikiServices $services ) {
		$consumers = [];
		foreach ( $GLOBALS['wgMWStakeNotificationEventConsumers'] as $consumerSpec ) {
			$consumer = $services->getObjectFactory()->createObject( $consumerSpec );
			if ( $consumer instanceof \MWStake\MediaWiki\Component\Events\INotificationEventConsumer ) {
				$consumers[] = $consumer;
			}
		}
		return new \MWStake\MediaWiki\Component\Events\Notifier( $consumers );
	}
];
