<?php

namespace Drupal\group_purl\PathProcessor;

use Drupal\Core\PathProcessor\OutboundPathProcessorInterface;
use Drupal\Core\Render\BubbleableMetadata;
use Drupal\purl\ContextHelper;
use Drupal\purl\MatchedModifiers;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GroupPurlContextOutboundPathProcessor.
 */
class GroupPurlContextOutboundPathProcessor implements OutboundPathProcessorInterface {

  /**
   * Drupal\purl\MatchedModifiers definition.
   *
   * @var MatchedModifiers
   */
  protected $purlMatchedModifiers;
  /**
   * Drupal\purl\ContextHelper definition.
   *
   * @var ContextHelper
   */
  protected $purlContextHelper;
  /**
   * Constructs a new GroupPurlContextOutboundPathProcessor object.
   */
  public function __construct(MatchedModifiers $purl_matched_modifiers, ContextHelper $purl_context_helper) {
    $this->purlMatchedModifiers = $purl_matched_modifiers;
    $this->purlContextHelper = $purl_context_helper;
  }

  /**
   * @param string $path
   * @param array $options
   * @param Request|NULL $request
   * @param BubbleableMetadata|NULL $bubbleable_metadata
   *
   * @return string
   *
   * This processor runs after the path alias processor, to strip the modifier
   * out of the path.
   */
  public function processOutbound($path, &$options = [], Request $request = NULL, BubbleableMetadata $bubbleable_metadata = NULL) {
    if (isset($options['purl_context']) && isset($options['purl_context']['modifier'])) {
      $modifier = $options['purl_context']['modifier'];
      if (strpos($path, '/' . $modifier) === 0) {
        $out = substr($path, strlen($modifier));
        return strlen($out) ? $out : '/';
      }
    }
    return $path;
  }
}
