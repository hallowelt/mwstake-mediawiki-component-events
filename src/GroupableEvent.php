<?php

namespace MWStake\MediaWiki\Component\Events;

use Message;

interface GroupableEvent extends INotificationEvent {
	/**
	 * @param int $count
	 *
	 * @return Message
	 */
	public function getGroupMessage( int $count ): Message;
}
