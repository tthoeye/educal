<?php

/**
 * Class CalendarController
 * This controller handles the CRUD of calendars.
 */
class CalendarController extends \BaseController
{

    /**
     * Display a listing of the calendars.
     *
     * @return Response
     */
    public function index()
    {
        if (!Sentry::check()) {
            return Redirect::route('landing');
        }
        // Find active user and set default variables to null
        $user = Sentry::getUser();
        $calendars = null;

        // Check if user is superAdmin
        if ($user->hasAccess('superadmin')) {
            $calendars = Calendar::where('school_id', '<>', '')->get();
            $calendars = $calendars->load('school');

            // Return view with selected parameters
            return View::make('calendarManagement.listGroups')->with('groups', $calendars);

        } elseif ($user->hasAccess('editor')) {

            // Get school_id, by which we will search for related groups
            $schoolId = $user->school_id;

            // Find all groups with certain school_id
            $calendars = Calendar::where('school_id', '=', $schoolId)->get();
            $calendars = $calendars->load('school');

            // Return view with selected parameters
            return View::make('calendarManagement.listGroups')->with('groups', $calendars);

        } else {
            // If no permissions, redirect the user to the calendar index page
            return Redirect::route('calendar.index');
        }


    }


    /**
     * Show the form for creating a new calendar.
     *
     * @return Response
     */

    // TODO: Add colors/codes to calendars
    public function create()
    {
        if (!Sentry::check()) {
            // If no permissions, redirect to calendar index
            return Redirect::route('landing');
        }
        $schools = null;
        // Find active user
        $user = Sentry::getUser();

        // If user is a superAdmin (has access to school), show school-dropdown for the view where the user can
        // choose which school he wants to add the calendar to
        if ($user->hasAccess('superadmin')) {
            $schools = School::lists('name', 'id');

            return View::make('calendarManagement.createGroup')->with('schools', $schools);

        } else {

            if ($user->hasAccess('calendar')) {
                return View::make('calendarManagement.createGroup')->with('schools', null);
            } else {
                // If no permissions, redirect the user to the calendar index page
                return Redirect::route('calendar.index');
            }
        }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        if (!Sentry::check()) {
            // If no permissions, redirect to calendar index
            return Redirect::route('landing');
        }
        // Find active user
        $user = Sentry::getUser();

        if ($user->hasAnyAccess(['school', 'calendar'])) {
            $school = null;

            // Validate input fields
            $validator = Validator::make(
                [
                    'name' => e(Input::get('name')),
                    'school' => Input::get('school'),
                ],
                [
                    'name' => 'required',
                    'school' => 'integer'
                ]
            );

            if ($validator->fails()) {
                return Redirect::route('group.create')->withInput()->withErrors($validator);
            }

            $calendar = new Calendar();
            $calendar->name = e(Input::get('name'));
            $calendar->description = e(Input::get('name'));
            $calendar->school_id = Input::get('school');

            $calendar->save();

            $user->calendars()->attach($calendar);

            return Redirect::route('calendarManagement.index');

        } else {
            // If no permissions, redirect the user to the calendar index page
            return Redirect::route('calendar.index');
        }
    }

    /**
     * Show the form for editing the specified calendar.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        if (!Sentry::check()) {
            // If no permissions, redirect to calendar index
            return Redirect::route('landing');
        }

        // Find active user
        $user = Sentry::getUser();
        $calendar = Calendar::find($id);

        // Permissions check
        if (!($user->hasAccess('admin') && $user->school_id == $calendar->school_id) && !$user->hasAccess('superadmin')) {
            // If no permissions, redirect the user to the calendar index page
            return Redirect::route('calendar.index');
        }

        // Find all users in the selected group
        $users = Calendar::find($id)->users();
        // Find all users by school
        $schoolUsers = User::where('users.school_id', $calendar->school_id)->get();

        // Find all possible users that aren't in the group yet
        // This array of users will be used to generate a dropdown menu
        $possibleUsers = [];
        foreach ($schoolUsers as $su) {
            $found = false;
            foreach ($users as $u) {
                if ($u->id === $su->id) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                array_push($possibleUsers, $su);
            }
        }
        // TODO: If users > 10 , do like this, else, get list with checkboxes if possible
        // Transform array into usable list for dropdownmenu
        $smartUsers = [];
        foreach ($possibleUsers as $pus) {
            $smartUsers[$pus->id] = $pus->email;
        }

        // Return view with selected parameters
        return View::make('calendarManagement.editGroups')
            ->with('users', $users)
            ->with('group', $calendar)
            ->with('smartUsers', $smartUsers);


    }


    /**
     * Update the specified calendar in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {

        if (!Sentry::check()) {
            // If no permissions, redirect to calendar index
            return Redirect::route('landing');
        }

        // Find active user and group information
        $user = Sentry::getUser();
        $calendar = Calendar::find($id);

        // Permission checks
        if (!$user->hasAccess('superadmin') && !($user->hasAccess('admin') && $user->school_id == $calendar->school_id)) {
            // If no permissions, redirect the user to the calendar index page
            return Redirect::route('calendar.index');
        }
        // If permissions are met, get school info
        $school = $calendar->school;

        // Generate full calendar name
        if (Input::get('name') != null) {
            $calName = preg_replace('/[^A-Za-z0-9\-_ ]/', '', Input::get('name'));
        } else {
            $calName = $calendar->name;
        }

        // Make a validator to see if the new group name is unique if it's not the same as before
        // Validate input fields
        $validator = Validator::make(
            [
                'name' => e($calName),
                'school' => Input::get('school'),
                'permissions' => Input::get('permissions')
            ],
            [
                'school' => 'integer'
            ]
        );

        // Error handling
        if ($validator->fails()) {

            return Redirect::route('calendarManagement.edit', $id)->withInput()->withErrors($validator);

            // TODO: take a look at "protected" calendars
        } elseif ($calName == $school->name || $calName == 'Administratie') {
            // Do not allow default groups to be renamed
            return Redirect::route('calendarManagement.edit', $id);

        } else {

            $calendar->name = $calName;
            // Save/update the calendar
            $calendar->save();

            return Redirect::route('calendarManagement.edit', $id);
        }


    }

    /**
     * Remove the specified calendar from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if (!Sentry::check()) {
            return;
        }
        // Find active user and group information
        $user = Sentry::getUser();
        $calendar = Calendar::find($id);

        // Permission checks
        if ($user->hasAccess('superadmin') || ($user->hasAccess('admin') && $user->school_id == $calendar->school_id)) {
            $calendar->delete();
        }

    }


}
