<?php

use MWStake\MediaWiki\Component\ProcessManager\ProcessManager;

return [
	'MWStake.EventEmitter' => static function ( \MediaWiki\MediaWikiServices $services ) {
		return new \MWStake\MediaWiki\Component\Events\EventEmitter(
			$GLOBALS['wgMWStakeEventConsumers']
		);
	}
];
