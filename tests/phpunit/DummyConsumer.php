<?php

namespace MWStake\MediaWiki\Component\Events\Tests;


use MWStake\MediaWiki\Component\Events\IEvent;
use MWStake\MediaWiki\Component\Events\IEventConsumer;

class DummyConsumer implements IEventConsumer {
	public function consume( IEvent $event ) : void {
		// STUB
	}

	public function isInterested( IEvent $event ) : bool {
		return true;
	}
}
