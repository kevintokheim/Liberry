<?php
    class Author
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $exists = Author::findByAuthorName($this->getName());
            var_dump($this->getName());
            var_dump($exists);
            if($exists == 0 ){
                $GLOBALS['DB']->exec("INSERT INTO authors (name) VALUES ('{$this->getName()}');");
                $this->id = $GLOBALS['DB']->lastInsertId();
                //var_dump($this->id);
            }
        }

        function updateName($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE authors SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->name = $new_name;
        }

        function update($new_name)
        {
            $this->updateName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM books_authors WHERE author_id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM authors WHERE id={$this->getId()};");
        }

        static function getAll()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
            $authors = array();
            foreach ($returned_authors as $author) {
                $name = $author['name'];
                $id = $author['id'];
                $new_author = new Author($name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors;");
            $GLOBALS['DB']->exec("DELETE FROM books_authors;");
        }


        static function find($search_id)
        {
            $found_author = null;
            $authors = Author::getAll();
            foreach($authors as $author) {
                $author_id = $author->getId();
                if ($author_id == $search_id){
                    $found_author = $author;
                }
            }
            return $found_author;
        }

        function addBook($book)
        {
            $GLOBALS['DB']->exec("INSERT INTO books_authors (book_id, author_id) VALUES  ({$book->getId()}, {$this->getId()});");
        }

        function getBooks()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT books.* FROM
            authors JOIN books_authors ON (authors.id = books_authors.author_id)
                    JOIN books ON (books_authors.book_id = books.id)
            WHERE authors.id = {$this->getId()};");

            $books = [];

            foreach($returned_books as $book) {
                $title = $book['title'];
                $id = $book['id'];
                $new_book = new Book($title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

/////////////////////////////////////////////////////////////
/////////////// Change to  name / book //////////////////////
/////////////////////////////////////////////////////////////

        // // return the Id# of found author
        static function findByAuthorName($name_to_search)
        {
            $author_to_find = null;
            $lower_search_name = strtolower($name_to_search);
            $all_authors = Author::getAll();
            //var_dump($all_authors);
            foreach($all_authors as $author){
                    //var_dump($author->getId());
                $name = strtolower($author->getName());
                //var_dump($name);
                if($lower_search_name == $name){
                    $author_to_find = $author->getId();
                    return $author_to_find;
                }
            }
        }
        // //return
        // static function findByBook($title_to_search)
        // {
        //     $lower_search_title = strtolower($title_to_search);
        //     $found_books = [];
        //     $all_books = Book::getAll();
        //     foreach($all_books as $book){
        //         $book_name = strtolower($book->getName());
        //         // var_dump($book_name);
        //         // var_dump($lower_search_book);
        //         if($book_name == $lower_search_title){
        //             $books_by_title = $book->getBooks();
        //             //var_dump($books_by_title);
        //             foreach($books_by_title as $book){
        //                 array_push($found_books, $book);
        //             }
        //         }else{
        //             return 0;
        //         }
        //
        //     }
        //     return $found_books;
        // }




    }







?>
