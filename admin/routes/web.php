<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/contact', 'ContactController@contact')->name('contact');
Route::get('/about', 'ContactController@about')->name('about');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['web']],function() {
    Route::get('user/chat-list/{id}', 'ChatboxController@index');
    Route::post('user/chat-add', 'ChatboxController@insert');
    Route::get('doctor/chat-list/{id}', 'ChatboxController@doctor_chat_list');
    Route::post('doctor/chat-add', 'ChatboxController@doctor_chat_insert');
    Route::get('doctor/patient-case/{id}', 'DoctorController@patient_case');
    Route::get('doctor/update_redirection/{id}', 'DoctorController@update_redirection');
    Route::get('doctor/testinsert', 'DoctorController@testinsert');
    
    Route::get('doctor/calendar/{id}', 'DoctorController@calendar')->name('doctor.calendar');
    Route::post('doctor/get-one-booking', 'DoctorController@get_one_booking_details')->name('doctor.get_one_booking');
    Route::get('doctor/booking/{id}', 'DoctorController@booking')->name('doctor.booking');
    Route::get('doctor/digital-prescription/{id}', 'DoctorController@digitalPrescription')->name('doctor.digital_prescription');
    Route::get('doctor/follow-up/{id}', 'DoctorController@followUp')->name('doctor.follow_up');
    Route::get('doctor/update-follow', 'DoctorController@updateFollowup')->name('doctor.update_followup');
    
    Route::get('doctor/smart-prescription/{id}', 'DoctorController@prescription')->name('doctor.smart_prescription');
    Route::get('doctor/delete-prescription/{id}', 'DoctorController@prescriptionDelete')->name('doctor.delete_prescription');
    
    Route::get('doctor/delete-instruction/{id}', 'DoctorController@instructionDelete')->name('doctor.delete_instruction');
    Route::post('doctor/add-instruction', 'DoctorController@addInstruction')->name('doctor.add-instruction');
    
    Route::get('doctor/delete-test/{id}', 'DoctorController@testDelete')->name('doctor.delete_test');
    Route::post('doctor/add-test', 'DoctorController@addtest')->name('doctor.add-test');
    
    Route::get('doctor/delete-diagnosis/{id}', 'DoctorController@diagnosisDelete')->name('doctor.delete_diagnosis');
    Route::post('doctor/add-diagnosis', 'DoctorController@addDiagnosisTest')->name('doctor.add-diagnosis');
    
    Route::post('doctor/add_edit_complaints', 'DoctorController@addEditComplaints')->name('doctor.add-edit-complaints');
    Route::get('doctor/delete_complaints/{id}', 'DoctorController@deleteComplaints')->name('doctor.delete-complaints');
    
    Route::get('casesheet', 'DoctorController@index')->name('doctor.casesheet.index');
    Route::post('casesheet/add-vital', 'DoctorController@addVital')->name('doctor.casesheet.add-vital');
    Route::post('casesheet/add-family-history', 'DoctorController@addFamilyHistory')->name('doctor.casesheet.add-family-history');
    Route::post('casesheet/add-dr-notes', 'DoctorController@addDrNotes')->name('doctor.casesheet.add-dr-notes');
    Route::post('casesheet/add-patient-condition', 'DoctorController@addPatientCondition')->name('doctor.casesheet.add-patient-condition');
    Route::post('casesheet/add-patient-medication', 'DoctorController@addPatientMedication')->name('doctor.casesheet.add-patient-medication');
    Route::post('casesheet/add-patient-test', 'DoctorController@addPatientTest')->name('doctor.casesheet.add-patient-test');
    Route::post('casesheet/add-patient-followup', 'DoctorController@addPatientFollowup')->name('doctor.casesheet.add-patient-followup');
    Route::post('casesheet/add-patient-advice', 'DoctorController@addPatientAdvice')->name('doctor.casesheet.add-patient-advice');
    Route::post('casesheet/add-prescription', 'DoctorController@addPrescription')->name('doctor.casesheet.add-prescription');
    Route::post('casesheet/add-patient-chiefcomplaint', 'DoctorController@addPatientChiefComplaint')->name('doctor.casesheet.add-patient-chiefcomplaint');
    Route::get('doctor/patient-complaint-delete/{id}', 'DoctorController@patientComplaintDelete')->name('doctor.delete-complaint');
    
    Route::get('doctor/patient-chief-complaints', 'DoctorController@chiefComplaint')->name('doctor.chief-complaints');
    Route::get('doctor/patient-history-view', 'DoctorController@patientHistoryView')->name('doctor.view-history');
    Route::get('doctor/patient-health-view', 'DoctorController@patientHealthView')->name('doctor.view-patient-health');
    Route::get('doctor/patient-notes-view', 'DoctorController@patientNotesView')->name('doctor.view-patient-notes');

    Route::get('doctor/patient-condition-view', 'DoctorController@patientConditionView')->name('doctor.view-patient-condition');
    Route::get('doctor/patient-condition-delete/{id}', 'DoctorController@patientConditionDelete')->name('doctor.delete-condition');
    
    Route::get('doctor/patient-medicine-view', 'DoctorController@patientMedicineView')->name('doctor.view-patient-medicine');
    Route::get('doctor/patient-medicine-delete/{id}', 'DoctorController@patientMedicineDelete')->name('doctor.delete-medicine');
    
    Route::get('doctor/patient-diagnosis-view', 'DoctorController@patientDiagnosisView')->name('doctor.view-patient-diagnosis');
    Route::get('doctor/patient-diagnosis-delete/{id}', 'DoctorController@patientDiagnosisDelete')->name('doctor.view-patient-delete');
    
    Route::get('doctor/patient-followup-view', 'DoctorController@patientFollowupView')->name('doctor.view-patient-followup');
    Route::get('doctor/patient-advice-view', 'DoctorController@patientAdviceView')->name('doctor.view-patient-advice');
});

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin'], function() {
    Route::get('home', 'HomeController@adminHome')->name('admin.home')->middleware('is_admin');
    Route::get('user', 'UserController@index')->name('admin.user')->middleware('is_admin');
    Route::get('user/{id}/edit', 'UserController@edit');
    Route::get('user/{id}/delete', 'UserController@delete');
    Route::post('user/update/{id}', 'UserController@update');
    
    Route::get('doctor', 'UserController@doctor_index')->name('admin.doctor')->middleware('is_admin');
    Route::get('doctor/{id}/show', 'UserController@show');
    Route::get('doctor/chat-list', 'UserController@chat');
    Route::get('doctor/chat-with-client/{id}', 'UserController@chatWithClient');
    Route::post('doctor/chat-add', 'UserController@admin_chat_insert');
    
    Route::get('basic_info', 'BasicinfoController@index')->name('admin.basic_info')->middleware('is_admin');
    Route::get('basic_info/{id}/edit', 'BasicinfoController@edit');
    Route::post('basic_info/update/{id}', 'BasicinfoController@update');
    Route::get('basic_info/{id}/destroy', 'BasicinfoController@destroy');

    Route::get('space_info', 'SpaceinfoController@index')->name('admin.sapce_info')->middleware('is_admin');
    Route::get('space_info/{id}/edit', 'SpaceinfoController@edit');
    Route::post('space_info/update/{id}', 'SpaceinfoController@update');
    Route::get('space_info/{id}/destroy', 'SpaceinfoController@destroy');

    Route::get('space', 'SpaceController@index')->name('admin.sapce')->middleware('is_admin');
    Route::get('space/{id}/edit', 'SpaceController@edit');
    Route::post('space/update/{id}', 'SpaceController@update');
    Route::get('space/{id}/destroy', 'SpaceController@destroy');

    Route::get('property', 'PropertyController@index')->name('admin.property')->middleware('is_admin');
    Route::get('property/{id}/edit', 'PropertyController@edit');
    Route::post('property/update/{id}', 'PropertyController@update');
    Route::get('property/{id}/destroy', 'PropertyController@destroy');

    Route::get('feature_list', 'FeaturelistController@index')->name('admin.feature_list.index');
    Route::get('feature_list/create', 'FeaturelistController@create')->name('admin.feature_list.create');
    Route::post('feature_list', 'FeaturelistController@store')->name('admin.feature_list.store');    
    Route::get('feature_list/{id}/edit', 'FeaturelistController@edit')->name('admin.feature_list.edit');
    Route::put('feature_list/{id}', 'FeaturelistController@update')->name('admin.feature_list.update');
    Route::get('feature_list/{id}', 'FeaturelistController@show')->name('admin.feature_list.show');
    Route::delete('feature_list/{id}', 'FeaturelistController@destroy')->name('admin.feature_list.destroy');

    Route::get('plan', 'PlanController@index')->name('admin.plan.index');
    Route::get('plan/create', 'PlanController@create')->name('admin.plan.create');
    Route::post('plan', 'PlanController@store')->name('admin.plan.store');    
    Route::get('plan/{id}/edit', 'PlanController@edit')->name('admin.plan.edit');
    Route::put('plan/{id}', 'PlanController@update')->name('admin.plan.update');
    Route::get('plan/{id}', 'PlanController@show')->name('admin.plan.show');
    Route::delete('plan/{id}', 'PlanController@destroy')->name('admin.plan.destroy');


    Route::get('service', 'ServiceController@index')->name('admin.service.index');
    Route::get('service/create', 'ServiceController@create')->name('admin.service.create');
    Route::post('service', 'ServiceController@store')->name('admin.service.store');    
    Route::get('service/{id}/edit', 'ServiceController@edit')->name('admin.service.edit');
    Route::put('service/{id}', 'ServiceController@update')->name('admin.service.update');
    Route::get('service/{id}', 'ServiceController@show')->name('admin.service.show');
    Route::delete('service/{id}', 'ServiceController@destroy')->name('admin.service.destroy');


    Route::get('enquiry', 'EnquiryController@index')->name('admin.enquiry.index');
    Route::get('enquiry/{id}/edit', 'EnquiryController@edit')->name('admin.enquiry.edit');
    Route::put('enquiry/{id}', 'EnquiryController@update')->name('admin.enquiry.update');
    Route::get('enquiry/{id}', 'EnquiryController@show')->name('admin.enquiry.show');
    Route::delete('enquiry/{id}', 'EnquiryController@destroy')->name('admin.enquiry.destroy');

    Route::get('spacenq', 'SpacenqController@index')->name('admin.spacenq.index');
    Route::get('spacenq/{id}/edit', 'SpacenqController@edit')->name('admin.spacenq.edit');
    Route::put('spacenq/{id}', 'SpacenqController@update')->name('admin.spacenq.update');
    Route::get('spacenq/{id}', 'SpacenqController@show')->name('admin.spacenq.show');
    Route::delete('spacenq/{id}', 'SpacenqController@destroy')->name('admin.spacenq.destroy');



    Route::get('space_plan', 'SpaceplanController@index')->name('admin.space_plan.index');
    Route::get('space_plan/create', 'SpaceplanController@create')->name('admin.space_plan.create');
    Route::post('space_plan', 'SpaceplanController@store')->name('admin.space_plan.store');    
    Route::get('space_plan/{id}/edit', 'SpaceplanController@edit')->name('admin.space_plan.edit');
    Route::put('space_plan/{id}', 'SpaceplanController@update')->name('admin.space_plan.update');
    Route::get('space_plan/{id}', 'SpaceplanController@show')->name('admin.space_plan.show');
    Route::delete('space_plan/{id}', 'SpaceplanController@destroy')->name('admin.space_plan.destroy');

    Route::get('booking', 'BookingController@index')->name('admin.booking.index');
    Route::get('booking/create', 'BookingController@create')->name('admin.booking.create');
    Route::post('booking', 'BookingController@store')->name('admin.booking.store');    
    Route::get('booking/{id}/edit', 'BookingController@edit')->name('admin.booking.edit');
    Route::put('booking/{id}', 'BookingController@update')->name('admin.booking.update');
    Route::get('booking/{id}', 'BookingController@show')->name('admin.booking.show');
    Route::delete('booking/{id}', 'BookingController@destroy')->name('admin.booking.destroy');

    Route::get('booking_cancel', 'BookingDetailController@indexCancel')->name('admin.booking_cancel.indexCancel');
    Route::get('booking_cancel/{id}', 'BookingDetailController@showCancel')->name('admin.booking_cancel.showCancel');
    Route::get('booking_cancel/{id}/edit', 'BookingDetailController@editCancel')->name('admin.booking_cancel.editCancel');
    Route::put('booking_cancel/{id}', 'BookingDetailController@updateCancel')->name('admin.booking_cancel.updateCancel');

    Route::get('booking_detail', 'BookingDetailController@index')->name('admin.booking_detail.index');
    Route::get('booking_detail/{id}', 'BookingDetailController@show')->name('admin.booking_detail.show');

    Route::get('report_settlement', 'ReportController@indexSettle')->name('admin.report.indexSettle');

    //  ********************* Blood Test routes****************************  //
    Route::get('test', 'TestController@index')->name('admin.test.index');
    Route::get('test/create', 'TestController@create')->name('admin.test.create');
    Route::post('test', 'TestController@store')->name('admin.test.store');    
    Route::get('test/{id}/edit', 'TestController@edit')->name('admin.test.edit');
    Route::put('test/{id}', 'TestController@update')->name('admin.test.update');
    Route::get('test/{id}', 'TestController@show')->name('admin.test.show');
    Route::delete('test/{id}', 'TestController@destroy')->name('admin.test.destroy');

    //  ********************* Medicine routes****************************  //
    Route::get('medicine', 'MedicineController@index')->name('admin.medicine.index');
    Route::get('medicine/create', 'MedicineController@create')->name('admin.medicine.create');
    Route::post('medicine', 'MedicineController@store')->name('admin.medicine.store');    
    Route::get('medicine/{id}/edit', 'MedicineController@edit')->name('admin.medicine.edit');
    Route::put('medicine/{id}', 'MedicineController@update')->name('admin.medicine.update');
    Route::get('medicine/{id}', 'MedicineController@show')->name('admin.medicine.show');
    Route::delete('medicine/{id}', 'MedicineController@destroy')->name('admin.medicine.destroy');

    //  ********************* Condition routes****************************  //
    Route::get('condition', 'ConditionController@index')->name('admin.condition.index');
    Route::get('condition/create', 'ConditionController@create')->name('admin.condition.create');
    Route::post('condition', 'ConditionController@store')->name('admin.condition.store');    
    Route::get('condition/{id}/edit', 'ConditionController@edit')->name('admin.condition.edit');
    Route::put('condition/{id}', 'ConditionController@update')->name('admin.condition.update');
    Route::get('condition/{id}', 'ConditionController@show')->name('admin.condition.show');
    Route::delete('condition/{id}', 'ConditionController@destroy')->name('admin.condition.destroy');
   
    //  ********************* Frequently_used_instruction routes****************************  //
    Route::get('instruction', 'InstructionController@index')->name('admin.instruction.index');
    Route::get('instruction/create', 'InstructionController@create')->name('admin.instruction.create');
    Route::post('instruction', 'InstructionController@store')->name('admin.instruction.store');    
    Route::get('instruction/{id}/edit', 'InstructionController@edit')->name('admin.instruction.edit');
    Route::put('instruction/{id}', 'InstructionController@update')->name('admin.instruction.update');
    Route::get('instruction/{id}', 'InstructionController@show')->name('admin.instruction.show');
    Route::delete('instruction/{id}', 'InstructionController@destroy')->name('admin.instruction.destroy');
   
    //  ********************* Case Sheet routes****************************  //
    Route::get('casesheet', 'CasesheetController@index')->name('admin.casesheet.index');
    // Route::get('instruction/create', 'InstructionController@create')->name('admin.instruction.create');
    // Route::post('instruction', 'InstructionController@store')->name('admin.instruction.store');    
    // Route::get('instruction/{id}/edit', 'InstructionController@edit')->name('admin.instruction.edit');
    // Route::put('instruction/{id}', 'InstructionController@update')->name('admin.instruction.update');
    // Route::get('instruction/{id}', 'InstructionController@show')->name('admin.instruction.show');
    // Route::delete('instruction/{id}', 'InstructionController@destroy')->name('admin.instruction.destroy');
});

