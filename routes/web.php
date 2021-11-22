<?php

use App\Http\Controllers\ClientsSettingsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\useradmin\GroupController;
use App\Http\Controllers\useradmin\CompanyController;
use App\Http\Controllers\useradmin\PositionController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TranslateController;
use App\Http\Controllers\LanguageManageController;
use App\Http\Controllers\GetLanguageController;
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

Route::group(['middleware' => ['auth', 'checksinglesession'], 'prefix' => 'html5_player_api'], function () {

    Route::get('/', function () {
        echo 'Welcome html5 player api :-)';
    });

    /**
     * Adding i18n route
     */

    // GET Pictos list
    Route::get('/i18n/{languageId}', function ($languageId) {
        require_once('../html5_player_api/app/i18n/get_i18n_strings.php');
    });
    // GET Tutorial Translations
    Route::get('/tutorial/{language}/{appType}', function ($language, $appType) {
        require_once('../html5_player_api/app/i18n/get_tutorial_strings.php');
    });

    /**
     * Adding routes for Template Editor
     */

    // GET saved template datas
    Route::get('/template_editor/template/{templateId}', function ($templateId) {
        require_once('../html5_player_api/app/template_editor/get_template.php');
    });

    // GET Pictos list
    Route::get('/template_editor/pictos', function () {
        require_once('../html5_player_api/app/template_editor/get_pictos.php');
    });

    // POST template datas to save
    Route::post('/template_editor/template/{templateId}', function ($templateId) {
        require_once('../html5_player_api/app/template_editor/post_template.php');
    });

    /**
     * End Of Template Editor routes
     * */

    // Route pour afficher ou créer le json.
    Route::post('/courses/{productId}/{courseId}/json', function ($productId, $courseId) {
        require_once('../html5_player_api/app/course/courseInJson.php');
    });

    // Route pour connaitre la configuration du player par rapport à un cours
    Route::post('/courses/{productId}/{courseId}/player/config', function ($productId, $courseId) {
        require_once('../html5_player_api/app/playerConfig/playerConfig.php');
    });

    // Route pour connaitre la configuration du player pour un utilisateur
    Route::get('/courses/{sessionId}/{formationId}/{productId}/{courseId}/user/{userId}/config', function ($sessionId, $formationId, $productId, $courseId, $userId) {
        require_once('../html5_player_api/app/userCourse/userCourseConfig.php');
    });

    Route::get('/courses/{formationId}/{productId}/{courseId}/user/{userId}/config', function ($formationId, $productId, $courseId, $userId) {
        require_once('../html5_player_api/app/userCourse/userCourseConfig.php');
    });

    // Route pour enregistrer l'évaluation de l'utilisateur
    Route::post('/courses/{productId}/{courseId}/user/{userId}/screen/{screenId}/{state}/evaluation', function ($productId, $courseId, $userId, $screenId, $state) {
        require_once('../html5_player_api/app/userCourse/userCourseEvaluation.php');
    });

    Route::post('/courses/{sessionId}/{productId}/{courseId}/user/{userId}/screen/{screenId}/{state}/evaluation', function ($sessionId, $productId, $courseId, $userId, $screenId, $state) {
        require_once('../html5_player_api/app/userCourse/userCourseEvaluation.php');
    });

    // Route pour enregistrer la progression de l'utilisateur
    Route::post('/courses/{productId}/{courseId}/user/{userId}/screen/{screenId}/{state}', function ($productId, $courseId, $userId, $screenId, $state) {
        require_once('../html5_player_api/app/userCourse/userCourseProgression.php');
    });

    Route::post('/courses/{sessionId}/{productId}/{courseId}/user/{userId}/screen/{screenId}/{state}', function ($sessionId, $productId, $courseId, $userId, $screenId, $state) {
        require_once('../html5_player_api/app/userCourse/userCourseProgression.php');
    });

    // Route pour connaitre l'avancé de l'utilisateur.
    Route::get('/courses/{productId}/{courseId}/user/{userId}', function ($productId, $courseId, $userId) {
        require_once('../html5_player_api/app/userCourse/userCourseHistoric.php');
    });

    Route::get('/courses/{sessionId}/{productId}/{courseId}/user/{userId}', function ($sessionId, $productId, $courseId, $userId) {
        require_once('../html5_player_api/app/userCourse/userCourseHistoric.php');
    });

    Route::get('/progression/{productId}/user/{userId}', function ($productId, $userId) {
        require_once('../html5_player_api/app/userCourse/userProgression.php');
    });

    // Route pour créer une session à un utilisateur
    Route::get('/user/{userId}/session/courses/{productId}', function ($userId, $productId) {
        require_once('../html5_player_api/app/user/userSession.php');
    });

    // Route pour savoir si un utilisateur est connecté
    Route::get('/user/isConnect', function () {
        require_once('../html5_player_api/app/user/userIsConnect.php');
    });

    // Route pour récupérer les informations d'un utilisateur
    Route::get('/user/{userId}', function ($userId) {
        require_once('../html5_player_api/app/user/userInfos.php');
    });

    // Route for report bug
    Route::post('/report/{userId}', function ($userId) {
        require_once('../html5_player_api/app/user/userReport.php');
    });

    // Route for convert images and video
    Route::post('/ffmpeg/convert', function () {
        require_once('../html5_player_api/app/convert.php');
    });
});

