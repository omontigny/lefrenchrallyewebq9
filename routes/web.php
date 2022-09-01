<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Auth */

Auth::routes(['register' => false]);

/* Https */
URL::forceScheme('https');

/* Le French Rallye */
Route::get('/', function () {
  return redirect('welcome');
});
Route::get('welcome', 'LeFrenchRallyeController@welcome')->name('welcome');
Route::get('welcomeRequest', 'LeFrenchRallyeController@welcomeRequest')->name('welcome');


Route::get('home', 'LeFrenchRallyeController@home')->name('home');


/* Rallyes */
Route::get('rallyes', 'RallyesController@index')->name('rallyes');
Route::get('rallyes/create', 'RallyesController@create')->name('rallyes.create');
Route::get('rallyes/store', 'RallyesController@store')->name('rallyes.store');
Route::get('rallyes/{id}', 'RallyesController@edit')->name('rallyes.edit');
Route::get('rallyes/update/{id}', 'RallyesController@update')->name('rallyes.update');
Route::get('rallyes/delete/{id}', 'RallyesController@destroy')->name('rallyes.destroy');

/* MembershipPrices */
Route::get('membershipprices', 'MembershipPricesController@index')->name('membershipprices');
Route::get('membershipprices/create', 'MembershipPricesController@create')->name('membershipprices.create');
Route::get('membershipprices/store', 'MembershipPricesController@store')->name('membershipprices.store');
Route::get('membershipprices/{id}', 'MembershipPricesController@edit')->name('membershipprices.edit');
Route::get('membershipprices/update/{id}', 'MembershipPricesController@update')->name('membershipprices.update');
Route::get('membershipprices/delete/{id}', 'MembershipPricesController@destroy')->name('membershipprices.destroy');

/* Roles */
Route::get('roles', 'RolesController@index')->name('roles');
Route::get('roles/create', 'RolesController@create')->name('roles.create');
Route::get('roles/store', 'RolesController@store')->name('roles.store');
Route::get('roles/{id}', 'RolesController@edit')->name('roles.edit');
Route::get('roles/update/{id}', 'RolesController@update')->name('roles.update');
Route::get('roles/delete/{id}', 'RolesController@destroy')->name('roles.destroy');

/* Schools */
Route::get('schools', 'SchoolsController@index')->name('schools');
Route::get('schools/create', 'SchoolsController@create')->name('schools.create');
Route::get('schools/store', 'SchoolsController@store')->name('schools.store');
Route::get('schools/{id}', 'SchoolsController@edit')->name('schools.edit');
Route::get('schools/update/{id}', 'SchoolsController@update')->name('schools.update');
Route::get('schools/delete/{id}', 'SchoolsController@destroy')->name('schools.destroy');

Route::post('schoolsStore', 'SchoolsController@store');

/* SchoolYears */
Route::get('schoolyears', 'SchoolYearsController@index')->name('schoolyears');
Route::get('schoolyears/create', 'SchoolYearsController@create')->name('schoolyears.create');
Route::get('schoolyears/store', 'SchoolYearsController@store')->name('schoolyears.store');
Route::get('schoolyears/{id}', 'SchoolYearsController@edit')->name('schoolyears.edit');
Route::get('schoolyears/update/{id}', 'SchoolYearsController@update')->name('schoolyears.update');
Route::get('schoolyears/delete/{id}', 'SchoolYearsController@destroy')->name('schoolyears.destroy');
/* SchoolYears: Extra */
Route::get('deleteAllSchoolYears', 'SchoolYearsExtraController@deleteAllSchoolYears');

/* KeyValues */
Route::get('keyvalues', 'KeyValuesController@index')->name('keyvalues');
Route::get('keyvalues/create', 'KeyValuesController@create')->name('keyvalues.create');
Route::get('keyvalues/store', 'KeyValuesController@store')->name('keyvalues.store');
Route::get('keyvalues/{id}', 'KeyValuesController@edit')->name('keyvalues.edit');
Route::get('keyvalues/update/{id}', 'KeyValuesController@update')->name('keyvalues.update');
Route::get('keyvalues/delete/{id}', 'KeyValuesController@destroy')->name('keyvalues.destroy');

