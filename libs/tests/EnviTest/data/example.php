<?php


class exampleBase
{
    public function doSomething($val)
    {
        return $val;
    }


    public function doSomething2()
    {
        return mt_rand();
    }

    public function doSomething3($val, $val2)
    {
        return $val*$val2;
    }
}


class example extends exampleBase
{
    public function doAnything($val)
    {
        return $val%2 === 0;
    }


    public function doAnything2()
    {
        return time();
    }

    public function doAnything3($val, $val2)
    {
        return $val>=$val2;
    }
}


class example1
{

}