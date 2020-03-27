<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>

<body>
    <h1>Inloggen</h1>
    <?php
    function select($query)
    {
        $host = 'localhost';
        $db   = 'netland';
        $user = 'root';
        $pass = 'HywtGBNiwu823@';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $formatResult = array();

        $rawResult = $pdo->query($query);
        while ($row = $rawResult->fetch()) {
            $rowResult = array();

            foreach ($row as $collum => $value) {
                $rowResult[$collum] = $value;
            }

            $formatResult[] = $rowResult;
        }

        return $formatResult;
    }

    function redirect($url)
    {
        ob_start();
        header('Location: ' . $url);
        ob_end_flush();
        die();
    }

    if (!isset($_POST) || !isset($_POST['username']) || !isset($_POST['password'])) {
        redirect('login.php');
    }

    $result = select('SELECT * FROM netland.login WHERE username = "' . $_POST['username'] . '"');

    var_dump($result);

    switch (count($result)) {
        case 0:
            setcookie("error", "Verkeerde username", time() + 36, "/");
            redirect("login.php");
            break;
        case 1:
            var_dump('er is een gebruiker');
            if ($_POST['password'] === $result[0]['wachtwoord']) {
                setcookie("loggedInUser", $result[0]['id'], time() + 3600, "/");
                redirect("index.php");
            } else {
                setcookie("error", "Gerard de kat heeft ver gezocht, maar kon dit wachtwoord nergens vinden!", time() + 36, "/");
                redirect("login.php");
            }
            break;
        default:
            setcookie("error", "Oops! Er is een onbekende fout opgetreden", time() + 36, "/");
            redirect("login.php");
            break;
    }
    ?>

</body>

</html>