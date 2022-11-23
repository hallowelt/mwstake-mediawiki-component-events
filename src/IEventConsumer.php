<?php

namespace MWStake\MediaWiki\Component\Events;

interface IEventConsumer {
	/**
	 * React to an event
	 *
	 * @param INotificationEvent $event
	 *
	 * @return void
	 */
	public function consume( INotificationEvent $event ) : void;

	/**
	 * @param INotificationEvent $event
	 *
	 * @return bool
	 */
	public function isInterested( INotificationEvent $event ) : bool;
}
