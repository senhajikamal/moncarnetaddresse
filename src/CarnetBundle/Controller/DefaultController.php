<?php
namespace CarnetBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CarnetBundle\Entity\Listes;
use CarnetBundle\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $connected=false;
        $error =false;
        if ($request->isMethod('POST'))
        {
            if(isset($_POST['submit_register']) ){ 
            
               
                $name=$_POST['name'];
                $firstname=$_POST['firstname'];
                $email=$_POST['email'];
                $username=$_POST['username'];
                $password=$_POST['password'];
                
                $userManager = $this->get('fos_user.user_manager');
                $user = $userManager->findUserByUsername($username);
                if ($user){$error="Username déjà utilisé !";}
                else{
                    $user = $userManager->findUserByEmail($email);
                    if ($user){$error="Email déjà utilisé !";}
                }
                if(!$error){
                    $user = $this->get('fos_user.util.user_manipulator')->create($username, $password, $email, 1, 0);
                    $user->setNom($name);
                    $user->setPrenom($firstname);
                    $userManager->updateUser($user);
                    
                    $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                    $this->get('security.context')->setToken($token);
                    $this->get('session')->set('_security_main',serialize($token));
                }
            }
            if(isset($_POST['submit_logout'])){ 
                $this->get('security.context')->setToken(null);
                $this->get('request')->getSession()->invalidate();
            }
        }
        if( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            $connected=true;   
        }
        $user = $this->container->get('security.context')->getToken()->getUser();
        $contacts = $this->getDoctrine()->getRepository('CarnetBundle\Entity\Contact')->findAll();
        return $this->container->get('templating')->renderResponse('CarnetBundle:Default:index.html.twig', array('error'=>$error,'is_connected'=>$connected,'contacts' => $contacts,'utilisateur'=>$user));
    }
    public function GetAction(Request $request)
    {
        if ($request->isMethod('POST'))
        {
            $user_id=11;
            $liste=$_POST['liste'];
            if ($liste != 'NULL'){
                // $contacts = $this->getDoctrine()->getRepository('CarnetBundle\Entity\Listes')->find($liste);
            }
            else{
                $utilisateur = $this->container->get('security.context')->getToken()->getUser();
                $contacts = $this->getDoctrine()->getRepository('CarnetBundle\Entity\Contact')->findByUser($utilisateur);
            }
            
            $carte = $this->renderView('CarnetBundle:Default:contact_carte.html.twig', array('contacts' => $contacts));
            $carte = utf8_encode($carte);
            $liste = $this->renderView('CarnetBundle:Default:contact_list.html.twig', array('contacts' => $contacts));
            $liste = utf8_encode($liste);
            $modale = $this->renderView('CarnetBundle:Default:contact_modale.html.twig', array('contacts' => $contacts));
            $modale = utf8_encode($modale);
  
            return new JsonResponse(array('carte' => $carte,'list' => $liste,'modale' => $modale));
        }
        
    }
    
    public function AjouterAction(Request $request)
    {
        //Si requête en POST
        if ($request->isMethod('POST'))
        {
            $new_nom=$_POST['new_nom'];
            $new_prenom=$_POST['new_prenom'];
            $new_tel=$_POST['new_tel'];
            $new_email=$_POST['new_email'];
            $new_adresse=$_POST['new_adresse'];
            $new_website=$_POST['new_website'];
            
            $utilisateur = $this->container->get('security.context')->getToken()->getUser();
            $contact = new Contact();
            $contact->setNom($new_nom);
            $contact->setPrenom($new_prenom);
            $contact->setIdUser($utilisateur);
            $contact->setEmail($new_email); 
            $contact->setAdresse($new_adresse); 
            $contact->setTel($new_tel); 
            $contact->setWebsite($new_website); 
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            
            $contacts =array('contact' => $contact);
            $carte = $this->renderView('CarnetBundle:Default:contact_carte.html.twig', array('contacts' => $contacts));
            $carte = utf8_encode($carte);
            $liste = $this->renderView('CarnetBundle:Default:contact_list.html.twig', array('contacts' => $contacts));
            $liste = utf8_encode($liste);
            $modale = $this->renderView('CarnetBundle:Default:contact_modale.html.twig', array('contacts' => $contacts));
            $modale = utf8_encode($modale);
            return new JsonResponse(array('carte' => $carte,'list' => $liste,'modale' => $modale));
        }
    }
    
    public function SupprimerAction(Request $request)
    {
        if ($request->isMethod('POST'))
        {
            $id_contact=$_POST['id_contact'];
            $is_ok=true;
            try {
                $em = $this->getDoctrine()->getManager();
                $contact = $em->getRepository('CarnetBundle\Entity\Contact')->find($id_contact);
                $em->remove($contact);
                $em->flush();
                } 
            catch (Exception $e) {
                    $is_ok=false;
                }
            return new JsonResponse(array('is_ok' => $is_ok));
        }
    }
    
    public function ModifierAction(Request $request)
    {
        if ($request->isMethod('POST'))
        {
            $id_contact=$_POST['id_contact'];
            $new_nom=$_POST['new_nom'];
            $new_prenom=$_POST['new_prenom'];
            $new_tel=$_POST['new_tel'];
            $new_email=$_POST['new_email'];
            $new_adresse=$_POST['new_adresse'];
            $new_website=$_POST['new_website'];

            
            $is_ok=true;
            try {
                $em = $this->getDoctrine()->getManager();
                $contact = $em->getRepository('CarnetBundle\Entity\Contact')->find($id_contact);
                $contact->setNom($new_nom);
                $contact->setPrenom($new_prenom);
                $contact->setEmail($new_email); 
                $contact->setAdresse($new_adresse); 
                $contact->setTel($new_tel); 
                $contact->setWebsite($new_website); 

                $em->flush();
            }
            catch (Exception $e) {
                    $is_ok=false;
                }
                
            $contacts =array('contact' => $contact);
            $carte = $this->renderView('CarnetBundle:Default:contact_carte.html.twig', array('contacts' => $contacts));
            $carte = utf8_encode($carte);
            $liste = $this->renderView('CarnetBundle:Default:contact_list.html.twig', array('contacts' => $contacts));
            $liste = utf8_encode($liste);
            $modale = $this->renderView('CarnetBundle:Default:contact_modale.html.twig', array('contacts' => $contacts));
            $modale = utf8_encode($modale);
        
            return new JsonResponse(array('is_ok' => $is_ok,'carte' => $carte,'list' => $liste,'modale' => $modale));
        }
    }
}
?>