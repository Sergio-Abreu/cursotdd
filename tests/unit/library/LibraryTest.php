<?php
namespace test\library;

use cursoTDD\library\Book;
use cursoTDD\library\Library;
use cursoTDD\library\User;

class LibraryTest extends \Codeception\Test\Unit
{
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

    public function testBorrowBook()
    {
        $book = new Book('Game of Thrones', 'George', new \DateTime('1996-06-02'));
        $user = new User('Sérgio', 30910878);
        $library = new Library();
        $library->addBook($book);
        verify($library->isBookAvailable($book))->true();
        $library->borrowBook($user, $book);
        verify($library->isBookAvailable($book))->false();
    }

    /**
     * @expectedException cursoTDD\library\AlreadyBorrowedBookException
     * @expectedExceptionMessage  This book is already borrowed
     */
    public function testBorrowSameBookToDifferentUsers()
    {
        $book = new Book('Game of Thrones', 'George', new \DateTime('1996-06-02'));
        $user = new User('Sérgio', 30910878);
        $user2 = new User('Carol', 64141119);
        $library = new Library();
        $library->addBook($book);
        verify($library->isBookAvailable($book))->true();
        $library->borrowBook($user, $book);
        verify($library->isBookAvailable($book))->false();
        $library->borrowBook($user2, $book);
    }
}
