<?php
    /**

     */
    
    class View_Loader
    {
        /**
         * @desc biến lưu trữ các view đã load
         */
        private $__content = array();
        
        /**
         * Load view
         * 
         * @desc    hàm load view, tham số truyền vào là tên của view và dữ liệu truyền qua view
         */
        public function load($view, $data = array()) 
        {
            // Chuyển mảng dữ liệu thành từng biến
            extract($data);
            
            // Chuyển nội dung view thành biến thay vì in ra bằng cách dùng ob_start()
            ob_start();
            
            require_once PATH_APPLICATION . '/view/' . $view . '.php';
            
            $content = ob_get_contents();
            ob_end_clean();
            
            // Gán nội dung vào danh sách view đã load
            $this->__content[] = $content;

            return $content;
        }
        

        /**
         * Show view
         * 
         * @desc    Hàm hiển thị toàn bộ view đã load, được dùng ở controller
         */
        public function show()
        {
            foreach ($this->__content as $html){
                echo $html;
            }
        }
    }
