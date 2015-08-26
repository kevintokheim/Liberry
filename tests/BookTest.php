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

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
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

        function test_find()
        {
            //Arrange
            $title = "Adventures on Mars";
            $test_book = new Book($title);
            $test_book->save();

            $title2 = "Adventures on Mars 2 Adventure Harder";
            $test_book2 = new Book($title2);
            $test_book2->save();

            //Act
            $result = Book::find($test_book->getId());

            //Assert
            $this->assertEquals($test_book, $result);
        }

        function test_addAuthor()
        {
            //Arrange
            $title = "Adventures on Mars";
            $test_book = new Book($title);
            $test_book->save();

            $name = "David Foster Wallace";
            $test_author = new Author($name);
            $test_author->save();

            //Act
            $test_book->addAuthor($test_author);
            $result = $test_book->getAuthors();

            //Assert
            $this->assertEquals([$test_author], $result);
        }

        function test_updateTitle()
        {
            //Arrange
            $title = "Revenge of the Martians";
            $test_book = new Book($title);
            $test_book->save();

            $title2 = "Star Wars";
            $test_book2 = new Book($title2);
            $test_book2->save();

            //Act
            $test_book2->updateTitle($title);
            $result = Book::find($test_book2->getId());

            //Assert
            $this->assertEquals($test_book->getTitle(), $result->getTitle());
        }

        function test_update()
        {
            //Arrange
            $title = "The Martian";
            $test_book = new Book($title);
            $test_book->save();

            $title2 = "Star Wars";
            $test_book->update($title2);

            //Act
            $id = $test_book->getId();
            $test_book2 = new Book($title2, $id);
            $result = Book::find($id);

            //Assert
            $this->assertEquals($test_book2, $result);
        }
    }
?>
