<?php 


include 'loader.php';
require_once __DIR__.'/../vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app['debug'] = true;
// ... definitions
$app->before(function (Request $request) {
    if (strpos($request->getPathInfo(),'/auth') === false){
        $token = $request->headers->get('Auth-token');
        if (!$token) {
            $response = new Response();
            $response->setStatusCode(401);
            $response->headers->set("Content-type","application/json");
            $response->setContent("{\"error\":\"vous n'êtes pas autorisé à effectuer cette action\"}");
            return $response;
        } else {
            $auth = new Auth();
            if (!$auth->isValid($token) || !$auth->haveDroit($request->getPathInfo(),$token)){
                $response = new Response();
                $response->setStatusCode(401);
                $response->headers->set("Content-type","application/json");
                $response->setContent("{\"error\":\"vous n'êtes pas autorisé à effectuer cette action\"}");
                return $response;
            }
        }
    }
});

$app->error(function (\Exception $e, Request $request, $code) {
    if ($request->getMethod() !== "OPTIONS") {
        $file = fopen("./logs/log_" . time() . ".txt", "w");
        fwrite($file, $request);
        fwrite($file, "\npath info : " . $request->getPathInfo());
        fwrite($file, "\nError message : " . $e->getMessage());
        fwrite($file, "\nError: ");
        fwrite($file, $e);
        fclose($file);
    }
    if ($e->getCode() === 0 ){
        return new Response("{\"error\":\"".$e->getMessage()."\"}",$code);
    }
    return new Response("{\"error\":\"".$e->getMessage()."\"}",$e->getCode());
});

$app->after(function (Request $request, Response $response){
    if ($request->getMethod() === 'OPTIONS'){
        $response->setStatusCode(200);
    }
    $response->headers->set("Access-Control-Allow-Origin","*");
    $response->headers->set("Access-Control-Allow-Headers","*");
    $response->headers->set("Access-Control-Allow-Methods","*");
});

/**
 *  AUTH SERVICE
 */
$app->post('/auth/login',  function (Request $request) {
    $data = json_decode($request->getContent(), true);
	$username = $data['username'];
	$password = $data['password'];
    $auth = new auth();
    $token = $auth->login($username, $password);
    return created($token);
});

$app->get('/infos',  function (Request $request) {
    $tokenUuid = $request->headers->get('Auth-token');
    $auth = new Auth();
    $droitApplication = new DroitApplication();
    $role = $auth->getRole($tokenUuid);
    $droits = $droitApplication->getByRole($role->id);
    return ok(new InfosDTO($role, $droits));
});

$app->get('/user', function(Request $request){
    $tokenUuid = $request->headers->get('Auth-token');
    $userApplication = new UserApplication();
    return ok($userApplication->getByToken($tokenUuid));
});

$app->post('/user/password', function(Request $request){
    $tokenUuid = $request->headers->get('Auth-token');
    $data = json_decode($request->getContent(), true);
    $command = ChangePasswordCommand::init($data);

    $userApplication = new UserApplication();
    $userApplication->changePassword($tokenUuid, $command);
    return created("");
});

/**
 *  FIN  AUTH SERVICE
 */

/**
 * ADMIN SERVICE
 */

$app->get('admin/role', function(){
    $roleApplication = new RoleApplication();
    return ok($roleApplication->getAll());
});

$app->get('admin/droit', function(){
    $droitApplication = new DroitApplication();
    return ok($droitApplication->getAll());
});

$app->get('admin/role/{idRole}/droit', function($idRole){
    $droitApplication = new DroitApplication();
    return ok($droitApplication->getByRole($idRole));

});

$app->get('admin/droit/{idDroit}/role', function($idDroit){
    $roleApplication = new RoleApplication();
    return ok($roleApplication->getByDroit($idDroit));

});

$app->get('admin/user', function(){
    $userApplication = new UserApplication();
    return ok($userApplication->getAll());
});

$app->delete('admin/user/{idUser}', function($idUser){
    $userApplication = new UserApplication();
    return ok($userApplication->delete($idUser));
});


$app->post('admin/user',  function (Request $request) {
    $data = json_decode($request->getContent(), true);
    $commande = CreateUserCommnad::init($data);

    $userApplication = new UserApplication();
    $userApplication->create($commande);
    return created("");
});

$app->post('admin/role/{idRole}/droit',  function ($idRole,Request $request) {
    $data = json_decode($request->getContent(), true);
    $commande = AddRemoveDroitCommand::init($data, $idRole);

    $roleApplication = new RoleApplication();
    $roleApplication->addRole($commande);
    return created("");
});

