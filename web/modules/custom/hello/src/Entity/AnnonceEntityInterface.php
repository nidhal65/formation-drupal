<?php

namespace Drupal\hello\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Annonce entities.
 *
 * @ingroup hello
 */
interface AnnonceEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Annonce name.
   *
   * @return string
   *   Name of the Annonce.
   */
  public function getName();

  /**
   * Sets the Annonce name.
   *
   * @param string $name
   *   The Annonce name.
   *
   * @return \Drupal\hello\Entity\AnnonceEntityInterface
   *   The called Annonce entity.
   */
  public function setName($name);

  /**
   * Gets the Annonce creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Annonce.
   */
  public function getCreatedTime();

  /**
   * Sets the Annonce creation timestamp.
   *
   * @param int $timestamp
   *   The Annonce creation timestamp.
   *
   * @return \Drupal\hello\Entity\AnnonceEntityInterface
   *   The called Annonce entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Annonce published status indicator.
   *
   * Unpublished Annonce are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Annonce is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Annonce.
   *
   * @param bool $published
   *   TRUE to set this Annonce to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\hello\Entity\AnnonceEntityInterface
   *   The called Annonce entity.
   */
  public function setPublished($published);

}
