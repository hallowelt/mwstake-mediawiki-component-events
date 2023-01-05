<?php

declare( strict_types=1 );

namespace MWStake\MediaWiki\Component\Events;

use DateTime;
use MediaWiki\User\UserIdentity;
use Message;

/**
 * Convenience base class for notification events
 */
abstract class NotificationEvent implements INotificationEvent {
	/** @var UserIdentity */
	protected $agent;
	/** @var DateTime */
	protected $time;

	/**
	 * @param UserIdentity $agent
	 */
	public function __construct( UserIdentity $agent ) {
		$this->agent = $agent;
		$this->time = new DateTime();
	}

	/**
	 * @return UserIdentity
	 */
	public function getAgent(): UserIdentity {
		return $this->agent;
	}

	/**
	 * @return string
	 */
	public function getIcon() : string {
		return '';
	}

	/**
	 * @return Message
	 */
	public function getKeyMessage() : Message {
		return Message::newFromKey( 'extension-notifications-event-' . $this->getKey() );
	}

	/**
	 * @return DateTime
	 */
	public function getTime(): DateTime {
		return $this->time;
	}

	/**
	 * @return array
	 */
	public function getPresetSubscribers() : array {
		// Notify all subscribed users
		return [];
	}

	/**
	 * @param DateTime $time
	 *
	 * @return void
	 */
	public function setTime( DateTime $time ) {
		$this->time = $time;
	}

	/**
	 * @inheritDoc
	 */
	public function hasPriorityOver() : array {
		return [];
	}
}
