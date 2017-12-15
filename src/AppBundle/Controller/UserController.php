<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use AppBundle\Entity\Place;

class UserController extends Controller
{
    public function getUsersAction(Request $request)
    {

        $students = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Student')
            ->findAll();


        $formatted = array();

        foreach ($students as $student) {
            $formatted[] = array(
                'id' => $student->getId(),
                'firstname' => $student->getFirstname(),
                'lastname' => $student->getLastname(),
                'address1' => $student->getAddress1(),
                'address2' => $student->getAddress2(),
                'postcode' => $student->getPostcode(),
                'city' => $student->getCity(),
                'email' => $student->getEmail(),
                'phone' => $student->getPhone()
            );
        }

        return new JsonResponse($formatted);

    }

    public function getUserAction(Request $request)
    {

        $student = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Student')
            ->find($request->get('id'));

        if (empty($student)) {
            return new JsonResponse(['message' => "Student #{$request->get('id')} not found"], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(array(
            'id' => $student->getId(),
            'firstname' => $student->getFirstname(),
            'lastname' => $student->getLastname(),
            'address1' => $student->getAddress1(),
            'address2' => $student->getAddress2(),
            'postcode' => $student->getPostcode(),
            'city' => $student->getCity(),
            'email' => $student->getEmail(),
            'phone' => $student->getPhone()
        ));

    }

    public function deleteUserAction($id, Request $request)
    {

    }

    public function postUserAction(Request $request)
    {

    }

    public function putUserAction(Request $request)
    {

    }


}
