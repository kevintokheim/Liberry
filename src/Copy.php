<?php
    class Copy
    {
        //a number that indicates how many copies are not checked out.
        private $available;
        //the id of a row in the books table
        private $book_id;
        //the copy id
        private $id;

        function __construct($available = true, $book_id, $id = null)
        {
            $this->available = (bool) $available;
            $this->book_id = $book_id;
            $this->id = $id;
        }


        function setAvailable($new_available)
        {
            $this->available = (bool) $new_available;
        }

        function getAvailable()
        {
            return $this->available;
        }

        function setBookId($new_book_id)
        {
            $this->book_id = (int) $new_book_id;
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
            $GLOBALS['DB']->exec("INSERT INTO copies (available, book_id) VALUES ( '{$this->getAvailable()}', {$this->getBookId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }


        function updateAvailable($new_available)
        {
            $GLOBALS['DB']->exec("UPDATE copies SET available = '{$new_available}' WHERE id={$this->getId()};");
            $this->available = $new_available;
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
                $available = $copy['available'];
                $book_id = $copy['book_id'];
                $id = $copy['id'];
                $new_copy = new Copy($available, $book_id, $id);
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
