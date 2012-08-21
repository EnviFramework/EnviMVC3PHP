
    /**
     * +-- マジックメソッド
     *
     * @access public
     * @param  $name
     * @param  $value
     * @return void
     */
    public function __set($name, $value)
    {
        if (isset($this->to_save[$name])) {
            parent::__set($name, $value);
        }
        trigger_error('undefined property:'.$name);
    }
    /* ----------------------------------------- */

    /**
     * +-- マジックメソッド
     *
     * @access public
     * @param  $name
     * @return integer|string
     */
    public function __get($name)
    {
        if (isset($this->to_save[$name])) {
            return parent::__get($name);
        }

        trigger_error('undefined property:'.$name);
    }
    /* ----------------------------------------- */

    /**
     * +-- マジックメソッド
     *
     * @access public
     * @param  $name
     * @param  $arguments
     * @return mixed
     */
    public function __call ($name , $arguments)
    {
        trigger_error('undefined method:'.$name);
    }
    /* ----------------------------------------- */