Route::group(['prefix' => 'html5_player_api_'], function () {

    Route::get('/', function () {
        echo 'Welcome html5 player api :-)';
    });

    /**
     * Adding i18n route
     */

    // GET Pictos list
    Route::get('/i18n/{languageId}', function ($languageId) {
        require_once('../html5_player_api_/app/i18n/get_i18n_strings.php');
    });

    // GET Tutorial Translations
    Route::get('/tutorial/{language}/{appType}', function ($language, $appType) {
        require_once('../html5_player_api_/app/i18n/get_tutorial_strings.php');
    });

    /**
     * Adding routes for Template Editor
     */

    // GET saved template datas
    Route::get('/template_editor/template/{templateId}', function ($templateId) {
        require_once('../html5_player_api_/app/template_editor/get_template.php');
    });

    // GET Pictos list
    Route::get('/template_editor/pictos', function () {
        require_once('../html5_player_api_/app/template_editor/get_pictos.php');
    });

    // POST template datas to save
    Route::post('/template_editor/template/{templateId}', function ($templateId) {
        require_once('../html5_player_api_/app/template_editor/post_template.php');
    });

    /**
     * End Of Template Editor routes
     * */

    // Route pour afficher ou créer le json.
    Route::post('/courses/{productId}/{courseId}/json', function ($productId, $courseId) {
        require_once('../html5_player_api_/app/course/courseInJson.php');
    });

    // Route pour connaitre la configuration du player par rapport à un cours
    Route::post('/courses/{productId}/{courseId}/player/config', function ($productId, $courseId) {
        require_once('../html5_player_api_/app/playerConfig/playerConfig.php');
    });

    // Route pour connaitre la configuration du player pour un utilisateur
    Route::get('/courses/{formationId}/{productId}/{courseId}/user/{userId}/config', function ($formationId, $productId, $courseId, $userId) {
        require_once('../html5_player_api_/app/userCourse/userCourseConfig.php');
    });

    Route::get('/courses/{sessionId}/{formationId}/{productId}/{courseId}/user/{userId}/config', function ($sessionId, $formationId, $productId, $courseId, $userId) {
        require_once('../html5_player_api_/app/userCourse/userCourseConfig.php');
    });

    // Route pour enregistrer l'évaluation de l'utilisateur
    Route::post('/courses/{productId}/{courseId}/user/{userId}/screen/{screenId}/{state}/evaluation', function ($productId, $courseId, $userId, $screenId, $state) {
        require_once('../html5_player_api_/app/userCourse/userCourseEvaluation.php');
    });

    Route::post('/courses/{sessionId}/{productId}/{courseId}/user/{userId}/screen/{screenId}/{state}/evaluation', function ($sessionId, $productId, $courseId, $userId, $screenId, $state) {
        require_once('../html5_player_api_/app/userCourse/userCourseEvaluation.php');
    });

    // Route pour enregistrer la progression de l'utilisateur
    Route::post('/courses/{productId}/{courseId}/user/{userId}/screen/{screenId}/{state}', function ($productId, $courseId, $userId, $screenId, $state) {
        require_once('../html5_player_api_/app/userCourse/userCourseProgression.php');
    });

    Route::post('/courses/{sessionId}/{productId}/{courseId}/user/{userId}/screen/{screenId}/{state}', function ($sessionId, $productId, $courseId, $userId, $screenId, $state) {
        require_once('../html5_player_api_/app/userCourse/userCourseProgression.php');
    });

    // Route pour connaitre l'avancé de l'utilisateur.
    Route::get('/courses/{productId}/{courseId}/user/{userId}', function ($productId, $courseId, $userId) {
        require_once('../html5_player_api_/app/userCourse/userCourseHistoric.php');
    });

    Route::get('/courses/{sessionId}/{productId}/{courseId}/user/{userId}', function ($sessionId, $productId, $courseId, $userId) {
        require_once('../html5_player_api_/app/userCourse/userCourseHistoric.php');
    });

    Route::get('/progression/{productId}/user/{userId}', function ($productId, $userId) {
        require_once('../html5_player_api_/app/userCourse/userProgression.php');
    });

    // Route pour créer une session à un utilisateur
    Route::get('/user/{userId}/session/courses/{productId}', function ($userId, $productId) {
        require_once('../html5_player_api_/app/user/userSession.php');
    });

    // Route pour savoir si un utilisateur est connecté
    Route::get('/user/isConnect', function () {
        require_once('../html5_player_api_/app/user/userIsConnect.php');
    });

    // Route pour récupérer les informations d'un utilisateur
    Route::get('/user/{userId}', function ($userId) {
        require_once('../html5_player_api_/app/user/userInfos.php');
    });

    // Route for report bug
    Route::post('/report/{userId}', function ($userId) {
        require_once('../html5_player_api_/app/user/userReport.php');
    });
});


