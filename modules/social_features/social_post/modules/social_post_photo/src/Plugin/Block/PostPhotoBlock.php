<?php

namespace Drupal\social_post_photo\Plugin\Block;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\social_post\Plugin\Block\PostBlock;

/**
 * Provides a 'PostPhotoBlock' block.
 *
 * @Block(
 *   id = "post_photo_block",
 *   admin_label = @Translation("Post photo block"),
 * )
 */
class PostPhotoBlock extends PostBlock {

  /**
   * {@inheritdoc}
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    EntityTypeManagerInterface $entity_type_manager,
    AccountProxyInterface $current_user,
    FormBuilderInterface $form_builder,
    ModuleHandlerInterface $module_handler
  ) {
    parent::__construct(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $entity_type_manager,
      $current_user,
      $form_builder,
      $module_handler
    );

    // Override the bundle type.
    $this->bundle = 'photo';
  }

}
