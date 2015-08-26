<?php
    class Copy
    {
        private $copies;
        private $available;
        private $book_id;
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
            return 
        }
    }
?>