Route::get('/', '\App\Http\Controllers\HomeController@index');

Auth::routes();

Route::group(['middleware' => ['auth', 'checksinglesession'], 'prefix' => ''], function () {
    Route::post('updatedoublelogin', '\App\Http\Controllers\SiteSettingController@updateDoubleLogin');
    Route::get('/', '\App\Http\Controllers\admin\DashController@index');
    Route::get('changepassword', '\App\Http\Controllers\SuperAdminController@index');
    Route::post('changepassword', '\App\Http\Controllers\SuperAdminController@changePassword');
    Route::get('admindash_getdata/{id}', '\App\Http\Controllers\admin\DashController@sessionForAdminDashboard');
    Route::post('getlessonsforstudent/{id}/{session_id}', '\App\Http\Controllers\common\DashController@getLessonsForStudent');
    Route::get('home', '\App\Http\Controllers\HomeController@index')->name('home');
    Route::get('admindash', '\App\Http\Controllers\admin\DashController@index')->name('admindash');
    Route::post('setSessionForUserPage', '\App\Http\Controllers\GlobalSessionController@setToPageSetting');
    Route::post('getSessionFromUser', 'App\Http\Controllers\StudentController@getSessionFromUser');
    Route::get('dash', '\App\Http\Controllers\common\DashController@index')->name('dash');
    Route::get('student', '\App\Http\Controllers\StudentController@index')->name('student');
    Route::get('template_editor', '\App\Http\Controllers\TemplateEditorController@index')->name('template_editor');
    Route::get('player_editor', '\App\Http\Controllers\PlayerController@index')->name('player_editor');
    Route::get('fabrique_editor', '\App\Http\Controllers\FabriqueController@index')->name('fabrique_editor');
    Route::post('switchclient', '\App\Http\Controllers\PermissionController@switchClient');
    Route::get('changeLanuguage', function (Request $request) {
        session(['language' => $request->language]);
    })->name('changeLanguage');
    Route::post('searchfromdictionary', function (Request $request) {
        $request->keyword;
    })->name('searchfromdictionary');
    Route::get('superadminsettings', '\App\Http\Controllers\ClientController@index')->name('superadminsettings');
    Route::resource('languageadmin', \App\Http\Controllers\LanguageManageController::class);
    Route::resource('clients', \App\Http\Controllers\ClientController::class);

    Route::apiResources([
        'user' => StudentController::class,
        'group' => GroupController::class,
        'company' => CompanyController::class,
        'function' => PositionController::class,
        'lesson' => LessonController::class,
        'training' => TrainingController::class,
        'template' => TemplateController::class,
        'session' => SessionController::class,
        'language' =>LanguageManageController::class,
        'clientmanage'=>TranslateController::class,
    ]);
    Route::get('template', '\App\Http\Controllers\TemplateController@index')->name('template');
    Route::post('templatelinktocate', '\App\Http\Controllers\TemplateController@templateLinkTo');
    Route::post('templateduplicate', '\App\Http\Controllers\TemplateController@templateDuplicate');
    Route::post('gettemplatefromcate', '\App\Http\Controllers\TemplateController@getTemplateFromCate');

    Route::get('usercreate', '\App\Http\Controllers\StudentController@create')->name('usercreate');
    Route::post('userjointogroup', '\App\Http\Controllers\StudentController@userJoinToGroup')->name('userjointogroup');
    Route::post('userjointocompany', '\App\Http\Controllers\StudentController@userJoinToCompany')->name('userjointocompany');
    Route::post('userjointofunction', '\App\Http\Controllers\StudentController@userJoinToPosition')->name('userjointofunction');
    Route::post('student/multidelete', '\App\Http\Controllers\StudentController@multiDestroy');
    Route::post('teacher/multidelete', '\App\Http\Controllers\StudentController@multiDestroy');
    Route::post('author/multidelete', '\App\Http\Controllers\StudentController@multiDestroy');
    Route::post('getCSV', '\App\Http\Controllers\StudentController@getCSV');
    Route::post('importCSV', '\App\Http\Controllers\StudentController@importCSV');

    Route::get('training', '\App\Http\Controllers\TrainingController@index')->name('training');
    Route::post('traininglinkfromlesson', '\App\Http\Controllers\TrainingController@trainingLinkFromLesson')->name('traininglinkfromlesson');
    Route::post('trainingupdatetype', '\App\Http\Controllers\TrainingController@trainingUpdateType')->name('trainingupdatetype');
    Route::post('lesson/multidelete', '\App\Http\Controllers\TrainingController@multiDestroy');


    Route::post('trainingshow/{id}', '\App\Http\Controllers\TrainingController@getLessonFromTraining')->name('trainingshow');
    Route::post('generateScorm', '\App\Http\Controllers\TrainingController@generateScorm')->name('generateScorm');
    Route::get('/scorm/{file}', '\App\Http\Controllers\TrainingController@downloadScorm');
    Route::post('lessonshow/{id}', '\App\Http\Controllers\LessonController@getTrainingFromLesson')->name('lessonshow');

    Route::post('getPPTConfig/{id}', '\App\Http\Controllers\StudentController@getPPTConfig');

    Route::post('putOnline','\App\Http\Controllers\TrainingController@putOnline')->name('putOnline');

    Route::get('session', '\App\Http\Controllers\SessionController@index')->name('session');
    Route::post('sessionjointo', '\App\Http\Controllers\SessionController@sessionJoinTo')->name('sessionjointo');

    Route::get('report', '\App\Http\Controllers\ReportController@index')->name('report');
    Route::post('getReportList', '\App\Http\Controllers\ReportController@getReportList')->name('getReportList');
    Route::post('getReportListBySession', '\App\Http\Controllers\ReportController@getReportListBySession')->name('getReportListBySession');
    Route::post('getTemplateData', '\App\Http\Controllers\ReportController@getTemplateData')->name('getTemplateData');
    Route::post('saveTemplateData', '\App\Http\Controllers\ReportController@saveTemplateData')->name('saveTemplateData');
    Route::post('delTemplate', '\App\Http\Controllers\ReportController@delTemplate')->name('delTemplate');
    Route::post('getBlockHTML', '\App\Http\Controllers\ReportController@getBlockHTML')->name('getBlockHTML');
    Route::post('saveReportImg', '\App\Http\Controllers\ReportController@saveReportImg')->name('saveReportImg');
    Route::post('getStudentsList', '\App\Http\Controllers\ReportController@getStudentsList')->name('getStudentsList');
    Route::post('getReportData', '\App\Http\Controllers\ReportController@getReportData')->name('getReportData');
    Route::post('downloadReportPDF', '\App\Http\Controllers\ReportController@downloadReportPDF')->name('downloadReportPDF');
    Route::post('downloadReportZip', '\App\Http\Controllers\ReportController@downloadReportZip')->name('downloadReportZip');
    Route::get('/pdf/{file}', '\App\Http\Controllers\ReportController@getPDFContents');
    Route::get('/zip/{file}', '\App\Http\Controllers\ReportController@downloadZip');
    Route::post('delReport', '\App\Http\Controllers\ReportController@delReport')->name('delReport');
    Route::post('delReports', '\App\Http\Controllers\ReportController@delReports')->name('delReports');

    Route::get('sendmail', '\App\Http\Controllers\SendmailController@index')->name('sendmail');
    Route::post('getMailHistories', '\App\Http\Controllers\SendmailController@getMailHistories')->name('getMailHistories');
    Route::post('getMailTemplate', '\App\Http\Controllers\SendmailController@getMailTemplate')->name('getMailTemplate');
    Route::post('saveMailTemplate', '\App\Http\Controllers\SendmailController@saveMailTemplate')->name('saveMailTemplate');
    Route::post('delMailTemplate', '\App\Http\Controllers\SendmailController@delMailTemplate')->name('delMailTemplate');
    Route::post('delMailHistory', '\App\Http\Controllers\SendmailController@delMailHistory')->name('delMailHistory');
    Route::post('delMultiHistories', '\App\Http\Controllers\SendmailController@delMultiHistories')->name('delMultiHistories');
    Route::post('saveMailImg', '\App\Http\Controllers\SendmailController@saveMailImg')->name('saveMailImg');
    Route::post('getUserInfo', '\App\Http\Controllers\SendmailController@getUserInfo')->name('getUserInfo');
    Route::post('mailsend', '\App\Http\Controllers\SendmailController@mailsend')->name('mailsend');
    Route::post('insertMailHistory', '\App\Http\Controllers\SendmailController@insertMailHistory')->name('insertMailHistory');
    Route::post('updatelanguage', '\App\Http\Controllers\LanguageManageController@updateLanguage');
    
    // Route::post('publishtemplate', '\App\Http\Controllers\TemplateController@publishTemplate');
    // Route::get('searchtranslate', '\App\Http\Controllers\ClientController@searchTranslate');

    Route::get('clear_cache', function () {

        \Artisan::call('cache:clear');
        \Artisan::call('view:clear');
    
        dd("Cache is cleared");
    });

});

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('getlanguagesforlesson/{data}', '\App\Http\Controllers\GetLanguageController@getRouteId');
