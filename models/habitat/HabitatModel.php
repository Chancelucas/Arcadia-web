<?php

function fetchHabitats(PDO $pdo)
{
    $select_query = "SELECT * FROM Habitat";
    $select_stmt = $pdo->query($select_query);
    $habitats = $select_stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($habitats as &$habitat) {
        $animal_query = "SELECT breed FROM Animal WHERE habitatId = :habitatId";
        $animal_stmt = $pdo->prepare($animal_query);
        $animal_stmt->execute(array(':habitatId' => $habitat['habitatId']));
        $animals = $animal_stmt->fetchAll(PDO::FETCH_ASSOC);
        $habitat['animals'] = $animals;
    }
    unset($habitat);

    return $habitats;
}