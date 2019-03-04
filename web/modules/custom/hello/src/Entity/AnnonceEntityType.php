<?php

namespace Drupal\hello\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Annonce type entity.
 *
 * @ConfigEntityType(
 *   id = "annonce_type",
 *   label = @Translation("Annonce type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\hello\AnnonceEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\hello\Form\AnnonceEntityTypeForm",
 *       "edit" = "Drupal\hello\Form\AnnonceEntityTypeForm",
 *       "delete" = "Drupal\hello\Form\AnnonceEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\hello\AnnonceEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "annonce_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "annonce",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/annonce_type/{annonce_type}",
 *     "add-form" = "/admin/structure/annonce_type/add",
 *     "edit-form" = "/admin/structure/annonce_type/{annonce_type}/edit",
 *     "delete-form" = "/admin/structure/annonce_type/{annonce_type}/delete",
 *     "collection" = "/admin/structure/annonce_type"
 *   }
 * )
 */
class AnnonceEntityType extends ConfigEntityBundleBase implements AnnonceEntityTypeInterface {

  /**
   * The Annonce type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Annonce type label.
   *
   * @var string
   */
  protected $label;

}
