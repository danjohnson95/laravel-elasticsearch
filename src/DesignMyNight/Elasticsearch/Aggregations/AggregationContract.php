<?php

namespace DesignMyNight\Elasticsearch\Aggregations;

interface AggregationContract
{
    /**
     * Gets the type of aggregation, for example date_histogram
     * @return string
     */
    public function getType(): string;

    /**
     * Gets the options for this aggregation
     * @return array
     */
    public function getOptions(): array;
}