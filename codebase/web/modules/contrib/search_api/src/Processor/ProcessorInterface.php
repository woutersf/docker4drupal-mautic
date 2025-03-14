<?php

namespace Drupal\search_api\Processor;

use Drupal\search_api\Datasource\DatasourceInterface;
use Drupal\search_api\IndexInterface;
use Drupal\search_api\Item\ItemInterface;
use Drupal\search_api\Plugin\IndexPluginInterface;
use Drupal\search_api\Query\QueryInterface;
use Drupal\search_api\Query\ResultSetInterface;

/**
 * Provides an interface for Search API processor plugins.
 *
 * Processors can act at many locations in the overall Search API process. These
 * locations are subsumed under the label "Stages" and defined by the STAGE_*
 * constants on this interface. A processor should take care to clearly define
 * for which stages it should run, in addition to implementing the corresponding
 * methods.
 *
 * @see \Drupal\search_api\Annotation\SearchApiProcessor
 * @see \Drupal\search_api\Processor\ProcessorPluginManager
 * @see \Drupal\search_api\Processor\ProcessorPluginBase
 * @see plugin_api
 */
interface ProcessorInterface extends IndexPluginInterface {

  /**
   * Processing stage: add properties.
   *
   * @see \Drupal\search_api\Processor\ProcessorInterface::getPropertyDefinitions()
   * @see \Drupal\search_api\Processor\ProcessorInterface::addFieldValues()
   */
  const STAGE_ADD_PROPERTIES = 'add_properties';

  /**
   * Processing stage: preprocess index.
   *
   * @see \Drupal\search_api\Processor\ProcessorInterface::preIndexSave()
   */
  const STAGE_PRE_INDEX_SAVE = 'pre_index_save';

  /**
   * Processing stage: alter indexed items.
   *
   * @see \Drupal\search_api\Processor\ProcessorInterface::alterIndexedItems()
   */
  const STAGE_ALTER_ITEMS = 'alter_items';

  /**
   * Processing stage: preprocess index.
   *
   * @see \Drupal\search_api\Processor\ProcessorInterface::preprocessIndexItems()
   */
  const STAGE_PREPROCESS_INDEX = 'preprocess_index';

  /**
   * Processing stage: preprocess query.
   *
   * @see \Drupal\search_api\Processor\ProcessorInterface::preprocessSearchQuery()
   */
  const STAGE_PREPROCESS_QUERY = 'preprocess_query';

  /**
   * Processing stage: postprocess query.
   *
   * @see \Drupal\search_api\Processor\ProcessorInterface::postprocessSearchResults()
   */
  const STAGE_POSTPROCESS_QUERY = 'postprocess_query';

  /**
   * Checks whether this processor is applicable for a certain index.
   *
   * This can be used for hiding the processor on the index's "Filters" tab. To
   * avoid confusion, you should only use criteria that are more or less
   * constant, such as the index's datasources. Also, since this is only used
   * for UI purposes, you should not completely rely on this to ensure certain
   * index configurations and at least throw an exception with a descriptive
   * error message if this is violated on runtime.
   *
   * @param \Drupal\search_api\IndexInterface $index
   *   The index to check for.
   *
   * @return bool
   *   TRUE if the processor can run on the given index; FALSE otherwise.
   */
  public static function supportsIndex(IndexInterface $index);

  /**
   * Checks whether this processor implements a particular stage.
   *
   * @param string $stage
   *   The stage to check: one of the self::STAGE_* constants.
   *
   * @return bool
   *   TRUE if the processor runs on this particular stage; FALSE otherwise.
   */
  public function supportsStage($stage);

  /**
   * Returns the weight for a specific processing stage.
   *
   * @param string $stage
   *   The stage whose weight should be returned.
   *
   * @return int
   *   The default weight for the given stage.
   *
   * @see \Drupal\search_api\Processor\ProcessorPluginManager::getProcessingStages()
   */
  public function getWeight($stage);

  /**
   * Sets the weight for a specific processing stage.
   *
   * @param string $stage
   *   The stage whose weight should be set.
   * @param int $weight
   *   The weight for the given stage.
   *
   * @return $this
   *
   * @see \Drupal\search_api\Processor\ProcessorPluginManager::getProcessingStages()
   */
  public function setWeight($stage, $weight);

  /**
   * Determines whether this processor should always be enabled.
   *
   * @return bool
   *   TRUE if this processor should be forced enabled; FALSE otherwise.
   */
  public function isLocked();

  /**
   * Retrieves the properties this processor defines for the given datasource.
   *
   * Property names have to start with a letter or an underscore, followed by
   * any number of letters, numbers and underscores. To avoid collisions, it is
   * also recommended to prefix the property name with the identifier of the
   * module defining the processor.
   *
   * @param \Drupal\search_api\Datasource\DatasourceInterface|null $datasource
   *   (optional) The datasource this set of properties belongs to. If NULL, the
   *   datasource-independent properties should be added (or modified).
   *
   * @return \Drupal\search_api\Processor\ProcessorPropertyInterface[]
   *   An array of property definitions for that datasource, keyed by
   *   property names.
   */
  public function getPropertyDefinitions(?DatasourceInterface $datasource = NULL);

  /**
   * Adds the values of properties defined by this processor to the item.
   *
   * @param \Drupal\search_api\Item\ItemInterface $item
   *   The item whose field values should be added.
   */
  public function addFieldValues(ItemInterface $item);

  /**
   * Preprocesses the search index entity before it is saved.
   *
   * This can, for example, be used to make sure fields needed by this processor
   * are enabled on the index.
   */
  public function preIndexSave();

  /**
   * Alter the items to be indexed.
   *
   * @param \Drupal\search_api\Item\ItemInterface[] $items
   *   An array of items to be indexed, passed by reference.
   */
  public function alterIndexedItems(array &$items);

  /**
   * Preprocesses search items for indexing.
   *
   * @param \Drupal\search_api\Item\ItemInterface[] $items
   *   An array of items to be preprocessed for indexing.
   */
  public function preprocessIndexItems(array $items);

  /**
   * Preprocesses a search query.
   *
   * @param \Drupal\search_api\Query\QueryInterface $query
   *   The object representing the query to be executed.
   */
  public function preprocessSearchQuery(QueryInterface $query);

  /**
   * Postprocess search results before they are returned by the query.
   *
   * If a processor is used for both pre- and post-processing a search query,
   * the same object will be used for both calls (so preserving some data or
   * state locally is possible).
   *
   * @param \Drupal\search_api\Query\ResultSetInterface $results
   *   The search results.
   */
  public function postprocessSearchResults(ResultSetInterface $results);

  /**
   * Determines whether re-indexing is required after a settings change.
   *
   * Enabling a processor, or changing it's settings, isn't always an action
   * that requires an index to be reindexed. This method should return FALSE if
   * re-indexing is not necessary and TRUE if it is.
   *
   * @param array|null $old_settings
   *   NULL if the processor is being enabled. Otherwise, an associative array
   *   containing the old user settings for the processor. The
   *   processor-specific configuration is available under key "settings", while
   *   "weights" contains the respective weights for the different stages which
   *   this processor supports.
   * @param array|null $new_settings
   *   NULL if the processor is being disabled. Otherwise, an associative array
   *   containing the new user settings for the processor. The
   *   processor-specific configuration is available under key "settings", while
   *   "weights" contains the respective weights for the different stages which
   *   this processor supports.
   *
   * @return bool
   *   TRUE if this change means the index should be scheduled for re-indexing;
   *   FALSE otherwise.
   */
  public function requiresReindexing(?array $old_settings = NULL, ?array $new_settings = NULL);

}
