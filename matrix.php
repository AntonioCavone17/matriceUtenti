<?php
    
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "movies";

    function build_matrix(){
        $matrix = array();
        $users = array(); // prendiamo tutti gli utenti -> QUERY
        $movies = array(); // prendiamo tutti i film -> QUERY

        $conn = mysqli_connect($hostname, $username, $password, $database);
        $query = "SELECT * FROM user;";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        while($row){
            $users[] = $row;
        }

        $query = "SELECT * FROM movie;";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        while($row){
            $movies[] = $row['id'];
        }

        foreach($users as $user){
        // Qui andiamo a creare la riga per ogni utente
            $user_row = array_fill_keys($movies, 0); // creare un array di zeri per tutti i film

            $watched_movies = array();

            $query = "SELECT * FROM movie_user WHERE user_id = " . $user['id'];
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            while($row){
                if(in_array($row['movie_id'], $movies)) { 
                    $user_row[$row['movie_id']] = 1;
                }
            }
            array_push($matrix, $user_row);
        }

        return $matrix;

    }

    echo "<pre>";
    print_r(build_matrix());
    echo "</pre>";

?>