<?php

namespace MainBundle\Traits\Personnel;

/**
 * Class Post
 * @package MainBundle\Traits\Personnel
 */
trait Post
{
    /**
     * This function is used to check and set custom data in language field
     *
     * @param $object
     */
  public function checkAndSetLanguages(&$object)
  {
      $data = $this->getRequestData();
      $anotherLang = $data['anotherLang'];
      $language = $object->getLanguage();

      //add languages values
      if ($anotherLang){
          $language[] = $anotherLang;
          $object->setLanguage($language);
      }
  }

    /**
     * This function is used to check and set custom data in comp educ. field
     *
     * @param $object
     */
    public function checkAndSetCompEducation(&$object)
    {
        $data = $this->getRequestData();
        $anotherCompEducation = $data['anotherCompEducation'];
        $compEducation = $object->getCompKnowledge();

        //add languages values
        if ($anotherCompEducation){
            $compEducation[] = $anotherCompEducation;
            $object->setCompKnowledge($compEducation);
        }
    }

    /**
     * This function is used to check and set custom data in requirement field
     *
     * @param $object
     */
    public function checkAndSetRequirement(&$object)
    {
        $data = $this->getRequestData();
        $anotherRequirement = $data['anotherRequirement'];
        $requirement = $object->getRequirement();

        //add languages values
        if ($anotherRequirement){
            $requirement[] = $anotherRequirement;
            $object->setRequirement($requirement);
        }
    }

    /**
     * This function is used to generate selections data for language filed
     *
     * @param $subject
     * @return array
     */
    private function generateLanguageArray($subject)
    {
        //generate default language array data
        $langArray = [
            'Հայերեն'=>'Հայերեն',
            'Ռուսերեն'=>'Ռուսերեն',
            'Անգլերեն'=>'Անգլերեն',
            'Առանց սահմանափակման'=>'Առանց սահմանափակման',
        ];

        //get languages in db
        $language = $subject->getLanguage() ? $subject->getLanguage() : $langArray;
        $diff = array_diff($language, $langArray);

        foreach($diff as $df)
        {
            $langArray[$df] = $df;
        }

        $langArray[] = 'Այլ լեզու';

        return $langArray;
    }

    /**
     * This function is used to generate selections data for comp education filed
     *
     * @param $subject
     * @return array
     */
    private function generateCompEducationArray($subject)
    {
        //generate default language array data
        $compEducationArray = [
            'Ազատ տիրապետել'=>'Ազատ տիրապետել',
            'Առանց սահմանափակման'=>'Առանց սահմանափակման',
        ];

        //get languages in db
        $compEducation = $subject->getCompKnowledge() ? $subject->getCompKnowledge() : $compEducationArray;
        $diff = array_diff($compEducation, $compEducationArray);

        foreach($diff as $df)
        {
            $compEducationArray[$df] = $df;
        }

        $compEducationArray[] = 'Այլ ծրագրեր';

        return $compEducationArray;
    }

    /**
     * This function is used to generate selections data for requirement filed
     *
     * @param $subject
     * @return array
     */
    private function generateRequirementArray($subject)
    {
        //generate default required array data
        $requiredArray = [
            'Արագ կողմնորոշվողլ'=>'Արագ կողմնորոշվող',
            'Սթրեսակայուն'=>'Սթրեսակայուն',
        ];

        //get requirement in db
        $requirement = $subject->getRequirement() ? $subject->getRequirement() : $requiredArray;
        $diff = array_diff($requirement, $requiredArray);

        foreach($diff as $df)
        {
            $requiredArray[$df] = $df;
        }

        $requiredArray[] = 'Այլ պահանջ';

        return $requiredArray;
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