<?php

namespace MWStake\MediaWiki\Component\Events\Tests;

use DateTime;
use MediaWiki\User\UserIdentity;
use Message;
use MWStake\MediaWiki\Component\Events\INotificationEvent;
use RawMessage;

class DummyEvent implements INotificationEvent {
	private $id = 0;

	public function getKey() : string {
		return '';
	}

	public function getAgent() : UserIdentity {
		return \User::newFromId( 1 );
	}

	public function getTime() : DateTime {
		return new DateTime();
	}
	public function getPresetSubscribers() : array {
		return [];
	}

	public function getId() {
		return $this->id;
	}

	public function setId( $id ) {
		$this->id = $id;
	}

	public function getMessage() : Message {
		return new RawMessage( 'dummy' );
	}

	public function getIcon() : string {
		return '';
	}

	public function getLinks() : array {
		return [];
	}

	public function getKeyMessage() : Message {
		return new RawMessage( 'Dummy event' );
	}

	public function setTime( DateTime $time ) {
		// STUB
	}

	public function getGroupMessage( int $count ) : Message {
		return $this->getMessage();
	}
}
