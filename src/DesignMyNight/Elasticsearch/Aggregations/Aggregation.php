<?php

namespace DesignMyNight\Elasticsearch\Aggregations;

abstract class Aggregation implements AggregationContract
{
    /**
     * The name of the aggregation
     * @var string
     */
    protected $name;

    /**
     * The field you wish to aggregate data from
     * @var string
     */
    protected $field;

    /**
     * Get the name of the aggregation
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the field name to aggregate data from
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * Set the name of the aggregation
     * @param  string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the field to aggregate data from
     * @param  string $field
     * @return self
     */
    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Returns an array of the aggregation which
     * can be interpreted by the query builder
     * @return array
     */
    public function getAggregation(): array
    {
        return [
            'key' => $this->getName(),
            'type' => $this->getType(),
            'args' => $this->getOptions(),
            'aggregations' => $this->getNestedAggregations()
        ];
    }
}
