<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Student;

class StudentController extends Controller
{
    public function getStudentsAction()
    {

        $repository = $this->getDoctrine()->getRepository(Student::class);

        $students = $repository->findAll();

        $formatted = array();

        foreach ($students as $student) {
            $formatted[] = array(
                'id' => $student->getId(),
                'firstname' => $student->getFirstname(),
                'lastname' => $student->getLastname(),
                'email' => $student->getEmail(),
                'phone' => $student->getPhone()
            );
        }

        return new JsonResponse($formatted);

    }

    public function getStudentAction(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(Student::class);

        $student = $repository->find($request->get('id'));

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

    public function deleteStudentAction(Request $request)
    {
        return new JsonResponse(array('message' => "Student #{$request->get('id')} deleted"), Response::HTTP_OK);
    }

    public function putStudentAction(Request $request)
    {
        return new JsonResponse(array('message' => "Student #{$request->get('id')} created"), Response::HTTP_OK);
    }

    public function patchStudentAction(Request $request)
    {
        return new JsonResponse(array('message' => "Student #{$request->get('id')} updated"), Response::HTTP_OK);
    }


}