$app->get('admin/user/{idUser}', function ($idUser){
    $userApplication = new UserApplication();

    return ok($userApplication->getById($idUser));
});

$app->patch('admin/user/{idUser}', function ($idUser,Request $request ){
    $data = json_decode($request->getContent(), true);
    $commande = UpdateUserCommand::init($data);

    $userApplication = new UserApplication();
    $userApplication->update($idUser, $commande);
    return ok("");
});
$app->patch('admin/user/{idUser}/password', function ($idUser,Request $request ){
    $data = json_decode($request->getContent(), true);

    $userApplication = new UserApplication();
    $userApplication->resetPassword($idUser, $data["password"]);
    return ok("");
});


$app->delete('admin/role/{idRole}/droit/{idDroit}',  function ($idRole, $idDroit) {
    $commande = AddRemoveDroitCommand::initDelete($idDroit, $idRole);

    $roleApplication = new RoleApplication();
    $roleApplication->removeRoleAction($commande);
    return ok("");
});


$app->delete('admin/role/{idRole}',  function ($idRole) {

    $roleApplication = new RoleApplication();
    $roleApplication->deleteRole($idRole);
    return ok("");
});


$app->post('admin/role',  function (Request $request) {
    $data = json_decode($request->getContent(), true);
    $commande = CreateRoleCommand::init($data);

    $roleApplication = new RoleApplication();
    $roleApplication->createRole($commande);
    return created("");
});

/**
 * FIN ADMIN SERVICE
 */

/**
 *  Adherent SERVICE
 */

$app->get('adherent/search/{nomPrenom}', function ($nomPrenom,Request $request) {
    $adherentApplication = new AdherentApplication();
    if (isset($_GET["inscrit"])) {
        if ($_GET["inscrit"] === "false") {
            $adherents = $adherentApplication->getByNameWithoutInscription($nomPrenom);
        } else {
            if ($nomPrenom === 'valueNull'){
                $nomPrenom = "";
            }
            $adherents = $adherentApplication->getByNameWithParam($nomPrenom, $_GET);
        }
    } else {
        $adherents = $adherentApplication->getByName($nomPrenom);
    }
    return ok($adherents);
});

$app->get('adherent/{id}', function ($id,Request $request) {
    $adherentApplication = new AdherentApplication();

    return ok($adherentApplication->getById($id));
});

$app->patch('adherent/{id}', function ($id,Request $request) {
    $adherentApplication = new AdherentApplication();
    $data = json_decode($request->getContent(), true);
    $commande = UpdateAdherentCommand::init($id, $data);
    $adherentApplication->update($commande);
    return ok("");
});

/**
 *  FIN Adherent SERVICE
 */

/**
 *  PAIEMENT SERVICE
 */

$app->get('paiement/search/{nomPayeur}', function ($nomPayeur) {
    $paiementApplication = new PaiementApplication();
    $adherents = $paiementApplication->getByName($nomPayeur);
    return ok($adherents);
});

$app->get('inscription/{idInscription}/paiement', function ($idInscription) {
    $paiementApplication = new PaiementApplication();
    return ok($paiementApplication->getByIdInscription($idInscription));
});

/**
 *  FIN PAIEMENT SERVICE
 */

/**
 *  COURS SERVICE
 */
$app->get('cours/', function (){
    $coursApplication = new CoursApplication();
    $cours = $coursApplication->getAllCours();
    return ok($cours);
});

$app->get('cours/{id}', function ($id){
    $coursApplication = new CoursApplication();
    $cours = $coursApplication->getById($id);
    return ok($cours);
});

$app->patch('cours/{id}', function ($id, Request $request){
    $data = json_decode($request->getContent(), true);
    $commande = UpdateCoursCommand::init($id,$data);

    $coursApplication = new CoursApplication();
    $coursApplication->update($commande);
    return ok("");
});

$app->delete('cours/{id}', function ($id){
    $coursApplication = new CoursApplication();
    $coursApplication->delete($id);
    return ok("");
});

$app->get('cours/{id}/adherent', function ($id){
    $adherentApplication = new AdherentApplication();
    return ok($adherentApplication->getByCoursId($id));
});

$app->post('cours/', function (Request $request){
    $data = json_decode($request->getContent(), true);
    $commande = CreateCoursCommand::init($data);

    $coursApplication = new CoursApplication();
    $coursApplication->create($commande);
    return created("");
});

/**
 *  FIN COURS SERVICE
 */

/**
 *  TYPECOURS SERVICE
 */
$app->get('typeCours/', function (){
    $typeCoursApplication = new TypeCoursApplication();
    $typeCours = $typeCoursApplication->getAll();
    return ok($typeCours);
});

