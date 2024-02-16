<?php

namespace MWStake\MediaWiki\Component\Events;

use DateTime;
use MediaWiki\User\UserIdentity;
use Message;

interface INotificationEvent {
	/**
	 * Unique event key, as specified in the event registration
	 * (NotificationsEvents attribute)
	 *
	 * @return string
	 */
	public function getKey(): string;

	/**
	 * Message describing event type
	 *
	 * @return Message
	 */
	public function getKeyMessage(): Message;

	/**
	 * @return Message
	 */
	public function getMessage(): Message;

	/**
	 * @return string Icon name
	 */
	public function getIcon(): string;

	/**
	 * @return UserIdentity
	 */
	public function getAgent(): UserIdentity;

	/**
	 * @return DateTime
	 */
	public function getTime(): DateTime;

	/**
	 * Message to be shown before the list of links (if applicable)
	 * @return Message|null
	 */
	public function getLinksIntroMessage(): ?Message;

	/**
	 * @return EventLink[]
	 */
	public function getLinks(): array;

	/**
	 * List of users that should be notified about this event
	 * If the list is empty, the event will be sent to all users who are subscribed to the event
	 * If the list is not empty, the event will be sent
	 * only to users who are on the list AND subscribed to the event
	 *
	 * Use carefully, this should not do the general filtering, its meant just for events with
	 * a very specific set of receivers,
	 * eg. Permission change of particular users, group membership change, etc.
	 *
	 * @return array
	 */
	public function getPresetSubscribers(): array;

	/**
	 * This is just for DEV, otherwise DT is never changeable
	 * Will be removed eventually
	 * @param DateTime $time
	 *
	 * @return mixed
	 */
	public function setTime( DateTime $time );

	/**
	 * List of event-keys that this one overrides
	 * This is to be used to suppress notifications that are already covered by this one
	 * It will suppress same-topic events if classnames of those are returned here
	 *
	 * @return array
	 */
	public function hasPriorityOver(): array;
}
