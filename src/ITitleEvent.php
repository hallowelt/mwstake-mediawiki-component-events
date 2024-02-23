<?php

namespace MWStake\MediaWiki\Component\Events;

use MediaWiki\MediaWikiServices;
use MediaWiki\Page\PageIdentity;
use MediaWiki\User\UserIdentity;
use Title;

interface ITitleEvent extends INotificationEvent {
	/**
	 * @return Title
	 */
	public function getTitle(): Title;
}
