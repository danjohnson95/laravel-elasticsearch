<?php

namespace DesignMyNight\Elasticsearch\Aggregations;

use DateTimeZone;
use DesignMyNight\Elasticseach\Exceptions\MustUseSetDateIntervalException;

class DateHistogram extends Histogram
{
    const YEAR_INTERVAL = 'year';
    const QUARTER_INTERVAL = 'quarter';
    const MONTH_INTERVAL = 'month';
    const WEEK_INTERVAL = 'week';
    const DAY_INTERVAL = 'day';
    const HOUR_INTERVAL = 'hour';
    const MINUTE_INTERVAL = 'minute';
    const SECOND_INTERVAL = 'second';

    /**
     * The interval of the histogram
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-datehistogram-aggregation.html#search-aggregations-bucket-datehistogram-aggregation
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/common-options.html#time-units
     * @return string
     */
    protected $dateInterval;

    /**
     * The format of the date
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-daterange-aggregation.html#date-format-pattern
     * @return string
     */
    protected $dateFormat;

    /**
     * The timezone to use for dates
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-datehistogram-aggregation.html#_time_zone
     * @var DateTimeZone
     */
    protected $timezone;

    /**
     * Gets the type of aggregation, for example date_histogram
     * @return string
     */
    public function getType(): string
    {
        return 'date_histogram';
    }

    /**
     * Sets the interval
     * @param  int $interval
     * @return self
     */
    public function setInterval(int $interval): self
    {
        throw new MustUseSetDateIntervalException;
    }

    /**
     * Sets the date interval
     * @param  string $interval
     * @return self
     */
    public function setDateInterval(string $interval): self
    {
        $this->dateInterval = $interval;

        return $this;
    }

    /**
     * Sets the date format
     * @param  string $format
     * @return self
     */
    public function setDateFormat(string $format): self
    {
        $this->dateFormat = $format;

        return $this;
    }

    /**
     * Sets the timezone
     * @param  DateTimeZone $timezone
     * @return self
     */
    public function setTimezone(DateTimeZone $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Gets the date interval
     * @return string
     */
    public function getDateInterval(): string
    {
        return $this->dateInterval;
    }

    /**
     * Gets the date format
     * @return string
     */
    public function getDateFormat(): string
    {
        return $this->dateFormat;
    }

    /**
     * Gets the timezone location as a string
     * @return string
     */
    public function getTimezone(): string
    {
        return $this->timezone->getName();
    }

    /**
     * Gets the options for this aggregation
     * @return array
     */
    public function getOptions(): array
    {
        return [
            'interval' => $this->getDateInterval(),
            'min_doc_count' => $this->getMinDocCount(),
            'extended_bounds' => $this->getExtendedBounds(),
            'offset' => $this->getOffset(),
            'format' => $this->getDateFormat(),
            'keyed' => $this->getKeyed(),
            'time_zone' => $this->getTimezone()
        ];
    }
}