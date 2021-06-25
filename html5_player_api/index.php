<?php
//Access-Control-Allow-Origin header with wildcard.
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS');

include($_SERVER['DOCUMENT_ROOT']."/_mixte/html/config/config.php");
// Include router class
include('inc/router.class.php');
// Add base route (startpage)
Route::add('/',function(){
  echo 'Welcome html5 player api :-)';
});

/**
 * Adding i18n route
 */

// GET Pictos list
Route::add( '/i18n/(.*)', function ( $languageId )
{
  require_once( 'app/i18n/get_i18n_strings.php' );
}, array( 'get','options' ) );
// GET Tutorial Translations
Route::add( '/tutorial/(.*)/(.*)', function ( $language, $appType )
{
  require_once( 'app/i18n/get_tutorial_strings.php' );
}, array( 'get','options' ) );

/**
 * End Of i18n route
 *
*/

/**
 * Adding routes for Template Editor
*/

// GET saved template datas
Route::add( '/template_editor/template/(.*)', function ( $templateId )
{
  require_once( 'app/template_editor/get_template.php' );
}, array( 'get','options' ) );

// GET Pictos list
Route::add( '/template_editor/pictos', function ()
{
  require_once( 'app/template_editor/get_pictos.php' );
}, array( 'get','options' ) );

// POST template datas to save
Route::add( '/template_editor/template/(.*)', function ( $templateId )
{
  require_once( 'app/template_editor/post_template.php' );
}, array( 'post','options' ) );

/**
 * End Of Template Editor routes
 * */

// Route pour afficher ou créer le json.
Route::add('/courses/(.*)/(.*)/json',function($productId, $courseId){
    require_once('app/course/courseInJson.php');
}, array( 'post','options' ) );

// Route pour connaitre la configuration du player par rapport à un cours
Route::add('/courses/(.*)/(.*)/player/config',function($productId, $courseId){
    require_once('app/playerConfig/playerConfig.php');
}, array( 'post','options' ) );

// Route pour connaitre la configuration du player pour un utilisateur
Route::add('/courses/(.*)/(.*)/(.*)/user/(.*)/config',function($formationId, $productId, $courseId, $userId){
  require_once('app/userCourse/userCourseConfig.php');
}, array( 'get','options' ) );

// Route pour enregistrer l'évaluation de l'utilisateur
Route::add('/courses/(.*)/(.*)/user/(.*)/screen/(.*)/(.*)/evaluation',function($productId, $courseId, $userId, $screenId, $state){
  require_once('app/userCourse/userCourseEvaluation.php');
}, array( 'post','options' ) );

// Route pour enregistrer la progression de l'utilisateur
Route::add('/courses/(.*)/(.*)/user/(.*)/screen/(.*)/(.*)',function($productId, $courseId, $userId, $screenId, $state){
  require_once('app/userCourse/userCourseProgression.php');
}, array( 'post','options' ) );

// Route pour connaitre l'avancé de l'utilisateur.
Route::add('/courses/(.*)/(.*)/user/(.*)',function($productId, $courseId, $userId){
  require_once('app/userCourse/userCourseHistoric.php');
}, array( 'get','options' ) );

Route::add('/progression/(.*)/user/(.*)',function($productId, $userId){
  require_once('app/userCourse/userProgression.php');
}, array( 'get','options' ) );

// Route pour créer une session à un utilisateur
Route::add('/user/(.*)/session/courses/(.*)',function($userId,$productId){
  require_once('app/user/userSession.php');
}, array( 'get','options' ) );

// Route pour savoir si un utilisateur est connecté
Route::add('/user/isConnect',function(){
  require_once('app/user/userIsConnect.php');
}, array( 'get','options' ) );

// Route pour récupérer les informations d'un utilisateur
Route::add('/user/(.*)',function($userId){
  require_once('app/user/userInfos.php');
}, array( 'get','options' ) );

// Route for report bug
Route::add('/report/(.*)',function($userId){
  require_once('app/user/userReport.php');
}, array( 'post','options' ) );

// Add a 404 not found route
Route::pathNotFound(function($path){
  $return['state'] = 'error';
  $return['msg'] = 'Error 404 :-( || The requested path "'.$path.'" was not found!';
  $return['datas'] = null;
  header('Content-Type: application/json');
  echo json_encode($return);
});

// Add a 405 method not allowed route
Route::methodNotAllowed(function($path, $method){
    $return['state'] = 'error';
    $return['msg'] = 'Error 405 :-( || The requested path "'.$path.'" exists. But the request method "'.$method.'" is not allowed on this path!';
    $return['datas'] = null;
    header('Content-Type: application/json');
    echo json_encode($return);
});

Route::run('/html5_player_api');
?>