$app->post('typeCours/', function (Request $request){
    $data = json_decode($request->getContent(), true);
    $commande = CreateTypeCoursCommand::init($data);

    $typeCoursApplication = new TypeCoursApplication();
    $typeCoursApplication->create($commande);
    return created("");
});

$app->delete('typeCours/{id}', function ($id){
    $typeCoursApplication = new TypeCoursApplication();
    $typeCoursApplication->delete($id);
    return created("");
});

$app->get('typeCours/{id}', function ($id){
    $typeCoursApplication = new TypeCoursApplication();
    $typeCours = $typeCoursApplication->getById($id);
    return ok($typeCours);
});
$app->patch('typeCours/{id}', function ($id, Request $request){
    $data = json_decode($request->getContent(), true);
    $commande = CreateTypeCoursCommand::init($data);

    $typeCoursApplication = new TypeCoursApplication();
    $typeCoursApplication->update($id, $commande->libelle);
    return created("");
});

/**
 *  FIN TYPECOURS SERVICE
 */

/**
 *  SALLE SERVICE
 */
$app->get('salle/', function (){
    $salleApplication = new SalleApplication();
    $salles = $salleApplication->getAll();
    return ok($salles);
});

$app->post('salle/', function (Request $request){
    $data = json_decode($request->getContent(), true);
    $commande = CreateSalleCommand::init($data);

    $salleApplication = new SalleApplication();
    $salleApplication->create($commande);
    return created("");
});

$app->delete('salle/{id}', function ($id){
    $salleApplication = new SalleApplication();
    $salleApplication->delete($id);
    return created("");
});

$app->get('salle/{id}', function ($id){
    $salleApplication = new SalleApplication();
    $salle = $salleApplication->getById($id);
    return ok($salle);
});
$app->patch('salle/{id}', function ($id, Request $request){
    $data = json_decode($request->getContent(), true);
    $commande = CreateSalleCommand::init($data);

    $salleApplication = new SalleApplication();
    $salleApplication->update($id, $commande->libelle, $commande->capacite);
    return created("");
});

/**
 *  FIN TYPECOURS SERVICE
 */

/**
 *  FIN PAIEMENT SERVICE
 */

/**
 *  Prof SERVICE
 */
$app->get('prof/', function (){
    $profApplication = new ProfApplication();
    $profs = $profApplication->getAll();
    return ok($profs);
});
$app->get('prof/{id}', function ($id){
    $profApplication = new ProfApplication();
    $prof = $profApplication->getById($id);
    return ok($prof);
});

$app->patch('prof/{id}', function ($id, Request $request){
    $data = json_decode($request->getContent(), true);
    $commande = UpdateProfCommand::init($id,$data);

    $profApplication = new ProfApplication();
    $profApplication->update($commande);
    return ok("");
});

$app->delete('prof/{id}', function ($id){
    $profApplication = new ProfApplication();
    $profApplication->delete($id);
    return ok("");
});

$app->get('prof/{id}/cours', function ($id){
    $coursApplication = new CoursApplication();
    return ok($coursApplication->getByProf($id));
});

$app->post('prof/', function (Request $request){
    $data = json_decode($request->getContent(), true);
    $commande = CreateProfCommand::init($data);

    $profApplication = new ProfApplication();
    $profApplication->create($commande);
    return created("");
});

/**
 *  FIN Prof SERVICE
 */

/**
 *  INSCRIPTION SERVICE
 */
$app->post('inscription', function (Request $request) {
    $data = json_decode($request->getContent(), true);
    $commande = CreateInscriptionCommand::init($data);

    $inscriptionApplication = new InscriptionApplication();
    $inscriptionApplication->create($commande);
    return created("");
});

$app->patch('inscription/{id}', function ($id,Request $request) {
    $data = json_decode($request->getContent(), true);
    $commande = UpdateInscriptionCommand::init($id,$data);

    $inscriptionApplication = new InscriptionApplication();
    $inscriptionApplication->update($commande);
    return ok("");
});

$app->patch('inscription/{id}/cours', function ($id,Request $request) {
    $data = json_decode($request->getContent(), true);
    $commande = AddCoursInscriptionCommand::init($id,$data);

    $inscriptionApplication = new InscriptionApplication();
    $inscriptionApplication->addCours($commande);
    return ok("");
});

$app->patch('inscription/{id}/paiement', function ($id,Request $request) {
    $data = json_decode($request->getContent(), true);
    $commande = UpdatePaiementInscriptionCommand::init($id,$data);

    $inscriptionApplication = new InscriptionApplication();
    $inscriptionApplication->updatePaiement($commande);
    return ok("");
});

