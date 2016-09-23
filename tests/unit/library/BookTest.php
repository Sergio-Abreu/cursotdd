<?php
namespace test\library;


use cursoTDD\library\Book;

class BookTest extends \Codeception\Test\Unit
{
    const GAME_OF_THRONES = 'Game of Thrones';
    const GEORGE_MARTIN = 'George Martin';
    const PUBLISH_DATE = '1996-06-02';
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testBookAttributes()
    {
        $book = new Book(self::GAME_OF_THRONES, self::GEORGE_MARTIN, new \DateTime(self::PUBLISH_DATE));
        verify($book->getAuthor())->equals(self::GEORGE_MARTIN);
        verify($book->getTitle())->equals(self::GAME_OF_THRONES);
        verify($book->getPublishDate())->isInstanceOf(\DateTime::class);
        verify($book->getPublishDate()->format('Y-m-d'))->equals(self::PUBLISH_DATE);
    }
}