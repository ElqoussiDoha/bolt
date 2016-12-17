<?php

namespace Bolt\Storage\Query;

use Bolt\Config;

/**
 * This class takes an overall config array as input and parses into values
 * applicable for performing select queries.
 *
 * This takes into account default ordering for ContentTypes.
 */
class QueryConfig
{
    /** @var array|Config */
    protected $config = [];
    /** @var array */
    protected $orderBys = [];


    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->parseContenttypes();
    }

    /**
     * Get the config of all fields for a given content type.
     *
     * @param string $contentType
     *
     * @return array|false
     */
    public function getConfig($contentType)
    {
        if (array_key_exists($contentType, $this->searchableTypes)) {
            return $this->searchableTypes[$contentType];
        }

        return false;
    }

    /**
     * Get the config of one given field for a given content type.
     *
     * @param string $contentType
     * @param string $field
     *
     * @return array|false
     */
    public function getOrder($contentType)
    {
        if (isset($this->orderBys[$contentType])) {
            return $this->orderBys[$contentType];
        }

        return false;
    }

    /**
     * Iterates over the main config and delegates weighting to both
     * searchable columns and searchable taxonomies.
     *
     * @return void
     */
    protected function parseContenttypes()
    {
        $contentTypes = $this->config->get('contenttypes');

        foreach ($contentTypes as $type => $values) {
            if (isset($values['sort'])) {
                $this->orderBys[$type] = $values['sort'];
            }
        }
    }

}
