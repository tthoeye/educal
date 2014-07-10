<?php

class IcalCalendarController extends \BaseController {

	/**
	 * Find correct appointments depending on $school and $group
     * Process these appointments and render them to an .ics file which will be returned for download
	 *
     * @param  string  $school
     * @param  string  $group
	 * @return Cal.ics download file
     *
     */
	public function index($school, $group)
    {
        $appointments = [];
        // Load appointments based on group
        $selGroup = Group::where('name', $school.'_'.$group)->first();
        $selGroup->load('appointments');
        // Add global appointments, unless only global appointments are requested
        if($group != 'global') {
            $globalGroup = Group::where('name', $school.'_global')->first();
            $globalGroup->load('appointments');

            foreach($globalGroup->appointments as $appointment) {
                array_push($appointments, $appointment);
            }
        }
        // Push to array
        foreach($selGroup->appointments as $appointment) {
            array_push($appointments, $appointment);
        }

        $calendar = self::composeIcal($appointments);
        return $calendar->render();
	}

    public function composeIcal($appointments)
    {
        // Set default timezone (PHP 5.4)
        date_default_timezone_set('Europe/Berlin');

        // 1. Create new calendar
        $calendar = new \Eluceo\iCal\Component\Calendar('EduCal');

        // Loop through appointments and add them to the calendar.
        foreach($appointments as $appointment) {

            // 2. Create an event
            $event = new \Eluceo\iCal\Component\Event();
            $event->setSummary($appointment['attributes']['title']);
            $event->setDescription($appointment['attributes']['description']);
            $event->setDtStart(new \DateTime($appointment['attributes']['start_date']));
            $event->setDtEnd(new \DateTime($appointment['attributes']['end_date']));
            $event->setNoTime($appointment['attributes']['allday']);
            $event->setStatus('TENTATIVE');

            // Recurence option (e.g. New Year happens every year)
            // Set recurrence rule
            if($appointment['attributes']['repeat_type']) {

                $recurrenceRule = new \Eluceo\iCal\Property\Event\RecurrenceRule();
                switch($appointment['attributes']['repeat_type']) {
                    case 'd':
                        $recurrenceRule->setFreq(\Eluceo\iCal\Property\Event\RecurrenceRule::FREQ_DAILY);
                        break;
                    case 'w':
                        $recurrenceRule->setFreq(\Eluceo\iCal\Property\Event\RecurrenceRule::FREQ_WEEKLY);
                        break;
                    case 'M':
                        $recurrenceRule->setFreq(\Eluceo\iCal\Property\Event\RecurrenceRule::FREQ_MONTHLY);
                        break;
                    case 'y':
                        $recurrenceRule->setFreq(\Eluceo\iCal\Property\Event\RecurrenceRule::FREQ_YEARLY);
                        break;
                }
                $recurrenceRule->setInterval($appointment['attributes']['repeat_freq']);
                $recurrenceRule->setCount($appointment['attributes']['nr_repeat']);

                $event->setRecurrenceRule($recurrenceRule);
            }

            // Adding Timezone (optional)
            $event->setUseTimezone(true);
            $event->setTimeTransparency('TRANSPARENT');

            // 3. Add event to calendar
            $calendar->addEvent($event);
        }

        // 4. Set headers
        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="cal.ics"');

        // 5. Output
        return $calendar;
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        // Find selected appointment
        $appointment = Appointment::find($id);
        $appointments = [];
        array_push($appointments, $appointment);

        //var_dump($appointments);
        $calendar = self::composeIcal($appointments);
        return $calendar->render();
	}
}
