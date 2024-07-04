<?php

namespace Source\Models\reviews;

use Source\Models\MainModel;

/**
 * Reviews Object
 * @var 
 */

class ReviewsModel extends MainModel
{
  protected $id;
  protected $pseudo;
  protected $review;
  protected $status;

  /**
   * Init Habitat model on table Habitat
   */
  public function __construct()
  {
    $this->table = 'Review';
  }

  /**
   * Find one reviews by pseudo
   */
  public function findOneByPseudo(string $pseudo)
  {
    $reviewsData = $this->request("SELECT * FROM {$this->table} WHERE pseudo = ?", [$pseudo])->fetch();

    if ($reviewsData === false) {
      return null;
    }

    return $this;
  }

  /**
   * Get all habitat on table habitat
   */
  public function getAll()
  {
    $query = $this->request("SELECT * FROM {$this->table}");
    $allData = $query->fetchAll();

    $models = [];
    foreach ($allData as $data) {
      $self = new self();
      $self->hydrate($data);
      array_push($models, $self);
    }
    return $models;
  }

  public function getAllReviews()
  {
    $reviews = $this->getAll();

    $allReviews = [];
    foreach ($reviews as $reviewsModel) {
      $review = new \stdClass();
      $review->id = $reviewsModel->getId();
      $review->pseudo = $reviewsModel->getPseudo();
      $review->review = $reviewsModel->getReview();
      $review->status = $reviewsModel->getStatus();

      $allReviews[] = $review;
    }

    return $allReviews;
  }


  /**
   * Function for create one habitat
   */
  public function createReviews()
  {
    return $this->create();
  }

  /**
   * Update one review on table review
   */
  public function update()
  {
    $sql = "UPDATE {$this->table} SET pseudo = :pseudo, review = :review, status = :status WHERE id = :id";
    $values = [
      ':pseudo' => $this->pseudo,
      ':review' => $this->review,
      ':status' => $this->status,
      ':id' => $this->id,
    ];

    return $this->request($sql, $values);
  }


  /////////////////// GETTER and SETTER /////////////////////



  /**
   * Get the value of id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set the value of id
   *
   * @return  self
   */
  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }

  /**
   * Get the value of pseudo
   */
  public function getPseudo()
  {
    return $this->pseudo;
  }

  /**
   * Set the value of pseudo
   *
   * @return  self
   */
  public function setPseudo($pseudo)
  {
    $this->pseudo = $pseudo;

    return $this;
  }

  /**
   * Get the value of reviews
   */
  public function getReview()
  {
    return $this->review;
  }

  /**
   * Set the value of reviews
   *
   * @return  self
   */
  public function setReview($review)
  {
    $this->review = $review;

    return $this;
  }

  /**
   * Get the value of status
   */
  public function getStatus()
  {
    return $this->status;
  }

  /**
   * Set the value of status
   *
   * @return  self
   */
  public function setStatus($status)
  {
    $this->status = $status;

    return $this;
  }
}
