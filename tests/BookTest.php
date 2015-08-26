<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";
    // require_once "src/Author.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
            //Author::deleteAll();
        }

        function test_getTitle()
        {
            //Arrange
            $title = "Adventures on Mars";
            $test_book = new Book($title);

            //Act
            $result = $test_book->getTitle();

            //Assert
            $this->assertEquals($title, $result);
        }

        function test_getId()
        {
            //Arrange
            $title = "Adventures on Mars";
            $id = 1;
            $test_book = new Book($title, $id);

            //Act
            $result = $test_book->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_setTitle()
        {
            //Arrange
            $title = "Adventures on Mars";
            $test_book = new Book($title);

            //Act
            $title2 = "Adventures on Mars 2 Adventure Harder";
            $test_book->setTitle($title2);
            $result = $test_book->getTitle();

            //Assert
            $this->assertEquals($title2, $result);
        }

        function test_save()
        {
            //Arrange
            $title = "Adventures on Mars";
            $test_book = new Book($title);
            $test_book->save();

            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals($test_book, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $title = "Adventures on Mars";
            $test_book = new Book($title);
            $test_book->save();

            $title2 = "Adventures on Mars 2 Adventure Harder";
            $test_book2 = new Book($title2);
            $test_book2->save();

            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $title = "Adventures on Mars";
            $test_book = new Book($title);
            $test_book->save();

            $title2 = "Adventures on Mars 2 Adventure Harder";
            $test_book2 = new Book($title2);
            $test_book2->save();

            //Act
            Book::deleteAll();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([], $result);
        }
    }
?>
