<?php

namespace MWStake\MediaWiki\Component\Events;

use Title;

interface ITitleEvent extends IEvent {
	/**
	 * @return Title
	 */
	public function getTitle(): Title;
}
