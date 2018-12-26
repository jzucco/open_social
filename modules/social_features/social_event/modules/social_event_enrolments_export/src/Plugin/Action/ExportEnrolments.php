<?php

namespace Drupal\social_event_enrolments_export\Plugin\Action;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\social_event\EventEnrollmentInterface;
use Drupal\social_user_export\Plugin\Action\ExportUser;

/**
 * Exports a event enrollment accounts to CSV.
 *
 * @Action(
 *   id = "social_event_enrolments_export_enrollments_action",
 *   label = @Translation("Export the selected enrollments to CSV"),
 *   type = "event_enrollment",
 *   confirm = TRUE,
 *   confirm_form_route_name = "social_event.views_bulk_operations.confirm",
 * )
 */
class ExportEnrolments extends ExportUser {

  /**
   * {@inheritdoc}
   */
  public function executeMultiple(array $entities) {
    /** @var \Drupal\social_event\EventEnrollmentInterface $entity */
    foreach ($entities as &$entity) {
      $entity = $this->getAccount($entity);
    }

    parent::executeMultiple($entities);
  }

  /**
   * {@inheritdoc}
   */
  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    if ($object instanceof EventEnrollmentInterface) {
      $access = $this->getAccount($object)->access('view', $account, TRUE);
    }
    else {
      $access = AccessResult::forbidden();
    }

    return $return_as_object ? $access : $access->isAllowed();
  }

  /**
   * {@inheritdoc}
   */
  public function getFileTemporaryPath() {
    $hash = md5(microtime(TRUE));
    $filename = 'export-enrollments-' . substr($hash, 20, 12) . '.csv';
    return file_directory_temp() . '/' . $filename;
  }

  /**
   * Extract user entity from event enrollment entity.
   *
   * @param \Drupal\social_event\EventEnrollmentInterface $entity
   *   The event enrollment.
   *
   * @return \Drupal\user\UserInterface
   *   The user.
   */
  protected function getAccount(EventEnrollmentInterface $entity) {
    $accounts = $entity->field_account->referencedEntities();
    return reset($accounts);
  }

}
