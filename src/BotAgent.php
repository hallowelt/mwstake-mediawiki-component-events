<?php

namespace MWStake\MediaWiki\Component\Events;
use MediaWiki\User\UserIdentity;


class BotAgent implements UserIdentity {

	public function getId() {
		return 0;
	}

	public function getName() {
		return "Event Bot";
	}

	public function getActorId() {
		return 0;
	}

	public function equals( UserIdentity $user ) {
		return false;
	}

	public function isRegistered() {
		return true;
	}
}
