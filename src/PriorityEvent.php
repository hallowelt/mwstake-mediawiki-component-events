<?php

namespace MWStake\MediaWiki\Component\Events;

interface PriorityEvent extends IEvent {
	// Events implementing this interface will be prioritized over other events
}
