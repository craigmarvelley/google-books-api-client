<?php

namespace CGM\Books\Metadata;

/**
 * A service that retrives book metadata
 */
interface Service
{
    public function getMetadataForQuery(Query $query);
}