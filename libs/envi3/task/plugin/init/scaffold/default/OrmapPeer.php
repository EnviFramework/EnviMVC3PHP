<?php
/*%%model_name_space_use%%*/

/**
 * PHP versions 5
 *
 *
 * @category   %%project_category%%
 * @package    %%project_name%%
 * @subpackage %%subpackage_name%%
 * @author     %%your_name%% <%%your_email%%>
 * @copyright  %%your_project%%
 * @license    %%your_license%%
 * @version    GIT: $Id$
 * @link       %%your_link%%
 * @see        http://www.enviphp.net/c/man/v3/core/db/build-model
 * @since      File available since Release 1.0.0
 * @doc_ignore
 */

/**
 * @category   %%project_category%%
 * @package    %%project_name%%
 * @subpackage %%subpackage_name%%
 * @author     %%your_name%% <%%your_email%%>
 * @copyright  %%your_project%%
 * @license    %%your_license%%
 * @version    Release: @package_version@
 * @link       %%your_link%%
 * @see        http://www.enviphp.net/c/man/v3/core/db/build-model
 * @since      Class available since Release 1.0.0
 * @doc_ignore
 */
class _____model_pascal_case_name_____Peer extends /*%%model_base_name_space%%*/Base_____model_pascal_case_name_____Peer
{
    protected static $queries = array(
        'get_all'    => 'SELECT * FROM __TABLE__',
/*%%unique_check_query%%*/
    );

    /**
     * +-- データの一覧を配列で返す
     *
     * @access      public
     * @static
     * @param  EnviDBIBase $con OPTIONAL:NULL
     * @return array
     */
    public static function getAllByArray($con = null)
    {
        $bind_array = array();
        $suffix     = null;
        $query_key  = 'get_all';

        $dbi = $con ? $con : extension()->DBI()->getInstance('default_master');
        $sql = self::getReplacedSQL(self::$queries[$query_key], $bind_array, $suffix);
        $res = $dbi->getAll($sql, $bind_array);
        return $res;
    }
    /* ----------------------------------------- */

/*%%unique_check_method%%*/
}
