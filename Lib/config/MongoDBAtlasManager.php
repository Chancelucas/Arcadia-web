<?php

namespace Lib\config;

use Exception;
use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\Driver\ServerApi;
use MongoDB\BSON\ObjectId;

class MongoDBAtlasManager
{
  private Client $client;
  private Collection $collection;
  private $database;

  public function __construct()
  {
    $databaseName = "arcadia";
    $collectionName = "animals";
    $uri = 'mongodb+srv://Jose:oQQ0GTf25BXKzqkJ@cluster007.ujm8v.mongodb.net/?retryWrites=true&w=majority&tls=true&tlsVersion=1.2&appName=Cluster007&tlsAllowInvalidCertificates=true';

    $apiVersion = new ServerApi(ServerApi::V1);
    $this->client = new Client($uri, [], ['serverApi' => $apiVersion]);

    try {
      $this->client->selectDatabase($databaseName)->command(['ping' => 1]);
      $this->collection = $this->client->selectCollection($databaseName, $collectionName);
      $this->database = $this->client->selectDatabase($databaseName);
    } catch (Exception $e) {
      printf($e->getMessage());
    }
  }

  public function getClient()
  {
    return $this->client;
  }

  public function getDatabase()
  {
    return $this->database;
  }

  public function createDocument(array $data)
  {
    // Ajoutez l'ID relationnel à vos données
    if (isset($data['relational_id'])) {
      $data['relational_id'] = (string) $data['relational_id'];
    }

    $data['click_count'] = 0; // Initialisez le compteur

    try {
      $result = $this->collection->insertOne($data);
      return $result->getInsertedId(); // Retourne l'ObjectId de MongoDB
    } catch (Exception $e) {
      echo "Erreur lors de l'insertion : " . $e->getMessage() . "\n";
    }
  }


  public function readDocuments(array $filter = [], array $options = [])
  {
    try {
      return iterator_to_array($this->collection->find($filter, $options));
    } catch (Exception $e) {
      echo "Erreur lors de la lecture : " . $e->getMessage() . "\n";
    }
  }

  public function updateDocument(array $filter, array $newData)
  {
    try {
      // Effectuer l'update en utilisant les paramètres donnés
      $updateResult = $this->collection->updateOne($filter, $newData);

      // Retourne le nombre de documents modifiés
      return $updateResult->getModifiedCount();
    } catch (Exception $e) {
      echo "Erreur lors de la mise à jour : " . $e->getMessage() . "\n";
    }
  }


  public function incrementClickCount($relationalId)
  {
    $filter = ['relational_id' => (string) $relationalId];
    $update = ['$inc' => ['click_count' => 1]];

    echo "Incrémentation pour ID: $relationalId"; // Log temporaire

    return $this->updateDocument($filter, $update);
  }
}




// <?php

// require 'vendor/autoload.php'; // Assurez-vous que le chemin est correct

// use Lib\config\MongoDBCrud;

// // Configuration de la connexion
// $uri = 'mongodb+srv://wadyx38:B6YstI1tgxi9a5hi@cluster007.ujm8v.mongodb.net/?retryWrites=true&w=majority';
// $databaseName = 'arcadia';
// $collectionName = 'animaux';

// // Création d'une instance de MongoDBCrud
// $crud = new MongoDBCrud($uri, $databaseName, $collectionName);

// // Exemple de CREATE
// $crud->createDocument([
//     'nom' => 'Lion',
//     'type' => 'Animal',
//     'habitat' => 'Savane'
// ]);

// // Exemple de READ
// $documents = $crud->readDocuments();
// foreach ($documents as $doc) {
//     print_r($doc);
// }

// // Exemple de UPDATE
// $crud->updateDocument(['nom' => 'Lion'], ['habitat' => 'Zoo']);

// // Exemple de DELETE
// $crud->deleteDocument(['nom' => 'Lion']);