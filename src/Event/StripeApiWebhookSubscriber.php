<?php

namespace Drupal\provider_stripe\Event;

use Drupal\Component\Serialization\Json;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class StripeApiWebhookSubscriber.
 *
 * Provides the webhook subscriber functionality.
 */
class StripeApiWebhookSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events['provider_stripe.webhook'][] = ['onIncomingWebhook'];
    return $events;
  }

  /**
   * Process an incoming webhook.
   *
   * @param \Drupal\provider_stripe\Event\StripeApiWebhookEvent $event
   *   Logs an incoming webhook of the setting is on.
   */
  public function onIncomingWebhook(StripeApiWebhookEvent $event) {
    $config = \Drupal::config('provider_stripe.settings');
    if ($config->get('log_webhooks')) {
      \Drupal::logger('provider_stripe')
        ->info('Processed webhook: @name<br /><br />Data: @data', [
          '@name' => $event->type,
          '@data' => Json::encode($event->data),
        ]);
    }
  }

}
