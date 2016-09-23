<?php
namespace cursoTDD\library;

class Library
{

    /**
     * Library constructor.
     */
    public function __construct()
    {
        $this->bookStorage = new \SplObjectStorage();
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
        $this->bookStorage[$book] = false;
    }

    public function isBookAvailable(Book $book)
    {
        return $this->bookStorage[$book];
    }
}