$app->patch('inscription/{id}/cours/remove', function ($id,Request $request) {
    $data = json_decode($request->getContent(), true);
    $commande = RemoveCoursInscriptionCommand::init($id,$data);

    $inscriptionApplication = new InscriptionApplication();
    $inscriptionApplication->removeCours($commande);
    return ok("");
});

$app->get('adherent/{id}/inscription', function ($id) {

    $inscriptionApplication = new InscriptionApplication();
    return ok($inscriptionApplication->getByIdAdherent($id));
});

$app->get('adherent/{id}/inscription/{annee}', function ($id, $annee) {

    $inscriptionApplication = new InscriptionApplication();
    return ok($inscriptionApplication->getByIdAdherentAndAnnee($id,$annee));
});

/**
 *  FIN INSCRIPTION SERVICE
 */

/**
 *  ANNEE SERVICE
 */
$app->get('annee', function () {
    $anneApplication = new AnneeApplication();
    return ok($anneApplication->getAll());
});

$app->post('admin/saison', function (Request $request) {
    $data = json_decode($request->getContent(), true);
    $command = CreateAnneCommand::init($data);

    $anneApplication = new AnneeApplication();
    $anneApplication->create($command);
    return created("");
});

/**
 *  FIN ANNEE SERVICE
 */

/**
 *  MONTANT COURS SERVICE
 */
$app->get('montant', function () {
    $montantCoursService = new MontantCoursService();
    $montantCours = $montantCoursService->getAll();
    return ok($montantCours);
});

$app->post('montant', function (Request $request) {
    $data = json_decode($request->getContent(), true);
    $command = CreateMontantCoursCommand::init($data);

    $montantCoursApplication = new MontantCoursApplication();
    $montantCoursApplication->createMontantCours($command);
    return created("");
});

$app->patch('montant/{idMontant}', function ($idMontant,Request $request) {
    $data = json_decode($request->getContent(), true);
    $command = UpdateMontantCoursCommand::init($data);

    $montantCoursApplication = new MontantCoursApplication();
    $montantCoursApplication->updateMontantCours($idMontant ,$command);
    return ok("");
});

$app->delete('montant/{idMontant}', function ($idMontant) {
    $montantCoursApplication = new MontantCoursApplication();
    $montantCoursApplication->deleteMontantCours($idMontant );
    return ok("");
});

$app->get('inscription/{idInscription}/cours', function ($idInscription) {
    $coursApplication = new CoursApplication();

    return ok($coursApplication->getByIdInscription($idInscription));
});

/**
 *  FIN INSCRIPTION SERVICE
 */

/**
 *  STATISTIQUE SERVICE
 */

$app->get('statistique/adherent/annee', function () {
    $paiementApplication = new StatistiqueApplication();
    $stats = $paiementApplication->getAdherentByAnnee();
    return ok($stats);
});

$app->get('statistique/annee', function () {
    $paiementApplication = new StatistiqueApplication();
    $stats = $paiementApplication->getSatistiqueAnnee();
    return ok($stats);
});

$app->get('statistique/cours/heure', function () {
    $paiementApplication = new StatistiqueApplication();
    $stats = $paiementApplication->getRemplissageParDureeCours();
    return ok($stats);
});

$app->get('statistique/cours', function () {
    $paiementApplication = new StatistiqueApplication();
    $stats = $paiementApplication->getRemplissageCours();
    return ok($stats);
});

$app->get('statistique/age', function () {
    $paiementApplication = new StatistiqueApplication();
    $stats = $paiementApplication->getPyramideAge();
    return ok($stats);
});
/**
 *  FIN STATISTIQUE SERVICE
 */

/**
 *  EXTRACTION SERVICE
 */

$app->get('extraction/inscription', function () {
    $extractionApplication = new ExtractionApplication();
    $extraction = $extractionApplication->getAdherentInscri();
    return ok($extraction);
});

$app->get('extraction/cours', function () {
    $extractionApplication = new ExtractionApplication();
    $extraction = $extractionApplication->getAdherentInscriParCours();
    return ok($extraction);
});

/**
 *  FIN EXTRACTION SERVICE
 */


$app->run();

function created($content) {
    $response = new Response();
    $response->setStatusCode(201);
    $response->headers->set("Content-type","application/json");
    if ($content !== "") {
        $response->setContent(json_encode($content));
    }
    return $response;
}

function ok($content) {
    $response = new Response();
    $response->setStatusCode(200);
    $response->headers->set("Access-Control-Allow-Origin","*");
    $response->headers->set("Content-type","application/json");
    if ($content !== "") {
        $response->setContent(json_encode($content));
    }
    return $response;
}
