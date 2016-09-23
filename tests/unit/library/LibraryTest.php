<?php
namespace test\library;

use cursoTDD\library\AlreadyBorrowedBookException;
use cursoTDD\library\Book;
use cursoTDD\library\BookLimitExceededException;
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
        verify($library->bookCount($user))->equals(0);
        $library->borrowBook($user, $book);
        verify($library->bookCount($user))->equals(1);
        verify($library->isBookAvailable($book))->false();
    }

    public function testBorrowSameBookToDifferentUsers()
    {
        $book = new Book('Game of Thrones', 'George', new \DateTime('1996-06-02'));
        $user = new User('Sérgio', 30910878);
        $user2 = new User('Carol', 64141119);
        $library = new Library();
        $library->addBook($book);
        verify($library->isBookAvailable($book))->true();
        verify($library->bookCount($user))->equals(0);
        verify($library->bookCount($user2))->equals(0);
        $library->borrowBook($user, $book);
        verify($library->bookCount($user))->equals(1);
        verify($library->bookCount($user2))->equals(0);
        verify($library->isBookAvailable($book))->false();
        $this->tester->assertThrowsExceptionTypeAndMessage(
            AlreadyBorrowedBookException::class,
            'This book is already borrowed',
            function() use ($library, $user2, $book) {
                $library->borrowBook($user2, $book);
            }
        );
        verify($library->bookCount($user2))->equals(0);
    }

    public function testBorrowMoreThanThreeBooks()
    {
        $book = new Book('Game of Thrones - livro 1', 'George', new \DateTime('1996-06-02'));
        $book2 = new Book('Game of Thrones - livro 2', 'George', new \DateTime('1997-06-02'));
        $book3 = new Book('Game of Thrones - livro 3', 'George', new \DateTime('1998-06-02'));
        $book4 = new Book('Game of Thrones - livro 4', 'George', new \DateTime('1999-06-02'));
        $user = new User('Sérgio', 30910878);
        $library = new Library();
        $library->addBook($book);
        $library->addBook($book2);
        $library->addBook($book3);
        $library->addBook($book4);
        verify($library->isBookAvailable($book))->true();
        verify($library->isBookAvailable($book2))->true();
        verify($library->isBookAvailable($book3))->true();
        verify($library->isBookAvailable($book4))->true();
        verify($library->bookCount($user))->equals(0);
        $library->borrowBook($user, $book);
        $library->borrowBook($user, $book2);
        $library->borrowBook($user, $book3);
        verify($library->bookCount($user))->equals(3);
        $this->tester->assertThrowsExceptionTypeAndMessage(
            BookLimitExceededException::class,
            'This user exceeded the book limit of 3',
            function() use ($library, $user, $book4) {
                $library->borrowBook($user, $book4);
            }
        );
        verify($library->bookCount($user))->equals(3);
    }

    public function testBorrowMoreThanSpecificBooks()
    {
        $book = new Book('Game of Thrones - livro 1', 'George', new \DateTime('1996-06-02'));
        $book2 = new Book('Game of Thrones - livro 2', 'George', new \DateTime('1997-06-02'));
        $book3 = new Book('Game of Thrones - livro 3', 'George', new \DateTime('1998-06-02'));
        $book4 = new Book('Game of Thrones - livro 4', 'George', new \DateTime('1999-06-02'));
        $book5 = new Book('Game of Thrones - livro 5', 'George', new \DateTime('1999-06-02'));
        $user = new User('Sérgio', 30910878);
        $library = new Library(3);
        $library->addBook($book);
        $library->addBook($book2);
        $library->addBook($book3);
        $library->addBook($book4);
        $library->addBook($book5);
        verify($library->isBookAvailable($book))->true();
        verify($library->isBookAvailable($book2))->true();
        verify($library->isBookAvailable($book3))->true();
        verify($library->isBookAvailable($book4))->true();
        verify($library->isBookAvailable($book5))->true();
        verify($library->bookCount($user))->equals(0);
        $library->borrowBook($user, $book);
        $library->borrowBook($user, $book2);
        $library->borrowBook($user, $book3);
        verify($library->bookCount($user))->equals(3);
        $library->changeBookLimit(4);
        $library->borrowBook($user, $book4);
        verify($library->bookCount($user))->equals(4);
        $library->changeBookLimit(1);
        verify($library->bookCount($user))->equals(4);
        $this->tester->assertThrowsExceptionTypeAndMessage(
            BookLimitExceededException::class,
            'This user exceeded the book limit of 1',
            function() use ($library, $user, $book5) {
                $library->borrowBook($user, $book5);
            }
        );
        verify($library->bookCount($user))->equals(4);
    }
}
