<?php
    require_once "src/Author.php";
    class Book
    {
        private $title;
        private $id;

        function __construct($title, $id=null)
        {
            $this->title = $title;
            $this->id = $id;
        }

        function setTitle($new_title)
        {
            $this->title = $new_title;
        }

        function getTitle()
        {
            return $this->title;
        }

        function getId()
        {
            return $this->id;
        }
        // search for existing book title. if exists, save new book with exixsing book id
        function save()
        {
            $exists = Book::findByTitle($this->getTitle());
            if($exists == 0){
                $GLOBALS['DB']->exec("INSERT INTO books (title) VALUES ('{$this->getTitle()}');");
                $this->id = $GLOBALS['DB']->lastInsertId();
                $GLOBALS['DB']->exec("INSERT INTO copies (available, book_id) VALUES (TRUE, {$this->getId()});");
            }else{
                $GLOBALS['DB']->exec("INSERT INTO books (title) VALUES ('{$this->getTitle()}');");
                $this->id = $exists;
                $GLOBALS['DB']->exec("INSERT INTO copies (available, book_id) VALUES (TRUE, {$exists});");
            }

        }

        function updateTitle($new_title)
        {
            $GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}' WHERE id = {$this->getId()};");
            $this->title = $new_title;
        }

        // function update($new_title)
        // {
        //     $this->updateTitle($new_title);
        // }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM books_authors WHERE book_id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
        }

        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books ORDER BY title;");
            $books = array();
            foreach($returned_books as $book){
                $title = $book['title'];
                $id = $book['id'];
                $new_book = new Book($title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books;");
            $GLOBALS['DB']->exec("DELETE FROM books_authors;");
        }
        // returns a found book id#

        static function findByTitle($title_to_search)
        {
            $lower_search_title = strtolower($title_to_search);
            $all_books = Book::getAll();
            foreach($all_books as $book){
                $title = strtolower($book->getTitle());
                if($lower_search_title == $title){
                    return $book->getId();
                }else{
                    return 0;
                }
            }
        }

        static function findByAuthor($author_to_search)
        {
            $lower_search_author = strtolower($author_to_search);
            $found_books = [];
            $all_authors = Author::getAll();
            foreach($all_authors as $author){
                $author_name = strtolower($author->getName());
                if($author_name == $lower_search_author){
                    $found_books = $author->getBooks();
                }else{
                    return 0;
                }

            }
            return $found_books;
        }


        static function find($search_id)
        {
            $found_book = null;
            $books = Book::getAll();
            foreach($books as $book){
                $book_id = $book->getId();
                if($book_id == $search_id){
                    $found_book = $book;
                }
            }
            return $found_book;
        }

        function addAuthor($author)
        {
            $GLOBALS['DB']->exec("INSERT INTO books_authors (book_id, author_id) VALUES ({$this->getId()}, {$author->getId()});");
        }

        function getAuthors()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT authors.* FROM
            books JOIN books_authors ON (books.id = books_authors.book_id)
                  JOIN authors ON (books_authors.author_id = authors.id)
            WHERE books.id = {$this->getId()};");

            $authors = [];
            foreach($returned_authors as $author){
                $name = $author['name'];
                $id = $author['id'];
                $new_author = new Author($name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        function getNumberOfCopies()
        {
            $returned_copies = ($GLOBALS['DB']->query("SELECT * FROM copies WHERE book_id={$this->getId()};"));
            $num_of_copies = 0;
            foreach($returned_copies as $copy){
                ++$num_of_copies;
            }
            return $num_of_copies;
        }
    }
?>
