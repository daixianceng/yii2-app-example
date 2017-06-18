<?php
namespace common\models;

/**
 * StatusInterface is the interface that should be implemented by a class providing status information.
 *
 * @author Cosmo <daixianceng@gmail.com>
 */
interface StatusInterface
{
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    /**
     * Enable the model.
     * @see disable()
     */
    public function enable();

    /**
     * Disable the model.
     * @see enable()
     */
    public function disable();

    /**
     * @return boolean whether the model is enabled.
     * @see enable()
     * @see disable()
     */
    public function getIsEnabled();
}