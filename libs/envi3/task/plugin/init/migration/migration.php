<?php
/**
 * DB Migrationファイル
 *
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
 * @see        http://www.enviphp.net/c/man/v3/core/migrate
 * @since      File available since Release 3.4.0
 * @doc_ignore
 */

/**
 * DB Migrationファイル
 *
 *
 * @category   %%project_category%%
 * @package    %%project_name%%
 * @subpackage %%subpackage_name%%
 * @author     %%your_name%% <%%your_email%%>
 * @copyright  %%your_project%%
 * @license    %%your_license%%
 * @version    Release: @package_version@
 * @link       %%your_link%%
 * @see        http://www.enviphp.net/c/man/v3/core/migrate
 * @since      Class available since Release 3.4.0
 * @doc_ignore
 */
class ___class_name___ extends EnviMigrationBase
{


    public function __construct()
    {
        $project_dir = dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR;

        $this->databases_yml = $project_dir.'config'.DIRECTORY_SEPARATOR.'___app_name____databases.yml';

        $this->env = trim(file_get_contents(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'env'));

        $this->instance_name = 'default_master';
    }



    public function change()
    {

    }
    public function up()
    {

    }
    public function down()
    {

    }

}