/* Coordinators */
Route::get('coordinators', 'CoordinatorsController@index')->name('coordinators');
Route::get('coordinators/create', 'CoordinatorsController@create')->name('coordinators.create');
Route::get('coordinators/store', 'CoordinatorsController@store')->name('coordinators.store');
Route::get('coordinators/{id}', 'CoordinatorsController@edit')->name('coordinators.edit');
Route::get('coordinators/update/{id}', 'CoordinatorsController@update')->name('coordinators.update');
Route::get('coordinators/delete/{id}', 'CoordinatorsController@destroy')->name('coordinators.destroy');
/* RallyeCoordinators */
Route::get('rallyecoordinators', 'RallyeCoordinatorsController@index')->name('rallyecoordinators');
Route::get('rallyecoordinators/create', 'RallyeCoordinatorsController@create')->name('rallyecoordinators.create');
Route::get('rallyecoordinators/store', 'RallyeCoordinatorsController@store')->name('rallyecoordinators.store');
Route::get('rallyecoordinators/{id}', 'RallyeCoordinatorsController@edit')->name('rallyecoordinators.edit');
Route::get('rallyecoordinators/update/{id}', 'RallyeCoordinatorsController@update')->name('rallyecoordinators.update');
Route::get('rallyecoordinators/delete/{id}', 'RallyeCoordinatorsController@destroy')->name('rallyecoordinators.destroy');

Route::get('/rallyeCoordinatorsExtra/{id}/AdminActiveRallyeById', 'RallyeCoordinatorsExtraController@AdminActiveRallyeById');
Route::get('/rallyeCoordinatorsExtra/{id}/ActiveRallyeById', 'RallyeCoordinatorsExtraController@ActiveRallyeById');
Route::get('/rallyeCoordinatorsExtra/{id}/ParentActiveRallyeById', 'RallyeCoordinatorsExtraController@ParentActiveRallyeById');

Route::resource('rallyeCoordinatorsExtra', 'RallyeCoordinatorsExtraController');
/* Coordinators: Extra */
Route::get('deleteAllCoordinators', 'CoordinatorsExtraController@deleteAllCoordinators');
Route::get('coordinators/{id}/resetCoordinatorPasswordById', 'CoordinatorsExtraController@resetCoordinatorPasswordById')->name('admin.acceptanceemails');
Route::get('resetCoordinatorsPassword', 'CoordinatorsExtraController@resetCoordinatorsPassword');

/* Small groups */
Route::get('smallgroups/{id}/showGroupMembersSameApplicationEvent', 'SmallGroupsController@showGroupMembersSameApplicationEvent');
Route::get('smallgroups/{id}/showGroupMembersSameApplicationGroupName', 'SmallGroupsController@showGroupMembersSameApplicationGroupName');
Route::get('smallgroups/{id}/showGroupMembers', 'SmallGroupsController@showGroupMembers');

Route::get('smallgroups', 'SmallGroupsController@index')->name('smallgroups');
Route::get('smallgroups/create', 'SmallGroupsController@create')->name('smallgroups.create');
Route::get('smallgroups/store', 'SmallGroupsController@store')->name('smallgroups.store');
Route::get('smallgroups/{id}', 'SmallGroupsController@edit')->name('smallgroups.edit');
Route::get('smallgroups/update/{id}', 'SmallGroupsController@update')->name('smallgroups.update');
Route::get('smallgroups/delete/{id}', 'SmallGroupsController@destroy')->name('smallgroups.destroy');

/* Groups */
Route::get('groups', 'GroupsController@index')->name('groups');
Route::get('groups/create', 'GroupsController@create')->name('groups.create');
Route::get('groups/store', 'GroupsController@store')->name('groups.store');
Route::get('groups/{id}', 'GroupsController@edit')->name('groups.edit');
Route::get('groups/update/{id}', 'GroupsController@update')->name('groups.update');
Route::get('groups/delete/{id}', 'GroupsController@destroy')->name('groups.destroy');

