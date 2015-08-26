<?php
    class Copy
    {
        //a number that indicates how many copies of a book exist in the library
        private $copies;
        //a number that indicates how many copies are not checked out.
        private $available;
        //the id of a row in the books table
        private $book_id;
        //the copy id 
        private $id;

        function __construct($copies, $available, $book_id, $id=null)
        {
            $this->copies = $copies;
            $this->available = $available;
            $this->book_id = $book_id;
            $this->id = $id;
        }

        function setCopies($new_copies)
        {
            $this->copies = (int) $new_copies;
        }

        function setAvailable($new_available)
        {
            $this->available = (int) $new_available;
        }

        function setBookId($new_book_id)
        {
            $this->book_id = (int) $new_book_id;
        }

        function getCopies()
        {
            return $this->copies;
        }

        function getAvailable()
        {
            return $this->available;
        }

        function getBookId()
        {
            return $this->book_id;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO copies (copies, available, book_id) VALUES ({$this->getCopies()}, {$this->getAvailable()}, {$this->getBookId()});");
        }
    }
?>
