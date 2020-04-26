<?php
session_start();
class Index
{
    public $username = [
        [
            "username" => "AlbertoMathew_Kelompok56@gmail.com",
            "password" => "12345",
            "role" => "superadmin"
        ],
        [
            "username" => "AnggilianaNur_Kelompok56@gmail.com",
            "password" => "12345",
            "role" => "user"
        ]
    ];

    public $history = [
        [
            "username" => "AlbertoMathew_Kelompok56@gmail.com",
            "peminjaman_buku" => ["Fisika Dasar", "Dasar Komputer dan Pemrograman"],
            "tanggal_pinjam" => "24-04-2020"
        ],
        [
            "username" => "AnggilianaNur_Kelompok56@gmail.com",
            "peminjaman_buku" => ["Kalkulus", "Dasar Komputer dan Pemrograman", "Konsep Jaringan Komputer"],
            "tanggal_pinjam" => "24-04-2020"
        ]
    ];

    function __construct($username, $password)
    {
        if ($username != NULL) {
            if ($this->searchForUsername($username) !== "null") {
                if ($this->searchForPassword($password) !== "null") {
                    $kunci = $this->searchForUsername($username);
                    $username = $this->username[$kunci]['username'];
                    $role = $this->username[$kunci]['role'];
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $role;
                } else {
                    echo "PASSWORD SALAH";
                }
            } else {
                echo "USERNAME TIDAK ADA";
            }
        } else {
        }
    }

    function searchForUsername($username)
    {
        $array = $this->username;
        foreach ($array as $key => $val) {
            if ($val['username'] === $username) {
                return $key;
            }
        }
        return null;
    }

    function searchForPassword($password)
    {
        $array = $this->username;
        foreach ($array as $key => $val) {
            if ($val['password'] === $password) {
                return $key;
            }
        }
        return null;
    }

    function searchForPeminjaman($username)
    {
        $array = $this->history;
        foreach ($array as $key => $val) {
            if ($val['username'] === $username) {
                return $key;
            }
        }
        return null;
    }

    // function listpeminjaman($key)
    // {
    //     while ($this->username[$key]) {
    //         $rows[] = $row;
    //     }
    //     return $rows;
    // }
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $class = new Index($username, $password);
}

if (isset($_GET['logout'])) {
    session_destroy();
    session_unset();
    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUGAS MODUL 5</title>
</head>

<body>
    <?php if (isset($_SESSION['username'])) : ?>
        <form action="" method="get">
            <button type="submit" name="logout">Logout</button>
        </form>
        <p>Welcome <?= $_SESSION['role'] ?>, Logged in as username : <?= $_SESSION['username'] ?></p>
        <p>Username <?= $_SESSION['username'] ?> Meminjam : <br>
            <?php
            $class = new Index(NULL, NULL);
            $key = $class->searchForPeminjaman($_SESSION['username']);
            // var_dump($this->listpeminjaman($key));
            $buku = $class->history[$key]["peminjaman_buku"];
            foreach ($buku as $bukus) {
                echo $bukus . "<br>";
            }
            echo "Tanggal pinjam : " . $class->history[$key]["tanggal_pinjam"];
            ?>
        </p>
    <?php else : ?>
        <form action="" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username"><br><br>
            <label for="password">Password</label>
            <input type="password" id="password" name="password"><br><br>
            <button type="submit" name="submit">Login</button>
        </form>
    <?php endif; ?>
</body>

</html>