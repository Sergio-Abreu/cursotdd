<?php

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
 */
class UnitTester extends \Codeception\Actor
{
    use _generated\UnitTesterActions;

    /**
     * Define custom actions here
     * @param string   $expectedException
     * @param string   $expectedMessage
     * @param callable $callback
     */
    public function assertThrowsExceptionTypeAndMessage($expectedException, $expectedMessage, callable $callback)
    {
        try {
            call_user_func($callback);
            $this->fail('This command has not thrown an exception.');
        } catch (Exception $internalException) {
            $this->assertInstanceOf($expectedException, $internalException);
            $this->assertEquals($expectedMessage, $internalException->getMessage());
        }
    }
}
