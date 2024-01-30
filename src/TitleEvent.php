<?php

declare( strict_types=1 );

namespace MWStake\MediaWiki\Component\Events;

use MediaWiki\MediaWikiServices;
use MediaWiki\Page\PageIdentity;
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
	 * @param PageIdentity $title
	 */
	public function __construct( UserIdentity $agent, PageIdentity $title ) {
		parent::__construct( $agent );
		if ( !$title instanceof Title ) {
			$title = Title::castFromPageIdentity( $title );
		}
		$this->title = $title;
	}

	/**
	 * @return Title
	 */
	public function getTitle(): Title {
		return $this->title;
	}

	/**
	 * @return Message
	 */
	public function getMessage(): Message {
		$msgKey = $this->getMessageKey();
		if ( $this->isBotAgent() ) {
			$msgKey .= '-bot';
		}

		return Message::newFromKey( $msgKey )->params(
			$this->getTitle()->getFullURL(),
			$this->getTitleDisplayText()
		);
	}

	/**
	 * @return string
	 */
	protected function getMessageKey(): string {
		// STUB - to be implemented by subclasses
		return '';
	}

	/**
	 * @param Title|null $title
	 * @return string
	 */
	protected function getTitleDisplayText( ?Title $title = null ): string {
		$title = $title ?? $this->getTitle();
		if ( !$title->exists() ) {
			return $title->getPrefixedText();
		}
		$props = MediaWikiServices::getInstance()->getPageProps()
			->getProperties( $title, 'displaytext' );
		if ( isset( $props[$title->getArticleID()] ) ) {
			return $props[$title->getArticleID()];
		}

		return $title->getPrefixedText();
	}

	/**
	 * @inheritDoc
	 */
	public function getLinks(): array {
		return [
			new EventLink(
				$this->getTitle()->getFullURL(),
				Message::newFromKey( 'ext-notifications-link-label-view-page' )
			)
		];
	}

	/**
	 * @inheritDoc
	 */
	public static function getArgsForTesting(
		UserIdentity $agent, MediaWikiServices $services, array $extra = []
	): array {
		if ( isset( $extra['title'] ) ) {
			return [ $agent, $extra['title'] ];
		}
		return parent::getArgsForTesting( $agent, $services, $extra );
	}
}
