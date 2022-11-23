<?php

use MWStake\MediaWiki\Component\ProcessManager\ProcessManager;

return [
	'MWStake.EventEmitter' => static function ( \MediaWiki\MediaWikiServices $services ) {
		$consumers = [];
		foreach ( $GLOBALS['wgMWStakeEventConsumers'] as $consumerSpec ) {
			$consumer = $services->getObjectFactory()->createObject( $consumerSpec );
			if ( $consumer instanceof \MWStake\MediaWiki\Component\Events\IEventConsumer ) {
				$consumers[] = $consumer;
			}
		}
		return new \MWStake\MediaWiki\Component\Events\EventEmitter( $consumers	);
	}
];
