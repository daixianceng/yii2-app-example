<?php
namespace common\rest;

/**
 * DataInterface is the interface that should be implemented by classes who should be sent to the user.
 *
 * @author Cosmo<daixianceng@gmail.com>
 */
interface DataInterface
{
    const STATUS_SUCCESS = 'success';
    const STATUS_FAIL = 'fail';
    const STATUS_ERROR = 'error';
}
