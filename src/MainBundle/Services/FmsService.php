<?php

namespace MainBundle\Services;

/**
 * Class FmsService
 * @package MainBundle\Services
 */
class FmsService
{
    /**
     * This function is used to upload files object
     *
     * @param $object
     */
    public function uploadFile(&$object)
    {
        // the file property can be empty if the field is not required
        if (null == $object->getFile())
        {
            return;
        }

        // check file name
        if($object->getFileName()){
            // get file path
            $path = $object->getAbsolutePath() . $object->getFileName();
            // check file
            if(file_exists($path) && is_file($path)){
                // remove file
                unlink($path);
            }
        }

        // get file originalName
        $object->setFileOriginalName($object->getFile()->getClientOriginalName());

        // get file
        $path_parts = pathinfo($object->getFile()->getClientOriginalName());

        // generate filename
        if(!$path_parts['extension']){
            $extension = $object->getFile()->getMimeType();
            $extension = substr($extension ,strpos($extension, '/') + 1);

        }else{
            $extension = $path_parts['extension'];
        }

        //set file data
        $object->setType($extension);
        $object->setFileName(md5(microtime()) . '.' . $extension);
        $object->setFileSize($object->getFile()->getClientSize());
        $object->getFile()->move($object->getAbsolutePath(), $object->getFileName());
        $object->setFile(null);
    }

    /**
     * This function is used to get job days for current and last years by month
     *
     */
    public function getJobDays()
    {
        //set default data
        $type = CAL_GREGORIAN;
        $jobDays = [];
        $year = date('Y'); // Year in 4 digit 2009 format.

        //generate job days count for each month in current and preview years
        for ($y = $year - 1; $y <= $year; $y++) {

            $sumJobDaysCount = 0;

            for ($m = 1; $m <= 12; $m++) {

                $workdaysCount = 0;
                $day_counts = cal_days_in_month($type, $m, $y); // Get the amount of days by years and month

                //loop through all days
                for ($i = 1; $i <= $day_counts; $i++) {

                    $date = $y.'/'.$m.'/'.$i;
                    $getName = date('l', strtotime($date)); //Get day name
                    $dayName = substr($getName, 0, 3); // Trim day name to 3 chars

                    //if not a weekend add sum day
                    if ($dayName != 'Sun' && $dayName != 'Sat') {
                        $workdaysCount ++;
                    }
                }

                //generate sum work days for each month and all years
                $sumJobDaysCount += $workdaysCount;
                $jobDays[$y][$m] = $workdaysCount;
            }

            //set all job day count in array
            $jobDays[$y][0] = round(($sumJobDaysCount / 12), 1);

        }

        return $jobDays;
    }

    /**
     * @param $rates
     * @return array
     */
    public function getHourAndDaySalary($rates)
    {
        $salary = [];

        if (count($rates) > 0) {

            $jobDays = $this->getJobDays();

//            $sumPreviewYearJobDays = reset($jobDays)[0];
            $sumCurrentYearJobDays = end($jobDays)[0];

//            $sumPreviewsYearAverageJobTime = $sumPreviewYearJobDays * 8;
            $sumCurrentYearAverageJobTime = $sumCurrentYearJobDays * 8;

            foreach ($rates as $key => $rate)
            {
                $salary[$key]['hour'] = ceil($rate / $sumCurrentYearAverageJobTime);
                $salary[$key]['day'] = ceil($rate / $sumCurrentYearJobDays);
            }
        }

        return $salary;
    }
}