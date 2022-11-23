<?php

namespace MWStake\MediaWiki\Component\Events;

interface IEventConsumer {
	/**
	 * React to an event
	 *
	 * @param IEvent $event
	 *
	 * @return void
	 */
	public function consume( IEvent $event ) : void;

	/**
	 * @param IEvent $event
	 *
	 * @return bool
	 */
	public function isInterested( IEvent $event ) : bool;
}
