<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    //require_once __DIR__."/../src/Patron.php";
    require_once __DIR__."/../src/Author.php";


    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    // HOME PAGE - DISPLAYS ADMIN LINK AND PATRON LINK
    $app->get('/', function() use ($app){
        return $app['twig']->render('index.html.twig');
    });

    // ADMIN PAGE - DISPLAYS BOOK CATALOG
    $app->get("/main_admin", function() use ($app){
        $books = Book::getAll();
        $authors = Author::getAll();
        return $app['twig']->render("main_admin.html.twig", array('books' => $books, 'authors' => $authors));
    });

    $app->get("/book/{id}", function($id) use($app){
        $book = Book::find($id);
        $book_authors = $book->getAuthors();
        return $app['twig']->render("book.html.twig", array('book' => $book, 'authors' => $book_authors));
        });

        $app->post("/book_added", function() use ($app){
            // create new book from user entry "add book"
            $title = $_POST['title'];
            $new_book = new Book($title);
            $new_book->save();
            // create new author from user entry "add book"
            // possibly check that the author is already in the database - NOT NOW
            $name = $_POST['name'];
            $new_author = new Author($name);
            $new_author->save();
            $new_book->addAuthor($new_author);
            $books = Book::getAll();
            $authors = Author::getAll();
            //var_dump($authors);
            return $app['twig']->render("main_admin.html.twig", array('books' => $books, 'authors' => $authors));
        });

        $app->patch("/book/{id}/update_title", function($id) use ($app){
            $new_title = $_POST['title'];
            $book_to_update = Book::find($id);
            $book_to_update->updateTitle($new_title);
            $book_authors = $book_to_update->getAuthors();
            return $app['twig']->render("book.html.twig", array('book' => $book_to_update, 'authors' => $book_authors));
        });

        $app->post("/book/{id}/add_author", function($id) use ($app){
            $author_to_add = new Author($_POST['name']);
            $author_to_add->save();
            var_dump(Author::find($author_to_add->getId()));
            $book = Book::find($id);
            $book->addAuthor($author_to_add);
            $book_authors = $book->getAuthors();
            return $app['twig']->render("book.html.twig", array('book' => $book, 'authors' => $book_authors));
        });

        $app->get("/search_book", function() use ($app){
            $title = $_GET['title'];
            $found_book_id = Book::findByTitle($title);
            $found_book = Book::find($found_book_id);
            $book_authors = $found_book->getAuthors();
            return $app['twig']->render("book.html.twig", array( 'book' => $found_book, 'authors' => $book_authors));
        });



    return $app;
?>
