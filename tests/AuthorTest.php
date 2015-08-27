<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";
    require_once "src/Author.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
        }

        function test_setName()
        {
            //Arrange
            $name = "Kevin";
            $test_author = new Author($name);

            //Act
            $name2 = "Ian";
            $test_author->setName($name2);
            $result = $test_author->getName();

            //Assert
            $this->assertEquals($name2, $result);
        }

        function test_getName()
        {
            //Arrange
            $name = "Mark Twain";
            $test_author = new Author($name);

            //Act
            $result = $test_author->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Andy Weir";
            $id = 1;
            $test_author = new Author($name, $id);

            //Act
            $result = $test_author->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $name = "Roberto Bolano";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Roberto Bolano";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals($test_author, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "David Foster Wallace";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Stephen King";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "David Foster Wallace";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Stephen King";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //Act
            Author::deleteAll();
            $result = Author::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Stephen King";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Clive Barker";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //Act
            $result = Author::find($test_author->getId());

            //Assert
            $this->assertEquals($test_author, $result);
        }

        function test_addBook()
        {
            //Arrange
            $name = "David Foster Wallace";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Roberto Bolano";
            $test_author2 = new Author($name2);
            $test_author2->save();

            $title = "Infinite Jest";
            $test_book = new Book($title);
            $test_book->save();

            //Act
            $test_author->addBook($test_book);
            $result = $test_author->getBooks();

            //Assert
            $this->assertEquals([$test_book], $result);
        }

        function test_updateName()
        {
            //Arrange
            $name = "David Foster Wallace";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Roberto Bolano";
            $test_author->updateName($name2);

            $id = $test_author->getId();
            $test_author2 = new Author($name2, $id);

            //Act
            $result = Author::find($id);

            //Assert
            $this->assertEquals($test_author2, $result);
        }

        function test_update()
        {
            //Arrange
            $name = "David Foster Wallace";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Roberto Bolano";
            $test_author->updateName($name2);

            $id = $test_author->getId();
            $test_author2 = new Author($name2, $id);

            //Act
            $result = Author::find($id);

            //Assert
            $this->assertEquals($test_author2, $result);
        }

        function test_delete()
        {
            //Arrange
            $name = "Stephen King";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Clive Barker";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //Act
            $test_author->delete();
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author2], $result);
        }

        function test_getBooks()
        {
            $name = "Roberto Bolano";
            $test_author = new Author($name);
            $test_author->save();

            $title = "Infinite Jest";
            $test_book = new Book($title);
            $test_book->save();

            $title2 = "Infinite Jest";
            $test_book2 = new Book($title2);
            $test_book2->save();

            //Act
            $test_author->addBook($test_book2);
            $test_author->addBook($test_book);
            $result = $test_author->getBooks();

            //Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }
        /////////////////////////////////////////////////////////////
        /////////////// Change to  name / book //////////////////////
        /////////////////////////////////////////////////////////////

        // function test_findByBook()
        // {
        //     //Arrange
        //     $title = "Adventures on Mars";
        //     $test_book = new Book($title);
        //     $test_book->save();
        //
        //     $title2 = "Mars";
        //     $test_book2 = new Book($title);
        //     $test_book->save();
        //
        //     // $title2 = "Mars";
        //     // $test_book2 = new Book($title2);
        //     // $test_book2->save();
        //
        //     //Act
        //     $result = Book::findByBook("Adventures on Mars");
        //
        //     //Assert
        //     $this->assertEquals($test_book->getId(), $result);
        // }
        function test_findByAuthorName()
        {
            //Arrange
            $title = "Adventures on Mars";
            $test_book = new Book($title);
            $test_book->save();

            $name = "David Foster Wallace";
            $test_author = new Author($name);
            $test_author->save();

            $test_author->addBook($test_book);

            //Act
            $result = Author::findByAuthorName("David Foster Wallace");

            //Assert
            $this->assertEquals($test_author->getId(), $result);
        }


    }












?>
