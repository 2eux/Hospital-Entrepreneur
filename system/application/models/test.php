<?php
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package     CodeIgniter
 * @author      Rick Ellis
 * @copyright   Copyright (c) 2006, pMachine, Inc.
 * @license     http://www.codeigniter.com/user_guide/license.html
 * @link        http://www.codeigniter.com
 * @since       Version 1.0
 * @filesource
 */


class Test extends Model 
{
    function Test()
    {
        $this->obj =& get_instance();
        
		echo "HEY";

        parent::Model();
    }

    function getCountries()
    {
        if ($this->obj->config->item('auth_use_country'))
        {
            $query = $this->obj->db->get($this->obj->config->item('auth_country_table_name'));
            if ($query->num_rows() > 0)
            {
                foreach ($query->result() as $row)
                    $options[$row->{$this->obj->config->item('auth_country_id_field')}] = $row->{$this->obj->config->item('auth_country_name_field')};
            
                return $options;
            }
        }
        
        return null;
    }
}
?>
