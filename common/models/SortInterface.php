<?php
namespace common\models;

/**
 * SortInterface is the interface that should be implemented by a class providing sort field.
 *
 * @author Cosmo <daixianceng@gmail.com>
 */
interface SortInterface
{
    /**
     * The sort field name of the model
     * @return string
     */
    public static function sortField();
}