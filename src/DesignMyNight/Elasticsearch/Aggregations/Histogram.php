<?php

namespace DesignMyNight\Elasticsearch\Aggregations;

use DesignMyNight\Elasticsearch\Exceptions\IntervalNotSpecifiedException;

class Histogram extends Aggregation
{
    /**
     * Offset of bucket boundaries
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-histogram-aggregation.html#_offset_2
     * @var int
     */
    protected $offset;

    /**
     * The minimum for the extended bounds
     * @var int
     */
    protected $extendedBoundsMin;

    /**
     * The maximum for the extended bounds
     * @var int
     */
    protected $extendedBoundsMax;

    /**
     * The minimum number of documents required to fill a bucket
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-histogram-aggregation.html#_minimum_document_count
     * @var int
     */
    protected $minDocCount;

    /**
     * The interval of the histogram
     * @return int
     */
    protected $interval;

    /**
     * Whether or not the response should contain buckets keyed by the bucket
     * keys
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-histogram-aggregation.html#_response_format_2
     * @var bool
     */
    protected $keyed;

    /**
     * The value how documents with a missing value should be treated
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-histogram-aggregation.html#_missing_value_11
     * @var int
     */
    protected $missingValue;

    /**
     * Gets the type of aggregation, for example date_histogram
     * @return string
     */
    public function getType(): string
    {
        return 'histogram';
    }

    /**
     * Sets the minimum document count for this aggregation
     * @param  int $minDocCount
     * @return self
     */
    public function setMinDocCount(int $minDocCount): self
    {
        $this->minDocCount = $minDocCount;

        return $this;
    }

    /**
     * Sets the interval
     * @param  int $interval
     * @return self
     */
    public function setInterval(int $interval): self
    {
        $this->interval = $interval;

        return $this;
    }

    /**
     * Sets the extended bounds. Accepts an array containing two elements;
     * the former being the minimum and the latter being the maximum
     * @param  array $minMax
     * @return self
     */
    public function setExtendedBounds(array $minMax): self
    {
        list($min, $max) = $minMax;

        $this->extendedBoundsMin = $min;
        $this->extendedBoundsMax = $max;

        return $this;
    }

    /**
     * Sets the offset
     * @param  int $offset
     * @return self
     */
    public function setOffset(int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * Sets whether or not the response should be keyed
     * @param  bool $keyed
     * @return self
     */
    public function setKeyed(bool $keyed): self
    {
        $this->keyed = $keyed;

        return $this;
    }

    /**
     * Sets the value for documents with a missing value
     * @param  int $value
     * @return self
     */
    public function setMissingValue(int $value): self
    {
        $this->missingValue = $value;

        return $this;
    }

    /**
     * Gets the minimum document count
     * @return int
     */
    public function getMinDocCount(): int
    {
        return $this->minDocCount;
    }

    /**
     * Gets the interval
     * @throws DesignMyNight\Elasticsearch\Exceptions\IntervalNotSpecified
     * @return int
     */
    public function getInterval(): int
    {
        if (!$this->interval) {
            throw new IntervalNotSpecifiedException;
        }

        return $this->interval;
    }

    /**
     * Gets the extended bounds
     * @return array
     */
    public function getExtendedBounds(): array
    {
        return [
            'min' => $this->extendedBoundsMin,
            'max' => $this->extendedBoundsMax
        ];
    }

    /**
     * Gets the offset
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * Gets whether or not the response should be keyed
     * @return bool
     */
    public function getKeyed(): bool
    {
        return $this->keyed;
    }

    /**
     * Gets the value to use for documents with a missing value
     * @return int
     */
    public function getMissingValue(): int
    {
        return $this->missingValue;
    }

    /**
     * Gets the options for this aggregation
     * @return array
     */
    public function getOptions(): array
    {
        return [
            'interval' => $this->getInterval(),
            'min_doc_count' => $this->getMinDocCount(),
            'extended_bounds' => $this->getExtendedBounds(),
            'offset' => $this->getOffset(),
            'keyed' => $this->getKeyed()
        ];
    }
}
