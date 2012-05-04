<?php

namespace Album\Model;

use Zend\Db\ResultSet\Row;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;


class Album extends Row
{
    protected $inputFilter;

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter;

            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'       => 'id',
                'required'   => true,
                'filters' => array(
                    array(
                        'name'    => 'Int',
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'       => 'artist',
                'required'   => true,
                'filters'    => array(
                    array(
                        'name'    => 'StripTags',
                    ),
                    array(
                        'name'    => 'StringTrim',
                    ),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'       => 'title',
                'required'   => true,
                'filters'    => array(
                    array(
                        'name'    => 'StripTags',
                    ),
                    array(
                        'name'    => 'StringTrim',
                    ),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;        
        }

        return $inputFilter;
    }
}