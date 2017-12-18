<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Student;

class StudentController extends Controller
{

    /**
     * LIST
     * @return Response
     */
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
                'address1' => $student->getAddress1(),
                'address2' => $student->getAddress2(),
                'postcode' => $student->getPostcode(),
                'city' => $student->getCity(),
                'email' => $student->getEmail(),
                'phone' => $student->getPhone()
            );
        }

        $response = $this->formatResponse($formatted);
        return $response;

    }

    /**
     * VIEW
     * @param Request $request
     * @return Response
     */
    public function getStudentAction(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(Student::class);

        $student = $repository->find($request->get('id'));

        if (empty($student)) {
            $response = $this->formatResponse(['message' => "Student #{$request->get('id')} not found"], Response::HTTP_NOT_FOUND);
            return $response;
        }

        $response = $this->formatResponse(
            array(
                'id' => $student->getId(),
                'firstname' => $student->getFirstname(),
                'lastname' => $student->getLastname(),
                'address1' => $student->getAddress1(),
                'address2' => $student->getAddress2(),
                'postcode' => $student->getPostcode(),
                'city' => $student->getCity(),
                'email' => $student->getEmail(),
                'phone' => $student->getPhone()
            )
        );

        return $response;

    }

    /**
     *
     * @param Request $request
     * @return Response
     */
    public function optionsStudentAction(Request $request)
    {
        $response = $this->formatResponse(array('message' => ''));
        return $response;
    }


    /**
     * DELETE A STUDENT
     * @param Request $request
     * @return Response
     */
    public function deleteStudentAction(Request $request)
    {
        $response = $this->formatResponse(array('message' => "Student #{$request->get('id')} deleted"));
        return $response;
    }

    /**
     * CREATE A STUDENT
     * @param Request $request
     * @return Response
     */
    public function putStudentAction(Request $request)
    {
        $response = $this->formatResponse(array('message' => "Student #{$request->get('id')} created"));
        return $response;
    }

    /**
     * UPDATE A STUDENT
     * @param Request $request
     * @return Response
     */
    public function patchStudentAction(Request $request)
    {
        $response = $this->formatResponse(array('message' => "Student #{$request->get('id')} updated"));
        return $response;
    }

    /**
     * SEND A JSON RESPONSE
     * @param $msg
     * @param null $status
     * @return Response
     */
    private function formatResponse($msg, $status = null)
    {
        $response = new Response();
        $response->setContent(json_encode($msg))->setStatusCode($status ?? Response::HTTP_OK);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Credentials', true);
        $response->headers->set('Allow', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');


        return $response;
    }

}
