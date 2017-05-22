<?php

namespace MainBundle\Traits\Meeting;
use MainBundle\Entity\Invitors;

/**
 * Trait Meeting
 * @package MainBundle\Traits\Personnel
 */
trait Meeting
{
    /**
     * This function is used to check and set custom data for meeting type
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
     * This function is used to check and set custom data for meeting place
     *
     * @param $object
     */
    public function checkAndSetPlace(&$object)
    {
        $data = $this->getRequestData();
        $anotherPlace = $data['anotherPlace'];
        $type = $object->getPlace();

        //add another place values
        if ($anotherPlace){
            $type[] = $anotherPlace;
            $object->setPlace($type);
        }
    }

    /**
     * This function is used to check and set custom data for meeting subject
     *
     * @param $object
     */
    public function checkAndSetSubject(&$object)
    {
        $data = $this->getRequestData();
        $anotherSubject = $data['anotherSubject'];
        $subject = $object->getSubject();

        //add another place values
        if ($anotherSubject){
            $subject[] = $anotherSubject;
            $object->setSubject($subject);
        }
    }

    /**
     * This function is used to check and set custom data for meeting chair person
     *
     * @param $object
     */
    public function checkAndSetChairPerson(&$object)
    {
        $data = $this->getRequestData();
        $anotherChairPerson = $data['anotherChairPerson'];
        $chairPerson = $object->getChairPerson();

        //add another place values
        if ($anotherChairPerson){
            $chairPerson[] = $anotherChairPerson;
            $object->setChairPerson($chairPerson);
        }
    }

    /**
     * This function is used to check and set custom data for meeting secretary
     *
     * @param $object
     */
    public function checkAndSetSecretary(&$object)
    {
        $data = $this->getRequestData();
        $anotherSecretary = $data['anotherSecretary'];
        $secretary = $object->getSecretary();

        //add another secretary
        if ($anotherSecretary){
            $secretary[] = $anotherSecretary;
            $object->setSecretary($secretary);
        }
    }


    /**
     * This function is used to generate selections data for meeting type
     *
     * @param $subject
     * @return array
     */
    private function generateTypeArray($subject)
    {
        //generate default type array data
        $typeArray = [
            'Ընդհանուր ժողով' => 'Ընդհանուր ժողով',
            'Խորհրդի ժողով' => 'Խորհրդի ժողով',
            'Խորհրդակցություն' => 'Խորհրդակցություն',
            'Քննարկում' => 'Քննարկում',
            'Դիսպետչերական' => 'Դիսպետչերական'
        ];

        //get types in db
        $type = $subject->getType() ? $subject->getType() : $typeArray;
        $diff = array_diff($type, $typeArray);

        foreach($diff as $df)
        {
            $typeArray[$df] = $df;
        }

        $typeArray[] = 'Այլ լրացվող';

        return $typeArray;
    }

    /**
     * This function is used to generate selections data for meeting subject
     *
     * @param $subject
     * @return array
     */
    private function generateSubjectArray($subject)
    {
        //generate default type array data
        $subjectArray = [
            'Օպերատիվ պլանների քննարկում' => 'Օպերատիվ պլանների քննարկում',
            'Ֆինանսական պլանի հաստատում' => 'Ֆինանսական պլանի հաստատում',
            'Աշխատավարձերի քննարկում' => 'Աշխատավարձերի քննարկում',
            'Նոր ապրանքատեսակի մշակման քննարկում' => 'Նոր ապրանքատեսակի մշակման քննարկում'
        ];

        //get types in db
        $meetingSubject = $subject->getSubject() ? $subject->getSubject() : $subjectArray;
        $diff = array_diff($meetingSubject, $subjectArray);

        foreach($diff as $df)
        {
            $subjectArray[$df] = $df;
        }

        $subjectArray[] = 'Այլ լրացվող';

        return $subjectArray;
    }

    /**
     * This function is used to generate selections data for meeting place
     *
     * @param $subject
     * @return array
     */
    private function generatePlaceArray($subject)
    {
        //generate default type array data
        $placeArray = [
            'Տնօրենի աշխատասենյակ' => 'Տնօրենի աշխատասենյակ',
            'Ինժեներներատեխնոլոգիական սենյակ' => 'Ինժեներներատեխնոլոգիական սենյակ',
            'Խորհրդակցություն' => 'Խորհրդակցություն',
            'Արտադրամաս' => 'Արտադրամաս'
        ];

        //get types in db
        $place = $subject->getPlace() ? $subject->getPlace() : $placeArray;
        $diff = array_diff($place, $placeArray);

        foreach($diff as $df)
        {
            $placeArray[$df] = $df;
        }

        $placeArray[] = 'Այլ լրացվող';

        return $placeArray;
    }

