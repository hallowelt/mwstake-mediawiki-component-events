# Events

This component allows you to emit events to consumers

# Usage

## Register consumer

```php
$GLOBALS['wgMWStakeEventConsumers'][] = [
	'class' => MyConsumer::class,
	'services' => [
		'UserFactory'
	]
];
```

## Create Event

```php
class MyEvent implements IEvent {
 ....
}

$event = new MyEvent( $user );
```


## Emit Event

```php
$eventEmitter = MediaWikiServices::getInstance()->getService( 'MWStake.EventEmitter' );
$eventEmitter->emit( $event );

// Will call MyConsumer::consume( $event )
```

