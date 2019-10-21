<?php
/**

 * @filesource  system/core/loader/FT_Helper_Loader.php
 */
class Helper_Loader
{
    /**
     * Load helper
     * 
     * @desc    hàm load helper, tham số truyền vào là tên của helper
     */
    public function load($helper)
    {
        $helper = ucfirst($helper) . '_Helper';
        require_once(PATH_SYSTEM . '/helper/' . $helper . '.php');
    }
}
