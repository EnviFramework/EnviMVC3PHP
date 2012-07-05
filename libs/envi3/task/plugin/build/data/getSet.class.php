
    public function get%%method%%()
    {
        return isset($this->to_save['%%column%%']) ? $this->to_save['%%column%%'] : NULL;
    }

    public function set%%method%%($val)
    {
        $this->_is_modify = true;
        $this->to_save['%%column%%'] = $val;
    }

