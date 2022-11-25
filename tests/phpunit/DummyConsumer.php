<?php

namespace MWStake\MediaWiki\Component\Events\Tests;


use MWStake\MediaWiki\Component\Events\INotificationEvent;
use MWStake\MediaWiki\Component\Events\INotificationEventConsumer;

class DummyConsumer implements INotificationEventConsumer {
	public function consume( INotificationEvent $event ) : void {
		// STUB
	}

	public function isInterested( INotificationEvent $event ) : bool {
		return true;
	}
}
