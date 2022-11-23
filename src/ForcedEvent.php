<?php

namespace MMWStake\MediaWiki\Component\Events;

use MWStake\MediaWiki\Component\Events\IEvent;

interface ForcedEvent extends IEvent  {
	// Events implementing this interface cannot be opted out of
	// Consumers decide how to handle these events
}
