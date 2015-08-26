<?php
    class Copy
    {
        //a number that indicates how many copies of a book exist in the library
        private $number_copies;
        //a number that indicates how many copies are not checked out.
        private $available;
        //the id of a row in the books table
        private $book_id;
        //the copy id
        private $id;

        function __construct($number_copies, $available, $book_id, $id=null)
        {
            $this->number_copies = $number_copies;
            $this->available = $available;
            $this->book_id = $book_id;
            $this->id = $id;
        }

        //setters
        function setNumberCopies($new_number_copies)
        {
            $this->number_copies = (int) $new_number_copies;
        }

        function setAvailable($new_available)
        {
            $this->available = (int) $new_available;
        }

        function setBookId($new_book_id)
        {
            $this->book_id = (int) $new_book_id;
        }

        //getters
        function getNumberCopies()
        {
            return $this->number_copies;
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

        //CRUD
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO copies (number_copies, available, book_id) VALUES ({$this->getNumberCopies()}, {$this->getAvailable()}, {$this->getBookId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function updateNumberCopies($new_number_copies)
        {
            $GLOBALS['DB']->exec("UPDATE copies SET number_copies = {$new_number_copies} WHERE id={$this->getId()};");
            $this->number_copies = $new_number_copies;
        }

        function updateAvailable($new_available)
        {
            $GLOBALS['DB']->exec("UPDATE copies SET available = {$new_available} WHERE id={$this->getId()};");
            $this->available = $new_available;
        }

        function update($new_number_copies, $new_available)
        {
            $this->updateNumberCopies($new_number_copies);
            $this->updateAvailable($new_available);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies WHERE id = {$this->getId()};");
        }

        static function getAll()
        {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies;");
            $copies = array();
            foreach($returned_copies as $copy){
                $number_copies = $copy['number_copies'];
                $available = $copy['available'];
                $book_id = $copy['book_id'];
                $id = $copy['id'];
                $new_copy = new Copy($number_copies, $available, $book_id, $id);
                array_push($copies, $new_copy);
            }
            return $copies;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies;");
        }

        static function find($search_id)
        {
            $found_copy = null;
            $copies = Copy::getAll();
            foreach($copies as $copy){
                $id = $copy->getId();
                if($id == $search_id){
                    $found_copy = $copy;
                }
            }
            return $found_copy;
        }

        function getBook()
        {
            $returned_book = $GLOBALS['DB']->query("SELECT * FROM books WHERE id = {$this->getBookId()};");
            $book = new Book($returned_book['title'], $returned_book['id']);
            return $book;
        }
    }
?>
