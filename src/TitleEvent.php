<?php

declare( strict_types=1 );

namespace MWStake\MediaWiki\Component\Events;

use MediaWiki\User\UserIdentity;
use Message;
use Title;

/**
 * Convenience base class for notification events
 */
abstract class TitleEvent extends NotificationEvent implements ITitleEvent {
	/** @var Title */
	protected $title;

	/**
	 * @param UserIdentity $agent
	 * @param Title $title
	 */
	public function __construct( UserIdentity $agent, Title $title ) {
		parent::__construct( $agent );
		$this->title = $title;
	}

	/**
	 * @return Title
	 */
	public function getTitle(): Title {
		return $this->title;
	}

	/**
	 * @return string
	 */
	protected function getTitleDisplayText() : string {
		if ( !$this->title->exists() ) {
			return $this->title->getPrefixedText();
		}
		$props = \PageProps::getInstance()->getProperties( $this->getTitle(), 'displaytext' );
		if ( isset( $props[$this->getTitle()->getArticleID()] ) ) {
			return $props[$this->getTitle()->getArticleID()];
		}

		return $this->title->getPrefixedText();
	}

	/**
	 * @inheritDoc
	 */
	public function getLinks() : array {
		return [
			new EventLink(
				$this->getTitle()->getFullURL(),
				Message::newFromKey( 'ext-notification-link-label-view-page' )
			)
		];
	}
}
