<?php
namespace cursoTDD\library;

class Library
{
    /**
     * @var \SplObjectStorage
     */
    protected $bookStorage;
    /**
     * @var \SplObjectStorage
     */
    protected $userStorage;
    /**
     * @var integer
     */
    protected $bookLimit;

    /**
     * Library constructor.
     * @param integer $bookLimit
     */
    public function __construct($bookLimit = 3)
    {
        $this->bookStorage = new \SplObjectStorage();
        $this->userStorage = new \SplObjectStorage();
        $this->bookLimit = $bookLimit;
    }

    public function addBook(Book $book)
    {
        $this->bookStorage->attach($book, true);
    }

    public function borrowBook(User $user, Book $book)
    {
        if (!$this->isBookAvailable($book)) {
            throw new AlreadyBorrowedBookException('This book is already borrowed');
        }
        $countBooks = $this->bookCount($user);
        if ($countBooks >= $this->bookLimit) {
            throw new BookLimitExceededException("This user exceeded the book limit of {$this->bookLimit}");
        }
        $this->bookStorage[$book] = false;
        $this->userStorage->attach($user, ++$countBooks);
    }

    public function isBookAvailable(Book $book)
    {
        return $this->bookStorage[$book];
    }

    /**
     * @param integer $bookLimit
     */
    public function changeBookLimit($bookLimit)
    {
        $this->bookLimit = $bookLimit;
    }

    /**
     * @param User $user
     * @return integer
     */
    public function bookCount(User $user)
    {
        return $this->userStorage->contains($user) ? $this->userStorage[$user] : 0;
    }
}