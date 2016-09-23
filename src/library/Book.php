<?php
namespace cursoTDD\library;

class Book
{
    /**
     * @var string
     */
    private $author;
    /**
     * @var string
     */
    private $title;
    /**
     * @var \DateTime
     */
    private $publishDate;

    /**
     * Book constructor.
     * @param string    $title
     * @param string    $author
     * @param \DateTime $publishDate
     */
    public function __construct($title, $author, \DateTime $publishDate)
    {
        $this->author = $author;
        $this->title = $title;
        $this->publishDate = $publishDate;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return \DateTime
     */
    public function getPublishDate()
    {
        return $this->publishDate;
    }
}
