<?php
namespace Album\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Validator\Hostname as HostnameValidator;

class AlbumFilter extends InputFilter
{

    public function __construct()
    {
        $factory = new InputFactory();

        $this->add($factory->createInput(array(
            'name'       => 'id',
            'required'   => true,
            'filters' => array(
                array(
                    'name'    => 'Int',
                ),
            ),
        )));

        $this->add($factory->createInput(array(
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

        $this->add($factory->createInput(array(
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
    }

}

