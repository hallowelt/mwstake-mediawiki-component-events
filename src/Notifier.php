<?php

namespace MWStake\MediaWiki\Component\Events;

use InvalidArgumentException;

final class Notifier {
	/** @var INotificationEventConsumer[] */
	private $consumers;
	/** @var array */
	private $emittedEvents = [];

	/**
	 * @param array $consumers
	 */
	public function __construct( array $consumers ) {
		$this->consumers = $consumers;
	}

	/**
	 * @param INotificationEvent $event
	 *
	 * @throws \Exception
	 */
	public function emit( INotificationEvent $event ) {
		$this->assertEventNotAlreadyEmitted( $event );
		foreach ( $this->consumers as $consumer ) {
			if ( !$consumer->isInterested( $event ) ) {
				continue;
			}
			$consumer->consume( $event );
		}
	}

	/**
	 * @param INotificationEvent $event
	 *
	 * @return void
	 */
	private function assertEventNotAlreadyEmitted( INotificationEvent $event ) {
		$eventSignature = $this->getEventSignature( $event );
		if ( in_array( $eventSignature, $this->emittedEvents ) ) {
			throw new InvalidArgumentException( "Event already emitted {$event->getKey()}" );
		}
		$this->emittedEvents[] = $eventSignature;
	}

	/**
	 * Has key data of the event into a unique event signature
	 * This will be used to determine if same event is fired multiple times
	 * in one request
	 *
	 * @param INotificationEvent $event
	 *
	 * @return string
	 */
	private function getEventSignature( INotificationEvent $event ) : string {
		$bits = [
			$event->getKey(),
			$event->getAgent()->getId(),
			$event->getTime()->format( 'YmdHis' )
		];
		if ( $event instanceof ITitleEvent ) {
			$bits[] = $event->getTitle()->getPrefixedDBkey();
		}

		return md5( implode( $bits ) );
	}
}
