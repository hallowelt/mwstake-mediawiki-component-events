<?php

namespace MWStake\MediaWiki\Component\Events;

use MediaWiki\User\UserIdentity;

class BotAgent implements UserIdentity {

	/**
	 * @return int
	 */
	public function getId() {
		return 0;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return "Event Bot";
	}

	/**
	 * @return int
	 */
	public function getActorId() {
		return 0;
	}

	/**
	 * @param UserIdentity $user
	 *
	 * @return false
	 */
	public function equals( UserIdentity $user ) {
		return false;
	}

	/**
	 * @return bool
	 */
	public function isRegistered() {
		return true;
	}
}