/* ApplicationsRequests */
/** Public Routes **/
Route::get('fullApplicationForm', 'ApplicationsController@fullApplicationForm');
Route::get('ApplicationRequestsController/{id}/resetParentPassword', 'ApplicationRequestsController@resetParentPassword');
Route::get('applicationrequests', 'ApplicationRequestsController@index')->name('applicationrequests');
Route::get('applicationrequests/create', 'ApplicationRequestsController@create')->name('applicationrequests.create');
Route::post('applicationrequests/store', 'ApplicationRequestsController@store')->name('applicationrequests.store');
//Route::get('applicationrequests/{id}', 'ApplicationRequestsController@edit')->name('applicationrequests.edit');

/** Private Routes **/
Route::get('applicationrequests/{id}', 'ApplicationRequestsPrivateController@edit')->name('applicationrequests.edit');
Route::get('applicationrequests/editphoto/{id}', 'ApplicationRequestsPrivateController@editChildPhoto')->name('applicationrequests.editphoto');
Route::get('applicationrequests/update/{id}', 'ApplicationRequestsPrivateController@update')->name('applicationrequests.update');
Route::post('applicationrequests/updatechildpicture', 'ApplicationRequestsPrivateController@updateChildPicture')->name('applicationrequests.updatechildpicture');
Route::get('applicationrequests/delete/{id}', 'ApplicationRequestsPrivateController@destroy')->name('applicationrequests.destroy');

Route::get('applicationrequests/{id}/SendingAcceptanceEmailId', 'ApplicationRequestsExtraController@SendingAcceptanceEmailId');
Route::get('applicationrequests/{id}/waiteApplicationById', 'ApplicationRequestsExtraController@waiteApplicationById');
Route::get('applicationrequests/{id}/blockingApplicationById', 'ApplicationRequestsExtraController@blockingApplicationById');
Route::get('applicationrequests/{id}/deBlockingApplicationById', 'ApplicationRequestsExtraController@deBlockingApplicationById');
Route::get('ResetParentPassword', 'ApplicationRequestsExtraController@ResetParentPassword');
Route::get('applicationrequests/{id}/approveApplicationById', 'ApplicationRequestsExtraController@approveApplicationById');
Route::get('/applicationExtra/{id}/ActivateMailto', 'ApplicationRequestsExtraController@ActivateMailto');
Route::get('/acceptAllApplications', 'ApplicationRequestsExtraController@acceptAllApplications');
Route::get('/rejectAllApplications', 'ApplicationRequestsExtraController@rejectAllApplications');
Route::get('deleteAllApplications', 'ApplicationRequestsExtraController@deleteAllApplications');


/* ParentEvents */
Route::get('/parentEvents/{$parent->id}/createById', 'ParentEventsController@createById');
Route::get('parentEvents', 'ParentEventsController@index')->name('parentEvents');
Route::get('parentEvents/create', 'ParentEventsController@create')->name('parentEvents.create');
Route::get('parentEvents/store', 'ParentEventsController@store')->name('parentEvents.store');
Route::get('parentEvents/{id}', 'ParentEventsController@edit')->name('parentEvents.edit');
Route::get('parentEvents/update/{id}', 'ParentEventsController@update')->name('parentEvents.update');
Route::get('parentEvents/delete/{id}', 'ParentEventsController@destroy')->name('parentEvents.destroy');

/* ParentGroups */
Route::get('/parentGroups/{$parent->id}/createById', 'ParentGroupsController@createById');
Route::get('ParentGroupsController/{id}/showGroupMembersSameApplicationEvent', 'ParentGroupsController@showGroupMembersSameApplicationEvent');
Route::get('ParentGroupsController/{id}/showGroupMembersSameApplicationGroupName', 'ParentGroupsController@showGroupMembersSameApplicationGroupName');

Route::get('parentGroups', 'ParentGroupsController@index')->name('parentGroups');
Route::get('parentGroups/create', 'ParentGroupsController@create')->name('parentGroups.create');
Route::get('parentGroups/store', 'ParentGroupsController@store')->name('parentGroups.store');
Route::get('parentGroups/{id}', 'ParentGroupsController@edit')->name('parentGroups.edit');
Route::get('parentGroups/update/{id}', 'ParentGroupsController@update')->name('parentGroups.update');
Route::get('parentGroups/delete/{id}', 'ParentGroupsController@destroy')->name('parentGroups.destroy');

