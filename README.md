# Events

This component allows you to emit notification events to consumers

# Usage

## Register consumer

```php
$GLOBALS['wgMWStakeNotificationEventConsumers'][] = [
	'class' => MyConsumer::class,
	'services' => [
		'UserFactory'
	]
];
```

## Create Event

```php
class MyEvent implements \MWStake\MediaWiki\Component\Events\INotificationEvent {
 ....
}

$event = new MyEvent( $user );
```


## Emit Event

```php
$notifier = MediaWikiServices::getInstance()->getService( 'MWStake.Notifier' );
$notifier->emit( $event );

// Will call MyConsumer::consume( $event )
```

