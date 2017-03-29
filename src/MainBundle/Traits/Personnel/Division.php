<?php

namespace MainBundle\Traits\Personnel;

/**
 * Class Division
 * @package MainBundle\Traits\Personnel
 */
trait Division
{
    /**
     * This function is used to check and set custom type
     *
     * @param $object
     */
    public function checkAndSetType(&$object)
    {
        $data = $this->getRequestData();
        $anotherType = $data['anotherType'];
        $type = $object->getType();

        //add languages values
        if ($anotherType){
            $type[] = $anotherType;
            $object->setType($type);
        }
    }


    /**
     * This function is used to generate selections data for type
     *
     * @param $subject
     * @return array
     */
    private function generateTypeArray($subject)
    {
        //generate default type array data
        $typeArray = [
            'Ծառայություն'=>'Ծառայություն',
            'Վարչություն'=>'Վարչություն',
            'Բաժին'=>'Բաժին',
            'Բաժանմունք'=>'Բաժանմունք',
        ];

        //get type in db
        $type = $subject->getType() ? $subject->getType() : $typeArray;
        $diff = array_diff($type, $typeArray);

        foreach($diff as $df)
        {
            $typeArray[$df] = $df;
        }

        $typeArray[] = 'Ավելացնել տիպ';

        return $typeArray;
    }

    /**
     * This function is used to get request data
     */
    public function getRequestData()
    {
        //get images by ids
        $request = $this->getRequest();
        $uniqId = $this->getUniqid();
        $data = $request->request->get($uniqId);

        return $data;
    }
}