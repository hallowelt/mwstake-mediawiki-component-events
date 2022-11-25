<?php

namespace MWStake\MediaWiki\Component\Events\Tests;

use MWStake\MediaWiki\Component\Events\Notifier;
use PHPUnit\Framework\TestCase;

class EmitterTest extends TestCase {

	/**
	 * @covers \MWStake\MediaWiki\Component\Events\Emitter::emit
	 */
	public function testEmit() {
		$event = new DummyEvent();

		$consumer = $this->getMockBuilder( DummyConsumer::class )
			->setMethods( [ 'consume', 'isInterested' ] )
			->getMock();
		$consumer->expects( $this->once() )
			->method( 'consume' )
			->with( $event );
		$consumer->expects( $this->once() )
			->method( 'isInterested' )
			->with( $event )
			->willReturn( true );

		$emitter = new Notifier( [ $consumer ] );
		$emitter->emit( $event );
	}

	/**
	 * @covers \MWStake\MediaWiki\Component\Events\Emitter::emit
	 */
	public function testEmitNotInterested() {
		$event = new DummyEvent();

		$consumer = $this->getMockBuilder( DummyConsumer::class )
			->setMethods( [ 'consume', 'isInterested' ] )
			->getMock();
		$consumer->expects( $this->never() )
			->method( 'consume' );
		$consumer->expects( $this->once() )
			->method( 'isInterested' )
			->with( $event )
			->willReturn( false );

		$emitter = new Notifier( [ $consumer ] );
		$emitter->emit( $event );
	}

	/**
	 * @covers \MWStake\MediaWiki\Component\Events\Emitter::emit
	 */
	public function testEmitMultipleConsumers() {
		$event = new DummyEvent();

		$consumer1 = $this->getMockBuilder( DummyConsumer::class )->setMethods( [ 'consume',
				'isInterested' ] )->getMock();
		$consumer1->expects( $this->once() )->method( 'consume' )->with( $event );
		$consumer1->expects( $this->once() )->method( 'isInterested' )->with( $event )->willReturn( true );

		$consumer2 = $this->getMockBuilder( DummyConsumer::class )->setMethods( [ 'consume',
				'isInterested' ] )->getMock();
		$consumer2->expects( $this->once() )->method( 'consume' )->with( $event );
		$consumer2->expects( $this->once() )->method( 'isInterested' )->with( $event )->willReturn( true );

		$emitter = new Notifier( [ $consumer1, $consumer2 ] );
		$emitter->emit( $event );

	}
}
