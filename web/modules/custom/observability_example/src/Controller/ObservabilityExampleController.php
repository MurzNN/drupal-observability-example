<?php

namespace Drupal\observability_example\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Returns responses for Web routes.
 */
class ObservabilityExampleController extends ControllerBase {

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
    $botsCount = 3;
    $mainSpan->setAttribute('Bitcoin value', $data->bpi->USD->rate_float);
    $mainSpan->addEvent('Starting bots tuning', ['bots available' => $botsCount]);

    for ($i = 1; $i <= $botsCount; $i++) {
      $innerSpan = $tracer->spanBuilder("Tuning bot $i")->startSpan();
      // Do some internal business logic.
      usleep(rand(200000, 500000));
      $raised[$i] = rand(0, 100);

      // Add a random exception for 20% of calls.
      if (rand(1, 100) <= 20) {
        throw new \Exception("Bot $i failed!");
      }

      $innerSpan->addEvent("Bot $i raised money!", ['amount' => $raised[$i]]);
      usleep(rand(100000, 200000));
      $innerSpan->end();
    }

    // Do some more stuff and finalize the main span.
    usleep(rand(200000, 500000));
    $mainSpan->addEvent('We got richer!', ['raised' => array_sum($raised)]);
    $mainSpan->setAttribute('raised_details', $raised);
    $mainSpan->end();

    $data = [
      'status' => 'ok',
    ];
    $response = new JsonResponse($data);
    return $response;
  }

}
