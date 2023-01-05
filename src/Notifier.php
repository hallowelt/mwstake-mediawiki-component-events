<?php

namespace MWStake\MediaWiki\Component\Events;

final class Notifier {
	/** @var INotificationEventConsumer[] */
	private $consumers;
	/** @var array */
	private $queued = [];

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
		$signature = $this->getEventSignature( $event );
		$this->queued[$signature] = $event;
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
		return $this->getSignature( $event, [ $event->getKey() ] );
	}

	/**
	 * @param INotificationEvent $event
	 * @return string
	 */
	private function getEventContentSignature( INotificationEvent $event ) : string {
		return $this->getSignature( $event );
	}

	/**
	 * @param INotificationEvent $event
	 * @param array|null $bits
	 *
	 * @return string
	 */
	private function getSignature( INotificationEvent $event, ?array $bits = [] ) : string {
		$finalBits = array_merge( [
			$event->getAgent()->getId(),
			$event->getTime()->format( 'YmdHis' )
		], $bits );
		if ( $event instanceof ITitleEvent ) {
			$finalBits[] = $event->getTitle()->getPrefixedDBkey();
		}

		return md5( implode( $finalBits ) );
	}

	/**
	 * @return void
	 */
	private function filterOutOverrides() {
		// Go through each event and see which events it overrides, and remove those
		// from the queue
		$filterOut = [];
		/** @var INotificationEvent $event */
		foreach ( $this->queued as $event ) {
			$override = $event->hasPriorityOver();
			if ( empty( $override ) ) {
				continue;
			}
			foreach ( $this->queued as $signature => $checkEvent ) {
				if ( in_array( $checkEvent->getKey(), $override ) ) {
					$checkEventContentSig = $this->getEventContentSignature( $checkEvent );
					$eventContentSig = $this->getEventContentSignature( $event );
					if ( $checkEventContentSig === $eventContentSig ) {
						$filterOut[] = $signature;
					}
				}
			}
		}

		foreach ( $filterOut as $signature ) {
			unset( $this->queued[$signature] );
		}
	}

	/**
	 * Flush events to consumers, the magic happens here
	 */
	public function __destruct() {
		$this->filterOutOverrides();
		foreach ( $this->queued as $event ) {
			foreach ( $this->consumers as $consumer ) {
				if ( !$consumer->isInterested( $event ) ) {
					continue;
				}
				$consumer->consume( $event );
			}
		}
	}
}