/* Invitations */
Route::get('invitations', 'InvitationsController@index')->name('invitations');
Route::get('invitations/create', 'InvitationsController@create')->name('invitations.create');
Route::post('invitations/store', 'InvitationsController@store')->name('invitations.store');
Route::get('invitations/{id}', 'InvitationsController@edit')->name('invitations.edit');
Route::get('invitations/update/{id}', 'InvitationsController@update')->name('invitations.update');
Route::get('invitations/delete/{id}', 'InvitationsController@destroy')->name('invitations.destroy');

/* My Invitations */
Route::get('myinvitations', 'MyInvitationsController@index')->name('myinvitations');
Route::get('myinvitations/create', 'MyInvitationsController@create')->name('myinvitations.create');
Route::get('myinvitations/store', 'MyInvitationsController@store')->name('myinvitations.store');
Route::get('myinvitations/attending/{id}', 'MyInvitationsController@attending')->name('myinvitations.attending');
Route::get('myinvitations/notattending/{id}', 'MyInvitationsController@notattending')->name('myinvitations.notattending');
Route::get('myinvitations/delete/{id}', 'MyInvitationsController@destroy')->name('myinvitations.destroy');

/* CheckinEvent */
Route::resource('checkinEvent', 'CheckinEventExtraController');
/* Multi Checkin */
Route::get('multicheckin', 'MultiCheckinController@index')->name('multicheckin');
Route::get('multicheckin/create', 'MultiCheckinController@create')->name('multicheckin.create');
Route::get('multicheckin/store', 'MultiCheckinController@store')->name('multicheckin.store');
Route::get('multicheckin/{id}', 'MultiCheckinController@show')->name('multicheckin.show');
Route::get('/multicheckin/edit/{id}/{invitation_id}', 'MultiCheckinController@edit')->name('multicheckin.edit');
Route::get('multicheckin/attending/{id}/{invitation_id}', 'MultiCheckinController@attending')->name('multicheckin.attending');
Route::get('multicheckin/notattending/{id}/{invitation_id}', 'MultiCheckinController@notattending')->name('multicheckin.notattending');
Route::post('multicheckin/sms/{id}', 'MultiCheckinController@sendSMSMissingChildren')->name('multicheckin.sms');;

Route::get('guestsList/{id}/reminderInvitationMail', 'GuestsListController@reminderInvitationMail');

Route::resource('guestsList', 'GuestsListController');

Route::get('member/invitations', 'MembersController@invitations');

/* Admin */
Route::get('controlPanel', 'ControlPanelExtraController@controlPanel');
Route::get('accessControl/{id}/reverseAccessControlStatusById', 'AccessControlExtraController@reverseAccessControlStatusById');



/* AccessControl */
Route::resource('accessControl', 'AccessControlController');

/* SpecialAccess */
Route::resource('specialAccess', 'SpecialAccessController');

/* contacts */
Route::get('contacts', 'ContactsExtraController@contacts');

/* UserRole */
Route::resource('userRole', 'UserRoleController');

/* Rallyes: Extra */
Route::get('closeallrallyes', 'RallyesExtraController@closeAllRallyes');
Route::get('openallrallyes', 'RallyesExtraController@openAllRallyes');
Route::get('deleteAllRallyes', 'RallyesExtraController@deleteAllRallyes');
Route::get('rallyes/{id}/reverseStatusById', 'RallyesExtraController@reverseStatusById');
Route::get('rallyes/{id}/updateRallyeById', 'RallyesExtraController@updateRallyeById');
Route::get('/waitingList', 'RallyesExtraController@waitingList');
Route::get('paymentReminderList', 'RallyesExtraController@paymentReminderList');

/* Profiles */
Route::get('profiles/{id}/switchOnAdminProfileById', 'ProfilesController@switchOnAdminProfileById');
Route::get('profiles/{id}/switchOnCoordinatorProfileById', 'ProfilesController@switchOnCoordinatorProfileById');
Route::get('profiles/{id}/switchOnParentProfileById', 'ProfilesController@switchOnParentProfileById');


/* Extra Guest */
Route::resource('guests', 'GuestsController');
Route::get('extraguestsList', 'ExtraGuestsListController@index');
Route::get('extraguestsList/delete/{id}', 'ExtraGuestsListController@destroy')->name('extraguestslist.destroy');
Route::get('extraguestsList/update/{id}', 'ExtraGuestsListController@update')->name('extraguestslist.update');


