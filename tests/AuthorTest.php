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
            $test_author2 = new Author($name);
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
    }












?>