    /**
     * This function is used to generate selections data for meeting chair person
     *
     * @param $subject
     * @return array
     */
    private function generateChairPersonArray($subject)
    {
        //generate default type array data
        $chairPersonArray = [
            'Տնօրեն' => 'Տնօրեն',
            'Գլխ ինժեներ' => 'Գլխ ինժեներ',
            'Գլխ տեխնոլոգ' => 'Գլխ տեխնոլոգ',
            'Արտադրամասի պետ' => 'Արտադրամասի պետ'
        ];

        //get chair person in db
        $chairPerson = $subject->getChairPerson() ? $subject->getChairPerson() : $chairPersonArray;
        $diff = array_diff($chairPerson, $chairPersonArray);

        foreach($diff as $df)
        {
            $chairPersonArray[$df] = $df;
        }

        $chairPersonArray[] = 'Այլ լրացվող';

        return $chairPersonArray;
    }

    /**
     * This function is used to generate selections data for meeting secretary
     *
     * @param $subject
     * @return array
     */
    private function generateSecretaryArray($subject)
    {
        //generate default type array data
        $secretaryArray = [
            'Տնօրեն' => 'Տնօրեն',
            'Քարտուղար' => 'Քարտուղար',
            'հաշվապահ' => 'հաշվապահ',
            'Արտադրամասի պետի տեղակալ' => 'Արտադրամասի պետի տեղակալ'
        ];

        //get chair person in db
        $secretary = $subject->getSecretary() ? $subject->getSecretary() : $secretaryArray;
        $diff = array_diff($secretary, $secretaryArray);

        foreach($diff as $df)
        {
            $secretaryArray[$df] = $df;
        }

        $secretaryArray[] = 'Այլ լրացվող';

        return $secretaryArray;
    }

    /**
     * @param $object
     */
    public function setAllDynamicallyData($object)
    {
        //check and set array fields data
        $this->checkAndSetType($object);
        $this->checkAndSetPlace($object);
        $this->checkAndSetSubject($object);
        $this->checkAndSetChairPerson($object);
        $this->checkAndSetSecretary($object);
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

    /**
     * Thsi function is used to add new invitors in meeting
     *
     * @param $object
     */
    public function addNewInvitors($object)
    {
        //get all request data
        $data = $this->getRequestData();

        //get added invitors value in request
        $newInvitors = array_key_exists('newInvitors', $data) ? $data['newInvitors'] : null;

        if($newInvitors) {

            //create new vendor and related it with current tool
            $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();

            foreach ($newInvitors as $newInvitor)
            {
                $invitor = new Invitors();
                $invitor->setName($newInvitor);

                $em->persist($invitor);
                $object->addInvitor($invitor);
            }

            $em->flush();

        }
    }

    /**
     * @param $object
     */
    public function setRelation($object)
    {
        //get meeting schedule
        $meetingSchedule = $object->getMeetingSchedule();

        if($meetingSchedule) {

            foreach($meetingSchedule as $schedule)
            {
                if(!$schedule->getId()) {
                    $schedule->setMeeting($object);
                }
            }
        }

        //get meeting tasks
        $meetingTasks = $object->getMeetingTask();

        if($meetingTasks) {

            foreach($meetingTasks as $meetingTask)
            {
                if(!$meetingTask->getId()) {
                    $meetingTask->setMeeting($object);
                }
            }
        }
    }

    /**
     * @param $object
     */
    public function removeRelations($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $em = $container->get('doctrine')->getManager();

        //remove meeting schedules
        $meetingSchedule = $object->getMeetingSchedule();

        if($meetingSchedule) {

            $schedules = $meetingSchedule->getDeleteDiff();

            foreach($schedules as $schedule)
            {
                $em->remove($schedule);
            }
        }

        //remove meeting tasks
        $meetingTasks = $object->getMeetingTask();

        if($meetingTasks) {

            $tasks = $meetingTasks->getDeleteDiff();

            foreach($tasks as $task)
            {
                $em->remove($task);
            }
        }
    }
}