/* Checkin */
Route::get('/checkin/{id}/checkIn', 'checkinExtraController@checkIn');
Route::resource('checkin', 'CheckinController');
Route::resource('checkinkids', 'CheckinMyKidsController');




/* groups: Extra */
Route::get('parentGroups/{id}/waiteParentGroupById', 'GroupsExtraController@waiteParentGroupById');
Route::get('deleteAllGroups', 'GroupsExtraController@deleteAllGroups');
/* Event groups */
Route::resource('eventGroups', 'EventGroupsController');
/* Event groups: Extra */
Route::get('deleteAllEventGroups', 'EventGroupsExtraController@deleteAllEventGroups');
/* Calendars */
Route::resource('calendars', 'CalendarsController');
/* Schools: Extra */
Route::get('deleteAllSchools', 'SchoolsExtraController@deleteAllSchools');
/* Apply */
Route::get('apply', function () {
  return redirect('apply/apply');
});
Route::get('apply/apply', 'ApplicationsController@apply')->name('apply.apply');

/* ParentChildren */
Route::resource('parentChildren', 'ParentChildrenController');
/* ParentChildrenGroup */
Route::resource('parentChildrenGroup', 'ParentChildrenGroupController');

/* Member */
Route::get('member/myrallye', 'MembersController@myRallye');
Route::get('member/mygroup', 'MembersController@myGroup');
Route::get('member/myeventgroup', 'MembersController@myEventGroup');


/* Mailing */
Route::get('sendInvitationToMyself', 'MailsController@sendInvitationToMySelf');
Route::get('sendToMyself/{id}', 'MailsController@sendToMySelf');
Route::get('sendInvitationToAllRallyeMembers', 'MailsController@sendInvitationToAllRallyeMembers');
Route::get('sendCustomMails', 'MailsController@sendCustomMails');
Route::post('sendMailToAllRallyeMembers', 'MailsController@sendMailToAllRallyeMembers');
Route::get('waitingListEmail', 'MailsController@waitingListEmail');
Route::get('paymentReminderEmail', 'MailsController@paymentReminderEmail');
Route::get('MailsController/{id}/membershipConfirmedEmail', 'MailsController@membershipConfirmedEmail');
Route::get('sendTestMail', 'MailsController@sendTestMail');

Route::resource('mails', 'MailsController');

/* Layout Format */
Route::get('layoutformat', function () {
  return redirect('layoutformat/rtl');
});
Route::get('layoutformat/rtl', 'layoutformatController@rtl')->name('layoutformat.rtl');
Route::get('layoutformat/horizontal', 'layoutformatController@horizontal')->name('layoutformat.horizontal');
Route::get('layoutformat/smallmenu', 'layoutformatController@smallmenu')->name('layoutformat.smallmenu');

/* PaymentSearchController */
Route::get('paymentsearch', 'PaymentSearchController@index')->name('paymentsearch');
Route::get('paymentsearch/create', 'PaymentSearchController@create')->name('paymentsearch.create');
Route::get('paymentsearch/find', 'PaymentSearchController@find')->name('paymentsearch.find');

/* New STRIPE with 3DSecure (SCA) */
Route::get('payments/{id}/edit', 'PaymentController@edit');
Route::get('payment', 'PaymentController@payment');
Route::post('charge', 'PaymentController@charge')->name('stripe.charge');
Route::get('confirm', 'PaymentController@confirm')->name('stripe.confirm');
Route::get('postPayment', 'PaymentController@postPayment');

Route::post('stripe/webhook', 'WebhooksController@handle');


/* Old Stripe */
// Route::get('stripe', 'StripePaymentController@stripe');
// Route::get('postPayment', 'StripePaymentController@postPayment');
// Route::get('stripe', 'StripePaymentController@stripePost')->name('stripe.get');
// Route::resource('stripes', 'StripesController');



/* KeyValues */
Route::resource('keyvalue', 'KeyValuesController');

/* Redis */
Route::get('redis', 'ConnectionCheckerController@redisTest');

/* GuestList */
Route::resource('guestLists', 'GuestsListController');

/* Upload */
Route::get('/upload', 'FileUploadController@showUploadForm');
Route::post('/upload', 'FileUploadController@storeUploads');
