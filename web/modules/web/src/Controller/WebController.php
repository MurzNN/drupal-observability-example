<?php

namespace Drupal\web\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Web routes.
 */
class WebController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $this->openTelemetryTracer = \Drupal::service('opentelemetry.tracer');
    $tracer = $this->openTelemetryTracer->getTracer();
    $mainSpan = $tracer->spanBuilder('My custom operation')->startSpan();

    // Make an external API call.
    $apiCallSpan = $tracer->spanBuilder("Coindesk API call")->startSpan();
    $data = json_decode(
      file_get_contents('https://api.coindesk.com/v1/bpi/currentprice.json')
    );
    $apiCallSpan->end();

    // Set attributes and put an event to the main span.
    $bots = 3;
    $mainSpan->setAttribute('Bitcoin value', $data->bpi->USD->rate_float);
    $mainSpan->addEvent('Starting bots tuning', ['bots available' => $bots]);

    for ($i = 1; $i <= $bots; $i++) {
      $innerSpan = $tracer->spanBuilder("Tuning bot $i")->startSpan();
      // Do some internal business logic.
      usleep(rand(200000, 500000));
      $raised[$i] = rand(0, 100);
      $innerSpan->addEvent("Bot $i raised money!", ['amount' => $raised[$i]]);
      usleep(rand(100000, 200000));
      $innerSpan->end();
    }

    // Do some more stuff and finalize the main span.
    usleep(rand(200000, 500000));
    $mainSpan->addEvent('We got richer!', ['raised' => array_sum($raised)]);
    $mainSpan->setAttribute('raised_details', $raised);
    $mainSpan->end();

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
